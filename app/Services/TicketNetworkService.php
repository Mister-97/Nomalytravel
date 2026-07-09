<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TicketNetworkService
{
    private string $tokenUrl = 'https://key-manager.tn-apis.com/oauth2/token';
    private string $catalogBase = 'https://sandbox.tn-apis.com/catalog/v2';
    private string $mercuryBase = 'https://sandbox.tn-apis.com/mercury/v5';
    private string $consumerKey;
    private string $consumerSecret;
    private string $wcid;
    private string $wcidMercury;
    private string $bid;

    // Top-level nodes of the website category tree ("Website category" hierarchy).
    private const CATEGORY_SPORTS   = '.1859.1988.';
    private const CATEGORY_CONCERTS = '.1859.1986.';
    private const CATEGORY_THEATRE  = '.1859.1989.';

    // League keywords -> TN category paths. Game names ("Sky vs. Fever") never
    // contain the league name, so league searches must go through categories.
    // Order matters: 'wnba' must be checked before 'nba'.
    private const LEAGUE_PATHS = [
        'wnba'               => '.1859.1988.1865.1974.',
        'college basketball' => '.1859.1988.1865.1938.',
        'nba'                => '.1859.1988.1865.1971.',
        'college football'   => '.1859.1988.1879.1939.',
        'nfl'                => '.1859.1988.1879.1959.',
        'mlb'                => '.1859.1988.1864.1969.',
        'nhl'                => '.1859.1988.1883.1972.',
        'nwsl'               => '.1859.1988.1913.2104.',
        'mls'                => '.1859.1988.1913.1970.',
        'golf'               => '.1859.1988.1880.',
        'tennis'             => '.1859.1988.1916.',
        'boxing'             => '.1859.1988.1867.',
        'racing'             => '.1859.1988.1905.',
        'rodeo'              => '.1859.1988.1910.',
        // Generic sport-type words — checked last so a specific league match
        // (e.g. "college basketball") always wins first. These use the shared
        // parent node so e.g. "basketball" alone pulls NBA + WNBA + college hoops.
        'basketball'         => '.1859.1988.1865.',
        'football'           => '.1859.1988.1879.',
        'baseball'           => '.1859.1988.1864.',
        'hockey'             => '.1859.1988.1883.',
        'soccer'             => '.1859.1988.1913.',
    ];

    public function __construct()
    {
        $this->consumerKey    = config('services.ticketnetwork.consumer_key');
        $this->consumerSecret = config('services.ticketnetwork.consumer_secret');
        $this->wcid           = config('services.ticketnetwork.wcid', '23884');
        $this->wcidMercury    = config('services.ticketnetwork.wcid_mercury', '27886');
        $this->bid            = config('services.ticketnetwork.bid', '14126');
    }

    private function fetchToken(): string
    {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
            'Content-Type'  => 'application/x-www-form-urlencoded',
        ])->asForm()->post($this->tokenUrl, [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->failed()) {
            throw new \Exception('TicketNetwork auth failed: ' . $response->body());
        }

        return $response->json('access_token');
    }

    private function getToken(bool $fresh = false): string
    {
        if ($fresh) {
            Cache::forget('tn_access_token');
        }

        return Cache::remember('tn_access_token', 3300, fn () => $this->fetchToken());
    }

    private function request(string $endpoint, array $params = []): array
    {
        $send = fn (string $token) => Http::withHeaders([
            'Authorization'     => 'Bearer ' . $token,
            'X-Listing-Context' => 'website-config-id=' . $this->wcid,
            'Accept'            => 'application/json',
        ])->get($this->catalogBase . $endpoint, $params);

        $response = $send($this->getToken());

        // TN revokes a token whenever a new one is generated with the same
        // scopes, so a cached token can die early. Regenerate once and retry.
        if ($response->status() === 401) {
            $response = $send($this->getToken(true));
        }

        if ($response->failed()) {
            throw new \Exception('TicketNetwork API error: ' . $response->status());
        }

        return $response->json() ?? [];
    }

    // OData string literals escape single quotes by doubling them.
    private function odataString(string $value): string
    {
        return "'" . str_replace("'", "''", $value) . "'";
    }

    private function buildFilter(string $categoryPath, array $params): string
    {
        $keyword    = trim($params['keyword'] ?? '');
        $leaguePath = null;
        if ($keyword !== '') {
            foreach (self::LEAGUE_PATHS as $league => $path) {
                if (str_contains(mb_strtolower($keyword), $league)) {
                    $leaguePath = $path;
                    break;
                }
            }
        }

        $clauses = ["startswith(defaultCategory/path," . $this->odataString($leaguePath ?? $categoryPath) . ")"];

        if (!empty($params['city'])) {
            $clauses[] = 'contains(city/text/name,' . $this->odataString($params['city']) . ')';
        }
        if ($keyword !== '' && $leaguePath === null) {
            $clauses[] = 'contains(text/name,' . $this->odataString($keyword) . ')';
        }

        $from = $params['date_from'] ?? date('Y-m-d');
        $clauses[] = "date/datetime ge {$from}T00:00:00Z";

        if (!empty($params['date_to'])) {
            $clauses[] = "date/datetime le {$params['date_to']}T23:59:59Z";
        }

        return implode(' and ', $clauses);
    }

    // Sub-category (depth 2 of the website tree), e.g. "BASKETBALL" for a WNBA game.
    private function subCategoryName(array $event): ?string
    {
        $dc = $event['defaultCategory'] ?? [];
        if (($dc['depth'] ?? 0) === 2) {
            return $dc['text']['name'] ?? null;
        }
        foreach ($dc['ancestors'] ?? [] as $a) {
            if (($a['depth'] ?? 0) === 2) {
                return $a['text']['name'] ?? null;
            }
        }
        return null;
    }

    // TN has no event images, so cards use our own per-sport photos. The views
    // fall back to an icon placeholder via onerror when the file is missing.
    private function categoryImage(?string $subCategory, string $categoryLabel): string
    {
        $known = ['basketball', 'baseball', 'football', 'hockey', 'soccer', 'boxing', 'golf', 'tennis', 'racing'];
        $slug  = strtolower(preg_replace('/[^a-z]/i', '', $subCategory ?? ''));
        if (!in_array($slug, $known)) {
            $slug = strtolower($categoryLabel);
        }
        return asset('images/tickets/' . $slug . '.jpg');
    }

    private function normalizeEvent(array $event, string $category): array
    {
        $performers = [];
        foreach ($event['performers'] ?? [] as $p) {
            $performers[] = ['name' => $p['name'] ?? ''];
        }

        $sub = $this->subCategoryName($event);

        return [
            'id'         => $event['id'] ?? null,
            'name'       => $event['text']['name'] ?? '',
            'date'       => $event['date']['datetime'] ?? '',
            'venue'      => [
                'name' => $event['venue']['text']['name'] ?? '',
                'city' => $event['city']['text']['name'] ?? '',
            ],
            'performers' => $performers,
            'category'   => [
                'path' => $category,
                'name' => $sub ? ucwords(strtolower($sub)) : $category,
            ],
            'tickets'    => ['ticketcount' => $event['_metadata']['ticketCount'] ?? 0],
            'price_from' => $event['pricingInfo']['lowPrice']['text']['formatted'] ?? null,
            'image'      => $this->categoryImage($sub, $category),
            'url'        => !empty($event['id']) ? route('tickets.event', ['id' => $event['id']]) : '',
            'source'     => 'ticketnetwork',
        ];
    }

    private function searchEvents(string $categoryPath, string $categoryLabel, array $params): array
    {
        try {
            $data = $this->request('/events', [
                'filter'  => $this->buildFilter($categoryPath, $params),
                'sort'    => 'date/datetime',
                'perPage' => 40,
            ]);

            $events = [];
            foreach ($data['results'] ?? [] as $event) {
                $events[] = $this->normalizeEvent($event, $categoryLabel);
            }
            return ['events' => $events, 'error' => null];
        } catch (\Exception $e) {
            return ['events' => [], 'error' => $e->getMessage()];
        }
    }

    public function getSportsEvents(array $params = []): array
    {
        return $this->searchEvents(self::CATEGORY_SPORTS, 'Sports', $params);
    }

    public function getConcertEvents(array $params = []): array
    {
        return $this->searchEvents(self::CATEGORY_CONCERTS, 'Concerts', $params);
    }

    private function topCategoryLabel(array $event): string
    {
        $path = $event['defaultCategory']['path'] ?? '';
        if (str_starts_with($path, self::CATEGORY_SPORTS))   return 'Sports';
        if (str_starts_with($path, self::CATEGORY_CONCERTS)) return 'Concerts';
        if (str_starts_with($path, self::CATEGORY_THEATRE))  return 'Theatre';
        return 'Event';
    }

    // Single events fetched by id (/events/{id}) come back without the embedded
    // venue/city objects, so look the event up through the list endpoint instead.
    public function getEvent(int $id): ?array
    {
        $data  = $this->request('/events', ['filter' => 'id eq ' . $id, 'perPage' => 1]);
        $event = $data['results'][0] ?? null;

        return $event ? $this->normalizeEvent($event, $this->topCategoryLabel($event)) : null;
    }

    // ------------------------------------------------------------------
    // Mercury API (inventory + purchasing). Same OAuth token as Catalog but
    // a different identity header: website-config-id + broker-id pair.
    // ------------------------------------------------------------------

    private function mercuryRequest(string $method, string $endpoint, array $query = [], ?array $body = null): array
    {
        $send = function (string $token) use ($method, $endpoint, $query, $body) {
            $client = Http::withHeaders([
                'Authorization'      => 'Bearer ' . $token,
                'X-Identity-Context' => 'website-config-id=' . $this->wcidMercury . ',broker-id=' . $this->bid,
                'Accept'             => 'application/json',
            ]);

            return strtolower($method) === 'post'
                ? $client->post($this->mercuryBase . $endpoint, $body ?? [])
                : $client->get($this->mercuryBase . $endpoint, $query);
        };

        $response = $send($this->getToken());

        if ($response->status() === 401) {
            $response = $send($this->getToken(true));
        }

        if ($response->failed()) {
            // Mercury errors carry a useful "message" (and sometimes field-level
            // validationErrors) — surface those instead of a bare status code.
            $json = $response->json();
            $msg  = $json['message'] ?? $response->body();
            if (!empty($json['validationErrors'])) {
                $msg .= ' ' . json_encode($json['validationErrors']);
            }
            throw new \Exception('TicketNetwork Mercury error (' . $response->status() . '): ' . $msg);
        }

        return $response->json() ?? [];
    }

    public function getTicketGroups(int $eventId): array
    {
        $data = $this->mercuryRequest('GET', '/ticketgroups', ['eventId' => $eventId]);

        $groups = [];
        foreach ($data['ticketGroups'] ?? [] as $tg) {
            // Skip our own listings and anything that can't be bought.
            if (!empty($tg['mine']) || (int) ($tg['availableQuantity'] ?? 0) < 1) {
                continue;
            }
            $groups[] = [
                'id'               => $tg['exchangeTicketGroupId'] ?? null,
                'section'          => $tg['standardSection'] ?? ($tg['seats']['section'] ?? ''),
                'row'              => $tg['seats']['row'] ?? '',
                'available'        => (int) ($tg['availableQuantity'] ?? 0),
                'quantities'       => $tg['purchasableQuantities'] ?? [],
                'price'            => (float) ($tg['unitPrice']['retailPrice']['value'] ?? 0),
                'wholesale'        => (float) ($tg['unitPrice']['wholesalePrice']['value'] ?? 0),
                'currency'         => $tg['unitPrice']['retailPrice']['currencyCode'] ?? 'USD',
                'delivery_methods' => $tg['deliveryMethods'] ?? [],
                'type'             => $tg['ticketGroupType']['description'] ?? 'Event Ticket',
                'notes'            => $tg['notes'] ?? '',
            ];
        }

        usort($groups, fn ($a, $b) => $a['price'] <=> $b['price']);

        return $groups;
    }

    public function findTicketGroup(int $eventId, int $ticketGroupId): ?array
    {
        foreach ($this->getTicketGroups($eventId) as $tg) {
            if ((int) $tg['id'] === $ticketGroupId) {
                return $tg;
            }
        }
        return null;
    }

    // Places a real order with TN. lockRequestId/buyRequestId are client-side
    // idempotency GUIDs (Mercury validates them as required fields, no separate
    // lock endpoint exists on this API version).
    public function placeOrder(array $ticketGroup, int $quantity, array $buyer): array
    {
        $payload = [
            'lockRequestId'         => (string) \Illuminate\Support\Str::uuid(),
            'buyRequestId'          => (string) \Illuminate\Support\Str::uuid(),
            'exchangeTicketGroupId' => (int) $ticketGroup['id'],
            'quantity'              => $quantity,
            'unitPrice'             => [
                'value'        => $ticketGroup['wholesale'] ?: $ticketGroup['price'],
                'currencyCode' => $ticketGroup['currency'],
            ],
            'delivery' => [
                'method' => $ticketGroup['delivery_methods'][0] ?? 'E-Ticket',
                'email'  => $buyer['email'],
                'phone'  => $buyer['phone'],
            ],
            'billing' => [
                'firstName' => $buyer['first_name'],
                'lastName'  => $buyer['last_name'],
                'email'     => $buyer['email'],
                'phone'     => $buyer['phone'],
            ],
        ];

        return $this->mercuryRequest('POST', '/orders', [], $payload);
    }
}

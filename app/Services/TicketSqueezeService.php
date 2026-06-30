<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TicketSqueezeService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.ticketsqueeze.com/v1';

    // Fallback images per sport/category keyword — reliable Wikimedia URLs
    protected array $categoryImages = [
        'nhl'        => 'https://images.unsplash.com/photo-1515703407324-5f753afd8be8?w=600&q=80',
        'hockey'     => 'https://images.unsplash.com/photo-1515703407324-5f753afd8be8?w=600&q=80',
        'nba'        => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=600&q=80',
        'basketball' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=600&q=80',
        'nfl'        => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=600&q=80',
        'football'   => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=600&q=80',
        'mlb'        => 'https://images.unsplash.com/photo-1566206091558-7f218b696731?w=600&q=80',
        'baseball'   => 'https://images.unsplash.com/photo-1566206091558-7f218b696731?w=600&q=80',
        'mls'        => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=600&q=80',
        'soccer'     => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?w=600&q=80',
        'ufc'        => 'https://images.unsplash.com/photo-1555597673-b21d5c935865?w=600&q=80',
        'mma'        => 'https://images.unsplash.com/photo-1555597673-b21d5c935865?w=600&q=80',
        'boxing'     => 'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=600&q=80',
        'golf'       => 'https://images.unsplash.com/photo-1587174486073-ae5e5cff23aa?w=600&q=80',
        'tennis'     => 'https://images.unsplash.com/photo-1554068865-24cecd4e34b8?w=600&q=80',
        'rodeo'      => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600&q=80',
        'racing'     => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
        'concert'    => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=600&q=80',
        'music'      => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=600&q=80',
        'festival'   => 'https://images.unsplash.com/photo-1429962714451-bb934ecdc4ec?w=600&q=80',
        'broadway'   => 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=600&q=80',
        'theater'    => 'https://images.unsplash.com/photo-1503095396549-807759245b35?w=600&q=80',
        'classical'  => 'https://images.unsplash.com/photo-1465847899084-d164df4dedc6?w=600&q=80',
        'sports'     => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=600&q=80',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.ticketsqueeze.key', '');
    }

    public function hasKey(): bool
    {
        return !empty($this->apiKey);
    }

    protected function get(string $endpoint, array $params = []): array
    {
        if (!$this->hasKey()) {
            return ['success' => false, 'error' => 'no_key'];
        }
        try {
            $response = Http::timeout(12)
                ->withHeader('X-Api-Key', $this->apiKey)
                ->accept('application/json')
                ->get($this->baseUrl . $endpoint, $params);

            if ($response->failed()) {
                Log::error('TicketSqueeze API error', ['status' => $response->status()]);
                return ['success' => false, 'error' => 'api_error'];
            }
            return $response->json();
        } catch (\Exception $e) {
            Log::error('TicketSqueezeService: ' . $e->getMessage());
            return ['success' => false, 'error' => 'exception'];
        }
    }

    protected function getWikipediaImage(string $term): ?string
    {
        if (empty(trim($term))) return null;
        $slug = str_replace(' ', '_', trim($term));
        return Cache::remember('wiki_img_' . md5($term), 86400 * 7, function () use ($slug) {
            try {
                $resp = Http::timeout(4)
                    ->withHeader('User-Agent', 'NomalyTravel/1.0 (nomalytravel.com)')
                    ->get("https://en.wikipedia.org/api/rest_v1/page/summary/" . urlencode($slug));
                if ($resp->failed()) return null;
                return $resp->json()['thumbnail']['source'] ?? null;
            } catch (\Exception $e) {
                return null;
            }
        });
    }

    protected function getAudioDbImage(string $artist): ?string
    {
        if (empty(trim($artist))) return null;
        return Cache::remember('audiodb_img_' . md5($artist), 86400 * 7, function () use ($artist) {
            try {
                $resp = Http::timeout(4)
                    ->get('https://www.theaudiodb.com/api/v1/json/2/search.php', ['s' => $artist]);
                if ($resp->failed()) return null;
                $artists = $resp->json()['artists'] ?? [];
                return $artists[0]['strArtistThumb'] ?? null;
            } catch (\Exception $e) {
                return null;
            }
        });
    }

    protected function getCategoryFallback(string $categoryPath): string
    {
        $path = strtolower($categoryPath);
        foreach ($this->categoryImages as $keyword => $url) {
            if (str_contains($path, $keyword)) {
                return $url;
            }
        }
        return $this->categoryImages['sports'];
    }

    /**
     * Build a performer→image map for all unique performers in the event list.
     * This avoids duplicate API calls for the same performer across multiple events.
     */
    protected function buildPerformerImageMap(array $events, string $type): array
    {
        // Collect unique performer names (skip generic ones)
        $skip = ['stanley cup playoffs', 'nhl playoffs', 'nba playoffs', 'nfl playoffs',
                  'mlb playoffs', 'ufc fight night', 'ufc', 'nhl', 'nba', 'nfl', 'mlb', 'mls'];

        $performers = [];
        foreach ($events as $event) {
            foreach ($event['performers'] ?? [] as $p) {
                $name = trim($p['name'] ?? '');
                if ($name && !in_array(strtolower($name), $skip)) {
                    $performers[$name] = true;
                }
            }
            // Also queue venue names
            $venue = trim($event['venue']['name'] ?? '');
            if ($venue) $performers[$venue] = true;
        }

        $map = [];
        foreach (array_keys($performers) as $name) {
            $img = null;
            if ($type === 'concerts') {
                $img = $this->getAudioDbImage($name);
            }
            if (!$img) {
                $img = $this->getWikipediaImage($name);
            }
            if ($img) {
                $map[$name] = $img;
            }
        }
        return $map;
    }

    protected function enrichImages(array $events, string $type): array
    {
        $imgMap = $this->buildPerformerImageMap($events, $type);

        foreach ($events as &$event) {
            $imgUrl = null;

            // Try performers first
            foreach ($event['performers'] ?? [] as $p) {
                $name = trim($p['name'] ?? '');
                if ($name && isset($imgMap[$name])) {
                    $imgUrl = $imgMap[$name];
                    break;
                }
            }

            // Try venue
            if (!$imgUrl) {
                $venue = trim($event['venue']['name'] ?? '');
                if ($venue && isset($imgMap[$venue])) {
                    $imgUrl = $imgMap[$venue];
                }
            }

            // Category fallback — always shows something
            if (!$imgUrl) {
                $imgUrl = $this->getCategoryFallback($event['category']['path'] ?? '');
            }

            $event['image'] = $imgUrl;
        }
        unset($event);
        return $events;
    }

    protected function parseEvents(array $json, string $cityFilter = '', string $categoryType = ''): array
    {
        $raw = [];
        if (!empty($json['data']['data'])) {
            $raw = $json['data']['data'];
        } elseif (!empty($json['data']) && is_array($json['data'])) {
            $raw = $json['data'];
        }

        // Filter out events with no ticket inventory (tickets_only=true isn't always respected)
        $raw = array_values(array_filter($raw, function ($e) {
            $count = $e['tickets']['ticketcount'] ?? 0;
            return $count > 0;
        }));

        if ($categoryType === 'sports') {
            $raw = array_filter($raw, fn($e) => str_starts_with($e['category']['path'] ?? '', 'Sports'));
        } elseif ($categoryType === 'concerts') {
            $raw = array_filter($raw, function ($e) {
                $path = $e['category']['path'] ?? '';
                return str_starts_with($path, 'Concert')
                    || str_starts_with($path, 'Music')
                    || str_starts_with($path, 'Arts')
                    || str_starts_with($path, 'Theater')
                    || str_starts_with($path, 'Festival');
            });
        }

        // City passed to API query — no strict local filter needed

        return array_values($raw);
    }

    public function getSportsEvents(array $filters = []): array
    {
        $keyword = !empty($filters['keyword']) ? $filters['keyword'] : 'sports';
        $city    = $filters['city'] ?? '';
        $q       = $city ? $keyword . ' ' . $city : $keyword;

        $json = $this->get('/events/search', ['q' => $keyword, 'per_page' => 48, 'tickets_only' => true]);

        if (!($json['success'] ?? false)) {
            $err = $json['error'] ?? 'api_error';
            if ($err === 'no_key') return ['events' => [], 'error' => 'no_key'];
            return ['events' => [], 'error' => 'Unable to load live sports events. Please try again.'];
        }

        $events = $this->enrichImages($this->parseEvents($json, $city, 'sports'), 'sports');
        $events = $this->filterByDateRange($events, $filters);
        return ['events' => $events, 'error' => null];
    }

    public function getConcertEvents(array $filters = []): array
    {
        $keyword = !empty($filters['keyword']) ? $filters['keyword'] : 'concert';
        $city    = $filters['city'] ?? '';
        $q       = $city ? $keyword . ' ' . $city : $keyword;

        $json = $this->get('/events/search', ['q' => $keyword, 'per_page' => 48, 'tickets_only' => true]);

        if (!($json['success'] ?? false)) {
            $err = $json['error'] ?? 'api_error';
            if ($err === 'no_key') return ['events' => [], 'error' => 'no_key'];
            return ['events' => [], 'error' => 'Unable to load live concert events. Please try again.'];
        }

        $events = $this->enrichImages($this->parseEvents($json, $city, 'concerts'), 'concerts');
        $events = $this->filterByDateRange($events, $filters);
        return ['events' => $events, 'error' => null];
    }

    protected function filterByDateRange(array $events, array $filters): array
    {
        if (empty($filters['date_from'])) return $events;
        $from = \Carbon\Carbon::parse($filters['date_from'])->startOfDay();
        $to   = !empty($filters['date_to'])
            ? \Carbon\Carbon::parse($filters['date_to'])->endOfDay()
            : null;
        return array_values(array_filter($events, function ($e) use ($from, $to) {
            if (empty($e['date'])) return true;
            try {
                $d = \Carbon\Carbon::parse($e['date']);
                return $to ? $d->between($from, $to) : $d->gte($from);
            } catch (\Exception $ex) { return true; }
        }));
    }
}

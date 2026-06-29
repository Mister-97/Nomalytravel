<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TicketNetworkService
{
    private string $tokenUrl = 'https://key-manager.tn-apis.com/oauth2/token';
    private string $catalogBase = 'https://www.tn-apis.com/catalog/v2';
    private string $consumerKey;
    private string $consumerSecret;
    private string $wcid;
    private string $bid;

    public function __construct()
    {
        $this->consumerKey    = config('services.ticketnetwork.consumer_key');
        $this->consumerSecret = config('services.ticketnetwork.consumer_secret');
        $this->wcid           = config('services.ticketnetwork.wcid', '23884');
        $this->bid            = config('services.ticketnetwork.bid', '14126');
    }

    private function getToken(): string
    {
        return Cache::remember('tn_access_token', 3500, function () {
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
        });
    }

    private function request(string $endpoint, array $params = []): array
    {
        $token = $this->getToken();

        $response = Http::withHeaders([
            'Authorization'      => 'Bearer ' . $token,
            'X-Identity-Context' => $this->wcid,
        ])->get($this->catalogBase . $endpoint, $params);

        if ($response->failed()) {
            throw new \Exception('TicketNetwork API error: ' . $response->status());
        }

        return $response->json() ?? [];
    }

    private function normalizeEvent(array $event, string $category): array
    {
        $performers = [];
        foreach ($event['performers'] ?? [] as $p) {
            $performers[] = ['name' => $p['name'] ?? ''];
        }

        return [
            'name'       => $event['name'] ?? '',
            'date'       => $event['eventDateTime'] ?? '',
            'venue'      => ['name' => $event['venue']['name'] ?? '', 'city' => $event['venue']['city'] ?? ''],
            'performers' => $performers,
            'category'   => ['path' => $category],
            'tickets'    => ['ticketcount' => $event['availableTicketCount'] ?? 0],
            'image'      => $event['imageUrl'] ?? '',
            'url'        => $event['eventUrl'] ?? '',
            'source'     => 'ticketnetwork',
        ];
    }

    public function getSportsEvents(array $params = []): array
    {
        try {
            $query = [
                'categoryId' => 3,
                'pageSize'   => 40,
            ];
            if (!empty($params['city']))    $query['city']    = $params['city'];
            if (!empty($params['keyword'])) $query['keyword'] = $params['keyword'];
            if (!empty($params['date']))    $query['dateFrom'] = $params['date'];

            $data   = $this->request('/events', $query);
            $events = [];
            foreach ($data['events'] ?? [] as $event) {
                $events[] = $this->normalizeEvent($event, 'Sports');
            }
            return ['events' => $events, 'error' => null];
        } catch (\Exception $e) {
            return ['events' => [], 'error' => $e->getMessage()];
        }
    }

    public function getConcertEvents(array $params = []): array
    {
        try {
            $query = [
                'categoryId' => 1,
                'pageSize'   => 40,
            ];
            if (!empty($params['city']))    $query['city']    = $params['city'];
            if (!empty($params['keyword'])) $query['keyword'] = $params['keyword'];
            if (!empty($params['date']))    $query['dateFrom'] = $params['date'];

            $data   = $this->request('/events', $query);
            $events = [];
            foreach ($data['events'] ?? [] as $event) {
                $events[] = $this->normalizeEvent($event, 'Concerts');
            }
            return ['events' => $events, 'error' => null];
        } catch (\Exception $e) {
            return ['events' => [], 'error' => $e->getMessage()];
        }
    }
}

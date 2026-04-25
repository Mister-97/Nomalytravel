<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TicketmasterService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://app.ticketmaster.com/discovery/v2/';

    public function __construct()
    {
        $this->apiKey = config('services.ticketmaster.key', '');
    }

    public function hasKey(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Parse "City, ST" format into ['city' => 'City', 'stateCode' => 'ST'].
     * Handles inputs like "New York, NY", "New York NY", or just "New York".
     */
    protected function parseCity(string $city): array
    {
        $city = trim($city);
        // Match "City, ST" or "City ST" at end of string
        if (preg_match('/^(.+?),?\s+([A-Z]{2})$/', $city, $m)) {
            return ['city' => trim($m[1]), 'stateCode' => strtoupper($m[2])];
        }
        return ['city' => $city, 'stateCode' => null];
    }

    /**
     * Fetch events from Ticketmaster Discovery API.
     *
     * @param  array  $params  Ticketmaster query params (classificationName, keyword, city, startDateTime, etc.)
     * @param  int    $size    Number of results (max 200 per API)
     * @return array  ['events' => [...], 'error' => null|string, 'total' => int]
     */
    public function getEvents(array $params = [], int $size = 20): array
    {
        if (!$this->hasKey()) {
            return ['events' => [], 'error' => 'no_key', 'total' => 0];
        }

        try {
            $response = Http::timeout(12)->get($this->baseUrl . 'events.json', array_merge([
                'apikey'      => $this->apiKey,
                'size'        => $size,
                'sort'        => 'date,asc',
                'countryCode' => 'US',
            ], $params));

            if ($response->failed()) {
                $status = $response->status();
                $body   = $response->body();
                Log::error('Ticketmaster API error', ['status' => $status, 'body' => substr($body, 0, 500)]);

                if ($status === 401) {
                    return ['events' => [], 'error' => 'Invalid Ticketmaster API key. Check TICKETMASTER_KEY in .env.', 'total' => 0];
                }
                if ($status === 429) {
                    return ['events' => [], 'error' => 'Ticketmaster rate limit reached. Please wait a moment and try again.', 'total' => 0];
                }
                return ['events' => [], 'error' => 'Unable to load live events. Please try again.', 'total' => 0];
            }

            $data   = $response->json();
            $events = $data['_embedded']['events'] ?? [];
            $total  = $data['page']['totalElements'] ?? count($events);

            return ['events' => $events, 'error' => null, 'total' => $total];

        } catch (\Exception $e) {
            Log::error('TicketmasterService exception: ' . $e->getMessage());
            return ['events' => [], 'error' => 'Unable to load live events. Please try again.', 'total' => 0];
        }
    }

    /**
     * Get live sports events with optional city, keyword, and date filters.
     */
    public function getSportsEvents(array $filters = []): array
    {
        $params = ['classificationName' => 'sports'];

        if (!empty($filters['city'])) {
            $parsed = $this->parseCity($filters['city']);
            $params['city'] = $parsed['city'];
            if ($parsed['stateCode']) $params['stateCode'] = $parsed['stateCode'];
        }

        if (!empty($filters['keyword'])) {
            $params['keyword'] = $filters['keyword'];
        }

        if (!empty($filters['date'])) {
            $params['startDateTime'] = $filters['date'] . 'T00:00:00Z';
            // End of that day
            $params['endDateTime'] = $filters['date'] . 'T23:59:59Z';
        }

        return $this->getEvents($params, 24);
    }

    /**
     * Get live concert/music events with optional city, keyword, and date filters.
     */
    public function getConcertEvents(array $filters = []): array
    {
        $params = ['classificationName' => 'music'];

        if (!empty($filters['city'])) {
            $parsed = $this->parseCity($filters['city']);
            $params['city'] = $parsed['city'];
            if ($parsed['stateCode']) $params['stateCode'] = $parsed['stateCode'];
        }

        if (!empty($filters['keyword'])) {
            $params['keyword'] = $filters['keyword'];
        }

        if (!empty($filters['date'])) {
            $params['startDateTime'] = $filters['date'] . 'T00:00:00Z';
            $params['endDateTime']   = $filters['date'] . 'T23:59:59Z';
        }

        return $this->getEvents($params, 24);
    }
}

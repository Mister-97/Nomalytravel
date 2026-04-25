<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HotelbedsService
{
    protected string $apiKey;
    protected string $secret;
    protected string $baseUrl;

    /**
     * Hotelbeds destination codes (from their content API catalogue).
     * These are Hotelbeds-specific codes, NOT IATA airport codes.
     */
    protected array $cityMap = [
        // USA
        'new york'      => 'NYC', 'nyc'           => 'NYC', 'new york city' => 'NYC',
        'miami'         => 'MIA',
        'chicago'       => 'CHI',
        'las vegas'     => 'LAS', 'vegas'         => 'LAS',
        'orlando'       => 'ORL',
        'los angeles'   => 'LAX', 'la'            => 'LAX',
        'san francisco' => 'SFO', 'sf'            => 'SFO',
        'washington dc' => 'WAS', 'washington'    => 'WAS', 'dc' => 'WAS',
        'boston'        => 'BOS',
        'atlanta'       => 'ATL',
        'seattle'       => 'SEA',
        'dallas'        => 'DAL',
        'houston'       => 'HOU',
        'phoenix'       => 'PHX',
        'denver'        => 'DEN',
        'nashville'     => 'BNA',
        'new orleans'   => 'MSY',
        // International
        'cancun'        => 'CUN',
        'london'        => 'LON',
        'paris'         => 'PAR',
        'madrid'        => 'MAD',
        'barcelona'     => 'BCN',
        'rome'          => 'ROM',
        'dubai'         => 'DXB',
        'tokyo'         => 'TYO',
        'bangkok'       => 'BKK',
        'amsterdam'     => 'AMS',
        'lisbon'        => 'LIS',
        'prague'        => 'PRG',
        'vienna'        => 'VIE',
        'istanbul'      => 'IST',
        'singapore'     => 'SIN',
    ];

    public function __construct()
    {
        $this->apiKey  = config('services.hotelbeds.api_key', '');
        $this->secret  = config('services.hotelbeds.secret', '');
        $this->baseUrl = rtrim(config('services.hotelbeds.base_url', 'https://api.test.hotelbeds.com'), '/');
    }

    public function hasKey(): bool
    {
        return !empty($this->apiKey) && !empty($this->secret);
    }

    /**
     * Generate HMAC-SHA256 signature as required by Hotelbeds:
     * SHA256(ApiKey + SharedSecret + UnixTimestampInSeconds)
     */
    protected function getSignature(): string
    {
        $timestamp = (string) time();
        return hash('sha256', $this->apiKey . $this->secret . $timestamp);
    }

    protected function resolveDestinationCode(string $city): string
    {
        $key = strtolower(trim($city));
        return $this->cityMap[$key] ?? strtoupper(substr(trim($city), 0, 3));
    }

    /**
     * Search hotels via Hotelbeds Hotel Availability API.
     *
     * @param array $params  Keys: city, check_in, check_out, adults, rooms, min_price, max_price
     * @param int   $limit   Max results to return
     * @return array  ['hotels' => [...], 'error' => null|string, 'total' => int]
     */
    public function searchHotels(array $params = [], int $limit = 20): array
    {
        if (!$this->hasKey()) {
            return ['hotels' => [], 'error' => 'no_key', 'total' => 0];
        }

        $checkIn  = $params['check_in']  ?? date('Y-m-d', strtotime('+7 days'));
        $checkOut = $params['check_out'] ?? date('Y-m-d', strtotime('+9 days'));
        $adults   = max(1, (int) ($params['adults'] ?? 2));
        $rooms    = max(1, (int) ($params['rooms']  ?? 1));
        $city     = $params['city'] ?? $params['keyword'] ?? 'New York';
        $destCode = $this->resolveDestinationCode($city);

        $payload = [
            'stay' => [
                'checkIn'  => $checkIn,
                'checkOut' => $checkOut,
            ],
            'occupancies' => [[
                'rooms'    => $rooms,
                'adults'   => $adults,
                'children' => 0,
            ]],
            'destination' => ['code' => $destCode],
            'filter'      => ['maxHotels' => $limit],
        ];

        if (!empty($params['min_price']) || !empty($params['max_price'])) {
            if (!empty($params['min_price'])) $payload['filter']['minRate'] = (float) $params['min_price'];
            if (!empty($params['max_price'])) $payload['filter']['maxRate'] = (float) $params['max_price'];
        }

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'Api-key'      => $this->apiKey,
                    'X-Signature'  => $this->getSignature(),
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/hotel-api/1.0/hotels', $payload);

            $httpStatus = $response->status();
            $body       = $response->json() ?? [];

            if ($response->failed()) {
                $apiError = $body['error'] ?? ($body['message'] ?? 'Unknown error');

                Log::error('Hotelbeds API error', [
                    'http_status'    => $httpStatus,
                    'api_error'      => $apiError,
                    'destination'    => $destCode,
                    'check_in'       => $checkIn,
                    'check_out'      => $checkOut,
                    'api_key_prefix' => substr($this->apiKey, 0, 8) . '...',
                    'base_url'       => $this->baseUrl,
                ]);

                if ($httpStatus === 403) {
                    return [
                        'hotels' => [],
                        'error'  => 'hotelbeds_403',
                        'detail' => $apiError,
                        'total'  => 0,
                    ];
                }

                if ($httpStatus === 401) {
                    return ['hotels' => [], 'error' => 'Invalid Hotelbeds credentials. Check HOTELBEDS_API_KEY and HOTELBEDS_SECRET in .env.', 'total' => 0];
                }

                return ['hotels' => [], 'error' => "Hotelbeds API error (HTTP $httpStatus): $apiError", 'total' => 0];
            }

            $hotels = array_slice($body['hotels']['hotels'] ?? [], 0, $limit);
            $total  = $body['hotels']['total'] ?? count($hotels);

            Log::info('Hotelbeds search success', [
                'destination' => $destCode,
                'total'       => $total,
                'returned'    => count($hotels),
            ]);

            return ['hotels' => $hotels, 'error' => null, 'total' => $total, 'destination' => $destCode];

        } catch (\Exception $e) {
            Log::error('HotelbedsService exception', [
                'message'     => $e->getMessage(),
                'destination' => $destCode ?? 'unknown',
            ]);
            return ['hotels' => [], 'error' => 'Unable to connect to Hotelbeds API. Please try again.', 'total' => 0];
        }
    }

    /**
     * Return city → destination code map for the search form dropdown.
     */
    public function getCityOptions(): array
    {
        return [
            'New York'      => 'NYC',
            'Miami'         => 'MIA',
            'Chicago'       => 'CHI',
            'Las Vegas'     => 'LAS',
            'Orlando'       => 'ORL',
            'Los Angeles'   => 'LAX',
            'San Francisco' => 'SFO',
            'Washington DC' => 'WAS',
            'Boston'        => 'BOS',
            'Atlanta'       => 'ATL',
            'Cancun'        => 'CUN',
            'London'        => 'LON',
            'Paris'         => 'PAR',
            'Barcelona'     => 'BCN',
            'Rome'          => 'ROM',
            'Dubai'         => 'DXB',
            'Bangkok'       => 'BKK',
            'Singapore'     => 'SIN',
        ];
    }
}

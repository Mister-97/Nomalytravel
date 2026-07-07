<?php

namespace App\Services;

use GuzzleHttp\Client;

class DuffelStaysService
{
    private Client $client;

    public function __construct()
    {
        $apiKey = widget(29)->extra_field_1;

        $this->client = new Client([
            'base_uri' => 'https://api.duffel.com/',
            'headers'  => [
                'Authorization'  => 'Bearer ' . $apiKey,
                'Duffel-Version' => 'v2',
                'Accept'         => 'application/json',
                'Content-Type'   => 'application/json',
            ],
        ]);
    }

    public function searchAccommodations(array $params): array
    {
        $payload = [
            'data' => [
                'check_in_date'  => $params['check_in_date'],
                'check_out_date' => $params['check_out_date'],
                'rooms'          => (int) ($params['rooms'] ?? 1),
                'guests'         => [
                    [
                        'type'  => 'adult',
                        'count' => (int) ($params['adults'] ?? 2),
                    ],
                ],
                'location' => [
                    'radius'    => 15,
                    'geographic_coordinates' => [
                        'latitude'  => (float) $params['latitude'],
                        'longitude' => (float) $params['longitude'],
                    ],
                ],
            ],
        ];

        $response = $this->client->post('stays/search', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    // Search-result rates expire with the result's expires_at; callers must
    // handle failures by prompting a fresh search.
    public function fetchAllRates(string $searchResultId): array
    {
        $response = $this->client->post("stays/search_results/{$searchResultId}/actions/fetch_all_rates", [
            'json' => ['data' => (object) []],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createQuote(string $rateId): array
    {
        $response = $this->client->post('stays/quotes', [
            'json' => ['data' => ['rate_id' => $rateId]],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createBooking(array $params): array
    {
        $payload = [
            'data' => [
                'quote_id'     => $params['quote_id'],
                'guests'       => $params['guests'],
                'email'        => $params['email'],
                'phone_number' => $params['phone_number'],
            ],
        ];

        if (!empty($params['metadata'])) {
            $payload['data']['metadata'] = $params['metadata'];
        }

        $response = $this->client->post('stays/bookings', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getBooking(string $bookingId): array
    {
        $response = $this->client->get("stays/bookings/{$bookingId}");
        return json_decode($response->getBody()->getContents(), true);
    }
}

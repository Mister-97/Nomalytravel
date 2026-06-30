<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DuffelStaysService
{
    private Client $client;

    public function __construct()
    {
        $apiKey = widget(29)->extra_field_1;

        $this->client = new Client([
            'base_uri' => 'https://api.duffel.com/',
            'headers'  => [
                'Authorization' => 'Bearer ' . $apiKey,
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
                    'radius'    => 80,
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

    public function getAccommodation(string $searchId, string $accommodationId): array
    {
        $response = $this->client->get("stays/search/{$searchId}/accommodation/{$accommodationId}");
        return json_decode($response->getBody()->getContents(), true);
    }

    public function createQuote(array $params): array
    {
        $payload = [
            'data' => [
                'accommodation_id' => $params['accommodation_id'],
                'rate_plan_id'     => $params['rate_plan_id'],
                'check_in_date'    => $params['check_in_date'],
                'check_out_date'   => $params['check_out_date'],
                'rooms'            => (int) ($params['rooms'] ?? 1),
                'guests'           => $params['guests'],
            ],
        ];

        $response = $this->client->post('stays/quotes', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function createReservation(array $params): array
    {
        $payload = [
            'data' => [
                'quote_id' => $params['quote_id'],
                'guests'   => $params['guests'],
                'payment'  => [
                    'type'     => 'balance',
                    'currency' => $params['currency'] ?? 'USD',
                    'amount'   => $params['amount'],
                ],
            ],
        ];

        $response = $this->client->post('stays/reservations', [
            'json' => $payload,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function getReservation(string $reservationId): array
    {
        $response = $this->client->get("stays/reservations/{$reservationId}");
        return json_decode($response->getBody()->getContents(), true);
    }
}

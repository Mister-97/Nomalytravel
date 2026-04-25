<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;
use App\Models\ModulesData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Hotels;
use App\Models\Flights;
use App\Mail\BookingStatusMail;
use Illuminate\Support\Facades\Mail;

class DuffelService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = widget(29)->extra_field_1;

        if (!$this->apiKey) {
            throw new \RuntimeException('Duffel API key not found');
        }

        $this->client = new Client([
            'base_uri' => 'https://api.duffel.com/',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Duffel-Version' => 'v2',
                'Authorization' => 'Bearer ' . $this->apiKey,
            ],
        ]);
    }

    public function getHotels($params)
    {
        try {
            $response = $this->client->post('stays/search', [
                'headers' => [
                    'Accept-Encoding' => 'gzip',
                    'Duffel-Version' => 'v2',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => $params,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            \Log::error('Duffel API Error (Hotels): ' . $e->getMessage());
            return ['error' => 'Failed to fetch hotels: ' . $e->getMessage()];
        } catch (\Exception $e) {
            \Log::error('Duffel Service Error (Hotels): ' . $e->getMessage());
            return ['error' => 'An unexpected error occurred while fetching hotels'];
        }
    }

    public function getLocationCode($location_name)
    {
        try {
            if (empty($location_name)) {
                \Log::error('Empty location name provided');
                return null;
            }

            \Log::info('Searching for location code: ' . $location_name);

            // First try exact match
            $response = $this->client->get('air/airports', [
                'query' => [
                    'query' => $location_name,
                    'limit' => 200, // Increase limit to get more results
                ],
                'headers' => [
                    'Accept-Encoding' => 'gzip',
                    'Duffel-Version' => 'v2',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            \Log::info('Duffel API Response for ' . $location_name . ': ' . json_encode($data));

            if (!empty($data['data'])) {
                // Try to find an exact match first
                foreach ($data['data'] as $airport) {
                    // Check for exact match with city name or airport name
                    if (strtolower($airport['city_name']) === strtolower($location_name) || strtolower($airport['name']) === strtolower($location_name) || strtolower($airport['iata_code']) === strtolower($location_name)) {
                        $iataCode = $airport['iata_code'] ?? null;
                        if ($iataCode) {
                            \Log::info('Found exact match IATA code for ' . $location_name . ': ' . $iataCode);
                            return $iataCode;
                        }
                    }
                }

                // If no exact match, try to find the best match
                foreach ($data['data'] as $airport) {
                    // Check for partial match in city name or airport name
                    if (strpos(strtolower($airport['city_name']), strtolower($location_name)) !== false || strpos(strtolower($airport['name']), strtolower($location_name)) !== false) {
                        $iataCode = $airport['iata_code'] ?? null;
                        if ($iataCode) {
                            \Log::info('Found partial match IATA code for ' . $location_name . ': ' . $iataCode);
                            return $iataCode;
                        }
                    }
                }

                // If still no match, try with city name only
                $cityResponse = $this->client->get('air/airports', [
                    'query' => [
                        'query' => $location_name . ' city',
                        'limit' => 200,
                    ],
                    'headers' => [
                        'Accept-Encoding' => 'gzip',
                        'Duffel-Version' => 'v2',
                        'Authorization' => 'Bearer ' . $this->apiKey,
                    ],
                ]);

                $cityData = json_decode($cityResponse->getBody()->getContents(), true);
                if (!empty($cityData['data'])) {
                    foreach ($cityData['data'] as $airport) {
                        if (strpos(strtolower($airport['city_name']), strtolower($location_name)) !== false) {
                            $iataCode = $airport['iata_code'] ?? null;
                            if ($iataCode) {
                                \Log::info('Found city match IATA code for ' . $location_name . ': ' . $iataCode);
                                return $iataCode;
                            }
                        }
                    }
                }
            }

            // Fallback to local database search if Duffel API doesn't find a perfect match or if needed
            $localAirport = \App\Models\Airport::where('iata_code', $location_name)->first();
            if ($localAirport) {
                \Log::info('Found local IATA code for ' . $location_name . ': ' . $localAirport->iata_code);
                return $localAirport->iata_code;
            }

            \Log::error('No location data found for: ' . $location_name);
            return null;
        } catch (ClientException $e) {
            \Log::error('Duffel API Error (Location): ' . $e->getMessage());
            \Log::error('Response body: ' . $e->getResponse()->getBody()->getContents());
            // Fallback to local database search on API error
            $localAirport = \App\Models\Airport::where('iata_code', $location_name)->first();
            if ($localAirport) {
                \Log::info('Found local IATA code for ' . $location_name . ' on API error: ' . $localAirport->iata_code);
                return $localAirport->iata_code;
            }
            return null;
        } catch (\Exception $e) {
            \Log::error('Duffel Service Error (Location): ' . $e->getMessage());
            // Fallback to local database search on service error
            $localAirport = \App\Models\Airport::where('iata_code', $location_name)->first();
            if ($localAirport) {
                \Log::info('Found local IATA code for ' . $location_name . ' on service error: ' . $localAirport->iata_code);
                return $localAirport->iata_code;
            }
            return null;
        }
    }

    /**
     * Extract a clean 3-letter IATA code from any input format:
     *   "Chicago (MDW)"  → "MDW"
     *   "Houston (HOU)"  → "HOU"
     *   "MDW"            → "MDW"
     *   "Chicago MDW"    → "MDW"
     */
    private function extractIATA(string $value): string
    {
        $v = strtoupper(trim($value));
        // Code in parentheses: "Chicago (MDW)" or "Chicago(MDW)"
        if (preg_match('/\(([A-Z]{3})\)/', $v, $m)) return $m[1];
        // Already a clean 3-letter code
        if (preg_match('/^[A-Z]{3}$/', $v)) return $v;
        // Code as last word: "Chicago MDW" or "New York JFK"
        if (preg_match('/\b([A-Z]{3})\s*$/', $v, $m)) return $m[1];
        // Return cleaned uppercase — let Duffel validate further
        return $v;
    }

    /**
     * Map any cabin class string to a valid Duffel value.
     * Returns null if unknown/empty so it can be omitted from payload.
     */
    private function normaliseCabin(?string $cabin): ?string
    {
        $map = [
            'economy'          => 'economy',
            'premium_economy'  => 'premium_economy',
            'premium economy'  => 'premium_economy',
            'business'         => 'business',
            'business_class'   => 'business',
            'business class'   => 'business',
            'first'            => 'first',
            'first_class'      => 'first',
            'first class'      => 'first',
        ];
        $key = strtolower(trim($cabin ?? ''));
        return $map[$key] ?? null;
    }

    public function getOfferRequests($params)
    {
        try {
            $tripType = $params['triptype'] ?? 'oneway';
            $passengers = [];

            for ($i = 0; $i < ($params['adults'] ?? 1); $i++) {
                $passengers[] = ['type' => 'adult'];
            }

            for ($i = 0; $i < ($params['children'] ?? 0); $i++) {
                $passengers[] = ['type' => 'child'];
            }

            for ($i = 0; $i < ($params['youth'] ?? 0); $i++) {
                $passengers[] = ['type' => 'child'];
            }

            for ($i = 0; $i < ($params['infants'] ?? 0); $i++) {
                $passengers[] = ['type' => 'infant_without_seat'];
            }

            $slices = [];
            $cabin = $this->normaliseCabin($params['cabin_class'] ?? null);

            if ($tripType === 'Multicity' && !empty($params['slices'])) {
                foreach ($params['slices'] as $slice) {
                    $rawFrom = $slice['from'] ?? '';
                    $rawTo   = $slice['to']   ?? '';
                    $rawDate = $slice['departure_date'] ?? $slice['travelling_date'] ?? null;
                    if (!$rawFrom || !$rawTo || !$rawDate) continue;
                    $slices[] = [
                        'origin'         => $this->extractIATA($rawFrom),
                        'destination'    => $this->extractIATA($rawTo),
                        'departure_date' => Carbon::parse($rawDate)->format('Y-m-d\T00:00:00.000\Z'),
                    ];
                }
            } else {
                $from_location = $params['slices'][0]['from'] ?? null;
                $to_location   = $params['slices'][0]['to']   ?? null;

                if (!$from_location || !$to_location) {
                    return ['error' => 'Please search and select valid origin and destination locations to view available flights.'];
                }

                // Extract clean IATA codes — handles "Chicago (MDW)", "MDW", "Chicago MDW"
                $origin      = $this->extractIATA($from_location);
                $destination = $this->extractIATA($to_location);

                $rawDate = $params['slices'][0]['departure_date'] ?? $params['slices'][0]['travelling_date'] ?? null;
                $travelling_date = !empty($rawDate)
                    ? Carbon::parse($rawDate)->format('Y-m-d\T00:00:00.000\Z')
                    : now()->addDay()->format('Y-m-d\T00:00:00.000\Z');

                $return_date = !empty($params['return_date'])
                    ? Carbon::parse($params['return_date'])->format('Y-m-d\T00:00:00.000\Z')
                    : null;

                $slices[] = [
                    'origin'         => $origin,
                    'destination'    => $destination,
                    'departure_date' => $travelling_date,
                ];

                if ($tripType === 'twoway' && $return_date) {
                    $slices[] = [
                        'origin'         => $destination,
                        'destination'    => $origin,
                        'departure_date' => $return_date,
                    ];
                }
            }
            $optionalParams = [];

            if (!empty($params['max_connections'])) {
                $optionalParams['max_connections'] = (int) $params['max_connections'];
            }

            // Never filter by airline — return all carriers on every route
            // (removed airline filter that was blocking certain carriers)

            $basePayload = [
                'slices'                   => $slices,
                'passengers'               => $passengers,
                'return_available_services' => true,
                'return_offers'            => true,
            ];
            // Only add cabin_class when it's a known valid value
            if ($cabin !== null) {
                $basePayload['cabin_class'] = $cabin;
            }

            $payload = [
                'data' => array_merge($basePayload, $optionalParams),
            ];

            \Log::info('Making offer request to Duffel', $payload);

            $response = $this->client->post('air/offer_requests', [
                'headers' => [
                    'Accept-Encoding' => 'gzip',
                    'Duffel-Version' => 'v2',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => $payload,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            if (empty($responseData['data']['offers'])) {
                return ['error' => 'No flight offers found for the given criteria'];
            }

            $offers = collect($responseData['data']['offers']);

            // Filter out test/fake airlines (e.g. Duffel Airways ZZ used in sandbox mode)
            // and obscure non-commercial carriers. Keep only IATA-code airlines with real names.
            $blockedAirlines = [
                'duffel airways',
                'test airline',
                'demo airline',
                'dummy airline',
                'sample airline',
                'zz',
            ];
            $offers = $offers->filter(function ($offer) use ($blockedAirlines) {
                $ownerName = strtolower($offer['owner']['name'] ?? '');
                $ownerIata = strtolower($offer['owner']['iata_code'] ?? '');
                foreach ($blockedAirlines as $blocked) {
                    if (str_contains($ownerName, $blocked) || $ownerIata === $blocked) {
                        return false;
                    }
                }
                return true;
            })->values();

            // Inject airline names for carriers that Duffel returns without a name
            $airlineMap = [
                'F9'=>'Frontier','NK'=>'Spirit','AA'=>'American Airlines',
                'UA'=>'United Airlines','DL'=>'Delta','WN'=>'Southwest',
                'B6'=>'JetBlue','AS'=>'Alaska Airlines','G4'=>'Allegiant',
                'SY'=>'Sun Country','HA'=>'Hawaiian Airlines','MX'=>'Breeze Airways',
                'XP'=>'Avelo Airlines','3M'=>'Silver Airways','OH'=>'PSA Airlines',
                '9E'=>'Endeavor Air','YX'=>'Republic Airways','OO'=>'SkyWest',
            ];

            $offers = $offers->map(function ($offer) use ($airlineMap) {
                $ownerIata = strtoupper($offer['owner']['iata_code'] ?? '');
                if (empty($offer['owner']['name']) && isset($airlineMap[$ownerIata])) {
                    $offer['owner']['name'] = $airlineMap[$ownerIata];
                }
                foreach ($offer['slices'] ?? [] as &$slice) {
                    foreach ($slice['segments'] ?? [] as &$seg) {
                        $ocIata = strtoupper($seg['operating_carrier']['iata_code'] ?? '');
                        if (empty($seg['operating_carrier']['name']) && isset($airlineMap[$ocIata])) {
                            $seg['operating_carrier']['name'] = $airlineMap[$ocIata];
                        }
                    }
                }
                return $offer;
            })->values();

            return $offers;
        } catch (ClientException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            $errorMessage = $errorResponse['errors'][0]['message'] ?? 'Failed to fetch flight offers from API';
            \Log::error('Duffel API Error (OfferRequests): ' . $errorMessage, ['exception' => $e]);
            return ['error' => 'Failed to fetch flight offers: ' . $errorMessage];
        } catch (\Exception $e) {
            \Log::error('Duffel Service Error (OfferRequests): ' . $e->getMessage(), ['exception' => $e]);
            return ['error' => 'An unexpected error occurred while fetching flight offers'];
        }
    }

    public function getFlights($params)
    {
        try {
            $from_location = $this->getLocationCode($params['keyword'] ?? '');
            $to_location = $this->getLocationCode($params['to_location'] ?? '');

            if (!$from_location || !$to_location) {
                return ['error' => 'Invalid location(s) provided.'];
            }

            // Format the travelling date
            $travelling_date = !empty($params['travelling_date']) ? Carbon::parse($params['travelling_date'])->format('Y-m-d\T00:00:00.000\Z') : now()->format('Y-m-d\T00:00:00.000\Z');

            // Format the return date, if it exists
            $return_date = !empty($params['return_date']) ? Carbon::parse($params['return_date'])->format('Y-m-d\T00:00:00.000\Z') : null;

            // Log return date to check if it's being passed
            \Log::info('Return Date: ' . $return_date);

            // Prepare the base offer request

            $offer_request_data = [
                'data' => [
                    'slices' => [
                        [
                            'origin' => $from_location,
                            'destination' => $to_location,
                            'departure_date' => $travelling_date,
                        ],
                    ],
                    'passengers' => [['type' => 'adult']],
                    'cabin_class' => $params['cabin_class'] ?? null,
                    'return_available_services' => true,
                ],
            ];

            // If it's a round-trip, add the return flight slice
            if ($return_date && $params['triptype'] == 'twoway') {
                \Log::info('Adding return flight slice with return date: ' . $return_date);

                $offer_request_data['data']['slices'][] = [
                    'origin' => $to_location,
                    'destination' => $from_location,
                    'departure_date' => $return_date,
                    'return_available_services' => true,
                ];
            }

            // Log the full request data being sent to the API
            \Log::info('Making offer request with params: ' . json_encode($offer_request_data));

            // Make the request to the Duffel API
            $response = $this->client->post('air/offer_requests', [
                'headers' => [
                    'Accept-Encoding' => 'gzip',
                    'Duffel-Version' => 'v2',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => $offer_request_data,
            ]);

            // Decode the response and return it
            $responseData = json_decode($response->getBody()->getContents(), true);
            return collect($responseData['data']['offers'])->take(10);
        } catch (ClientException $e) {
            \Log::error('Duffel API Error (Flights): ' . $e->getMessage());
            return ['error' => 'Failed to fetch flights: ' . $e->getMessage()];
        } catch (\Exception $e) {
            \Log::error('Duffel Service Error (Flights): ' . $e->getMessage());
            return ['error' => 'An unexpected error occurred while fetching flights'];
        }
    }

    public function searchAirports($query)
    {
        try {
            if (empty($query) || strlen(trim($query)) < 2) {
                return [];
            }
            $queryLower = strtolower(trim($query));
            $queryUpper = strtoupper(trim($query));

            $airports = \App\Models\Airport::whereIn('type', ['large_airport', 'medium_airport'])
                ->where(function ($q) use ($queryLower, $queryUpper) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . $queryLower . '%'])
                      ->orWhereRaw('LOWER(city) LIKE ?', ['%' . $queryLower . '%'])
                      ->orWhere('iata_code', $queryUpper)
                      ->orWhereRaw('LOWER(iata_code) LIKE ?', [$queryLower . '%']);
                })
                ->orderByRaw("CASE WHEN iata_code = ? THEN 0 WHEN type = 'large_airport' THEN 1 ELSE 2 END", [$queryUpper])
                ->limit(20)
                ->get();

            $grouped = $airports->groupBy('city');
            $results = [];

            foreach ($grouped->take(6) as $city => $cityAirports) {
                $firstAirport = $cityAirports->first();
                $mainAirport  = $cityAirports->firstWhere('type', 'large_airport') ?? $firstAirport;
                $country      = $firstAirport->country;
                $airportCount = $cityAirports->count();

                $results[] = [
                    'itemType'    => 'city',
                    'label'       => $city . ', ' . $country . ($airportCount > 1 ? ' (' . $airportCount . ' airports)' : ''),
                    'value'       => $city . ' (' . $mainAirport->iata_code . ')',
                    'code'        => $mainAirport->iata_code,
                    'city'        => $city,
                    'country'     => $country,
                    'displayName' => $city . ', ' . $country,
                ];

                $sorted = $cityAirports->sortByDesc(function ($a) {
                    return $a->type === 'large_airport' ? 1 : 0;
                });
                foreach ($sorted as $airport) {
                    $shortName = preg_replace('/(International|Regional|Municipal|Metropolitan|Airport|Intl\.?)/i', '', $airport->name);
                    $shortName = trim(preg_replace('/\s+/', ' ', $shortName));
                    $results[] = [
                        'itemType'    => 'airport',
                        'label'       => $airport->name . ' — ' . $airport->iata_code,
                        'value'       => $airport->city . ' (' . $airport->iata_code . ')',
                        'code'        => $airport->iata_code,
                        'city'        => $airport->city,
                        'country'     => $airport->country,
                        'displayName' => $shortName . ' (' . $airport->iata_code . ')',
                        'fullName'    => $airport->name,
                        'iataCode'   => $airport->iata_code,
                    ];
                }
            }
            return $results;
        } catch (\Exception $e) {
            Log::error('Airport search error: ' . $e->getMessage());
            return [];
        }
    }

    public function createPaymentIntent($amount, $currency, $cardDetails)
    {
        try {
            \Log::info('Creating payment intent with data:', [
                'amount' => $amount,
                'currency' => $currency,
                // Log only partial card number for security
                'card_number_last4' => substr($cardDetails['card_number'], -4) ?? 'N/A',
                'expiry_month' => $cardDetails['expiry_month'] ?? 'N/A',
                'expiry_year' => $cardDetails['expiry_year'] ?? 'N/A',
            ]);

            $response = $this->client->post('payment_intents', [
                'json' => [
                    'data' => [
                        'amount' => (float) $amount,
                        'currency' => $currency,
                        'payment_method' => [
                            'type' => 'card',
                            'card' => [
                                'card_number' => str_replace(' ', '', $cardDetails['card_number']),
                                'card_holder_name' => $cardDetails['card_holder'],
                                'expiry_month' => $cardDetails['expiry_month'],
                                'expiry_year' => $cardDetails['expiry_year'],
                                'cvv' => $cardDetails['cvv'],
                            ],
                        ],
                        // Add description or other relevant fields if needed
                        'description' => 'Flight booking payment',
                    ],
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            \Log::info('Duffel API create payment intent response:', ['response' => $responseData]);

            if (!isset($responseData['data']['id'])) {
                \Log::error('Duffel API response missing payment intent ID:', ['response' => $responseData]);
                throw new \Exception('Invalid payment intent response from Duffel API: Missing ID');
            }
            // Note: Depending on API version and requirements, you might need to confirm the payment intent
            // with a separate call here if 3D Secure is involved. For a simplified test, we'll proceed
            // assuming direct creation and usage of the intent ID is sufficient.

            return $responseData['data']; // Return the payment intent data
        } catch (ClientException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            $errorMessage = 'Failed to create payment intent'; // Default message
            if (isset($errorResponse['errors'][0]['message'])) {
                $errorMessage = $errorResponse['errors'][0]['message'];
            } elseif (isset($errorResponse['message'])) {
                $errorMessage = $errorResponse['message'];
            }
            \Log::error('Duffel API Error (Create Payment Intent): ' . $errorMessage, ['response' => $errorResponse, 'exception' => $e]);
            throw new \Exception($errorMessage); // Rethrow with specific message
        } catch (\Exception $e) {
            \Log::error('Duffel Service Error (Create Payment Intent): ' . $e->getMessage(), ['exception' => $e]);
            throw new \Exception('Failed to create payment intent: ' . $e->getMessage());
        }
    }

    public function createBooking($offerId, $passengers, $payment)
    {
        try {
            if (empty($offerId) || empty($passengers) || empty($payment)) {
                throw new \Exception('Missing required booking data');
            }

            \Log::info('Creating booking with data:', [
                'offer_id' => $offerId,
                'passengers' => $passengers,
                'payment' => array_merge($payment, ['card_number' => '****' . substr($payment['card_number'], -4)]),
            ]);

            // Construct the booking data
            $bookingData = [
                'data' => [
                    'selected_offers' => [$offerId],
                    'passengers' => [],
                    'payments' => [
                        [
                            'type' => 'balance',
                            'amount' => (float) $payment['amount'],
                            'currency' => $payment['currency'],
                        ],
                    ],
                ],
            ];

            // Add each passenger to the booking data
            foreach ($passengers as $passenger) {
                $bookingData['data']['passengers'][] = [
                    'title' => $passenger['title'],
                    'phone_number' => $passenger['phone_number'],
                    'email' => $passenger['email'],
                    'given_name' => $passenger['given_name'],
                    'family_name' => $passenger['family_name'],
                    'gender' => $passenger['gender'],
                    'born_on' => $passenger['born_on'],
                    'type' => $passenger['type'] ?? 'adult',
                ];
            }

            \Log::info('Sending booking request to Duffel API:', ['booking_data' => $bookingData]);

            $response = $this->client->post('air/orders', [
                'json' => $bookingData,
            ]);

            // Log the raw response body for debugging
            $rawResponseBody = $response->getBody()->getContents();
            \Log::info('Duffel API raw booking response body:', ['body' => $rawResponseBody]);

            $responseData = json_decode($rawResponseBody, true);

            // Log the full response data for debugging
            \Log::info('Duffel API create booking response:', ['response' => $responseData]);

            if (!isset($responseData['data']['id'])) {
                \Log::error('Duffel API response missing booking ID:', ['response' => $responseData]);
                throw new \Exception('Invalid booking response from Duffel API: Missing booking ID');
            }

            return $responseData['data'];
        } catch (ClientException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            $errorMessage = 'Failed to create booking'; // Default message
            if (isset($errorResponse['errors'][0]['message'])) {
                $errorMessage = $errorResponse['errors'][0]['message'];
            } elseif (isset($errorResponse['message'])) {
                $errorMessage = $errorResponse['message'];
            }

            \Log::error('Duffel API Error (Booking): ' . $errorMessage, ['response' => $errorResponse, 'exception' => $e]);
            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            \Log::error('Duffel Service Error (Booking): ' . $e->getMessage());
            throw new \Exception('Failed to create booking: ' . $e->getMessage());
        }
    }

    public function getBooking($bookingId)
    {
        try {
            $response = $this->client->get('air/orders/' . $bookingId, [
                'headers' => [
                    'Accept-Encoding' => 'gzip',
                    'Duffel-Version' => 'v2',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            if (!isset($responseData['data'])) {
                throw new \Exception('Invalid response from Duffel API');
            }

            return $responseData['data'];
        } catch (ClientException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            $errorMessage = $errorResponse['errors'][0]['message'] ?? 'Failed to fetch booking details';
            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            throw new \Exception('Failed to fetch booking details: ' . $e->getMessage());
        }
    }

    public function getOffer($offerId)
    {
        try {
            $response = $this->client->get('air/offers/' . $offerId, [
                'headers' => [
                    'Accept-Encoding' => 'gzip',
                    'Duffel-Version' => 'v2',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'query' => [
                    'return_available_services' => 'true',
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            if (!isset($responseData['data'])) {
                throw new \Exception('Invalid response from Duffel API');
            }

            return $responseData['data'];
        } catch (ClientException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            $errorMessage = $errorResponse['errors'][0]['message'] ?? 'Failed to fetch offer details';
            throw new \Exception($errorMessage);
        } catch (\Exception $e) {
            throw new \Exception('Failed to fetch offer details: ' . $e->getMessage());
        }
    }

    public function getAllGroupedFareOptionsFromOfferRequest($offerRequestId)
    {
        try {
            $response = $this->client->get("air/offer_requests/{$offerRequestId}", [
                'headers' => [
                    'Accept-Encoding' => 'gzip',
                    'Duffel-Version' => 'v2',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true)['data'];
            $offers = $data['offers'] ?? [];

            $grouped = [];

            foreach ($offers as $offer) {
                $slices = $offer['slices'] ?? [];
                $hasCheckedBag = false;
                $refundable = false;
                $changeable = false;
                $cabinClass = 'economy'; // default
                $departureTime = null;
                $arrivalTime = null;
                $stops = 0;
                $airlineName = $offer['owner']['name'] ?? 'Unknown Airline';

                foreach ($slices as $slice) {
                    $segments = $slice['segments'] ?? [];
                    $conditions = $slice['conditions'] ?? [];

                    $refundable = isset($conditions['refund_before_departure']) && $conditions['refund_before_departure'] !== null;
                    $changeable = isset($conditions['change_before_departure']) && $conditions['change_before_departure'] !== null;

                    if (!empty($segments)) {
                        $departureTime = $segments[0]['departing_at'] ?? null;
                        $arrivalTime = end($segments)['arriving_at'] ?? null;
                        $stops += count($segments) - 1;
                    }

                    foreach ($segments as $segment) {
                        foreach ($segment['passengers'] ?? [] as $passenger) {
                            if (!empty($passenger['cabin_class'])) {
                                $cabinClass = strtolower($passenger['cabin_class']);
                            }

                            foreach ($passenger['baggages'] ?? [] as $bag) {
                                if ($bag['type'] === 'checked' && $bag['quantity'] > 0) {
                                    $hasCheckedBag = true;
                                }
                            }
                        }
                    }
                }

                $cabinLabel = ucfirst(str_replace('_', ' ', $cabinClass));

                // Branded Fare Label Logic
                if (!$refundable && !$hasCheckedBag && !$changeable) {
                    $fareLabel = "{$cabinLabel} Light";
                } elseif (!$refundable && $hasCheckedBag && !$changeable) {
                    $fareLabel = "{$cabinLabel} Standard";
                } elseif ($refundable && $hasCheckedBag && $changeable) {
                    $fareLabel = "{$cabinLabel} Flex";
                } else {
                    $fareLabel = "{$cabinLabel} Fare";
                }

                $offerSummary = [
                    'offer_id' => $offer['id'],
                    'airline' => $airlineName,
                    'cabin_class' => $cabinClass,
                    'fare_label' => $fareLabel,
                    'price' => (float) $offer['total_amount'],
                    'currency' => $offer['total_currency'],
                    'refundable' => $refundable,
                    'changeable' => $changeable,
                    'has_checked_bag' => $hasCheckedBag,
                    'departure_time' => $departureTime,
                    'arrival_time' => $arrivalTime,
                    'stops' => $stops,
                ];

                // Add offer under fare label group
                $grouped[$fareLabel][] = $offerSummary;
            }

            return $grouped;
        } catch (ClientException $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            throw new \Exception($error['errors'][0]['message'] ?? 'Duffel offer request fetch error');
        } catch (\Exception $e) {
            throw new \Exception('Duffel offer request processing failed: ' . $e->getMessage());
        }
    }

    public function cancelBooking($bookingId)
    {
        // ... existing code ...
    }

    public function getAirlines()
    {
        try {
            $response = $this->client->get('air/airlines', [
                'headers' => [
                    'Accept-Encoding' => 'gzip',
                    'Duffel-Version' => 'v2',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            return $body['data'] ?? [];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorBody = $e->getResponse()->getBody()->getContents();
                Log::error('Duffel API Error (getAirlines): ' . $errorBody);
            } else {
                Log::error('Duffel API Error (getAirlines): ' . $e->getMessage());
            }

            return $e->getMessage();
        } catch (\Exception $e) {
            Log::error('Unexpected Error in getAirlines: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    public function searchAirlineByName($searchTerm)
    {
        try {
            $airlines = $this->getAirlines();

            return collect($airlines)
                ->filter(function ($airline) use ($searchTerm) {
                    return str_contains(strtolower($airline['name']), strtolower($searchTerm));
                })
                ->values();
        } catch (\Exception $e) {
            Log::error('Error in searchAirlineByName: ' . $e->getMessage());
            return collect(); // Return empty collection on failure
        }
    }

    function createHeldDuffelOrder($offerId, array $passengerDataWithId)
    {
        try {
            // Get passenger ID and actual passenger details
            $passengerId = array_key_first($passengerDataWithId);
            $passengerData = $passengerDataWithId[$passengerId];
            // Build passenger payload
            $passengerPayload = [
                'phone_number' => $passengerData['phonecode'] . $passengerData['phone_number'],
                'email' => $passengerData['email'],
                'born_on' => $passengerData['born_on'],
                'title' => $passengerData['title'],
                'gender' => $passengerData['gender'],
                'family_name' => $passengerData['family_name'],
                'given_name' => $passengerData['given_name'],
                'id' => $passengerId,
            ];

            $response = $this->client->post('air/orders', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Duffel-Version' => 'v2',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                ],
                'json' => [
                    'data' => [
                        'type' => 'hold',
                        'selected_offers' => [$offerId],
                        'passengers' => [$passengerPayload],
                    ],
                ],
            ]);
            $body = json_decode($response->getBody(), true);
            return [
                'success' => true,
                'data' => $body['data'] ?? [],
            ];
        } catch (\Exception $e) {
            Log::error('Duffel order hold failed: ' . $e->getMessage());

            // return [
            //     'success' => false,
            //     'error' => $e->getMessage(),
            // ];

            $response = $e->getResponse();
            $body = (string) $response->getBody();
        
            Log::debug('Duffel raw error response: ' . $body);
        
            $responseBody = json_decode($body, true);
        
            $errorMessage = 'Unknown error';
            if (isset($responseBody['errors'][0]['detail'])) {
                $errorMessage = $responseBody['errors'][0]['detail'];
            } elseif (isset($responseBody['errors'][0]['title'])) {
                $errorMessage = $responseBody['errors'][0]['title'];
            } elseif (isset($responseBody['errors'][0])) {
                $errorMessage = json_encode($responseBody['errors'][0]);
            }
        
            Log::error('Duffel order hold failed: ' . $errorMessage);
        
            return [
                'success' => false,
                'error' => $errorMessage,
            ];

          
        }
    }



    public function checkDuffelOrderStatus($orderId)
    {
        try {
           
            $response = $this->client->get("air/orders/{$orderId}", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Duffel-Version' => 'v2',
                    'Accept' => 'application/json',
                    'Accept-Encoding' => 'gzip',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // Check payment status
            $paymentStatus = $data['data']['payment_status']['awaiting_payment'] ?? false;
            $expiresAt = $data['data']['payment_status']['payment_required_by'] ?? null;

            return [
                'success' => true,
                'awaiting_payment' => $paymentStatus,
                'expires_at' => $expiresAt,
            ];
        } catch (\Exception $e) {
            \Log::error('Duffel order check failed: ' . $e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }
    
/**
 * Search flights - this method is called by FlightController
 */
public function searchFlights($searchParams)
{
    try {
        Log::info('DuffelService: searchFlights called with params', $searchParams);
        
        // Determine trip type from parameters
        $tripType = 'oneway';
        if (isset($searchParams['trip_type'])) {
            switch ($searchParams['trip_type']) {
                case 'two-way':
                    $tripType = 'twoway';
                    break;
                case 'Multicity':
                    $tripType = 'Multicity';
                    break;
                default:
                    $tripType = 'oneway';
            }
        }
        
        // Prepare parameters for getOfferRequests method
        $params = [
            'triptype' => $tripType,
            'adults' => $searchParams['adults'] ?? 1,
            'children' => $searchParams['children'] ?? 0,
            'cabin_class' => $searchParams['cabin_class'] ?? 'Economy',
            'slices' => [
                [
                    'from' => $searchParams['origin'],
                    'to' => $searchParams['destination'],
                    'travelling_date' => $searchParams['departure_date']
                ]
            ]
        ];

        // Add return date for round trips
        if (isset($searchParams['return_date']) && $tripType === 'twoway') {
            $params['return_date'] = $searchParams['return_date'];
        }

        // Add multi-city segments if provided
        if (isset($searchParams['segments']) && is_array($searchParams['segments'])) {
            $params['slices'] = [];
            foreach ($searchParams['segments'] as $segment) {
                $params['slices'][] = [
                    'from' => $segment['origin'],
                    'to' => $segment['destination'],
                    'travelling_date' => $segment['date']
                ];
            }
        }

        Log::info('DuffelService: Prepared params for getOfferRequests', $params);

        // Call the existing getOfferRequests method
        $offers = $this->getOfferRequests($params);

        // Check if there was an error
        if (isset($offers['error'])) {
            Log::error('DuffelService searchFlights error:', $offers);
            return [
                'offers' => [],
                'error' => $offers['error']
            ];
        }

        // Format the response to match what the controller expects
        $formattedOffers = [];
        foreach ($offers as $offer) {
            $formattedOffers[] = [
                'id' => $offer['id'] ?? uniqid(),
                'owner' => [
                    'name' => $offer['owner']['name'] ?? 'Unknown Airline',
                    'iata_code' => $offer['owner']['iata_code'] ?? ''
                ],
                'slices' => $offer['slices'] ?? [],
                'total_amount' => $offer['total_amount'] ?? '0',
                'total_currency' => $offer['total_currency'] ?? 'USD',
                'passenger_identity_documents_required' => $offer['passenger_identity_documents_required'] ?? false
            ];
        }

        Log::info('DuffelService: searchFlights completed successfully', [
            'total_offers' => count($formattedOffers)
        ]);

        return [
            'offers' => $formattedOffers
        ];

    } catch (\Exception $e) {
        Log::error('DuffelService searchFlights exception:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);

        return [
            'offers' => [],
            'error' => 'Failed to search flights: ' . $e->getMessage()
        ];
    }
}
    
}

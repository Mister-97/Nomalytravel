<?php

namespace App\Http\Controllers;

use App\Services\DuffelService;
use Illuminate\Http\Request;

class DuffelController extends Controller
{
    protected $duffelService;

    public function __construct(DuffelService $duffelService)
    {
        $this->duffelService = $duffelService;
    }

    public function getHotels(Request $request)
    {
        try {
            $hotels = $this->duffelService->getHotels($request->all());

            if (isset($hotels['error'])) {
                return response()->json(['error' => $hotels['error']], 400);
            }

            return response()->json($hotels);
        } catch (\Exception $e) {
            \Log::error('Duffel Controller Error (Hotels): ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    public function getOfferRequests(Request $request)
    {
        try {
            $fromType = $request->input('from_type', 'name');
            $toType = $request->input('to_type', 'name');
            $from = $request->input('from');
            $to = $request->input('to');
            $travellingDate = $request->input('travelling_date');
            $returnDate = $request->input('return_date');
            $cabinClass = $request->input('cabin_class');
            $adults  = $request->input('adults', 1);
            $youth   = max(0, (int) $request->input('youth',   0));
            $infants = max(0, (int) $request->input('infants', 0));
            $children = $request->input('children', 0);
            $tripType = $request->input('triptype', 'oneway');
            $slices = $request->input('slices', []);

            $params = [
                'travelling_date' => $travellingDate,
                'return_date' => $returnDate,
                'cabin_class' => $cabinClass,
                'adults' => $adults,
                'children' => $children,
                'youth'    => $youth,
                'infants'  => $infants,
                'triptype' => $tripType,
                'slices' => $slices,
                'max_connections' => $request->input('max_connections', null),
                'airline' => $request->input('airline', null),
            ];

            $offerRequests = $this->duffelService->getOfferRequests($params);

            //$airlines = $this->duffelService->getAirlines();

            $airlines = [];

            if (isset($offerRequests['error'])) {
                return view('flights.offers', [
                    'error' => $offerRequests['error'],
                    'from' => $from,
                    'to' => $to,
                    'travelling_date' => $travellingDate,
                    'return_date' => $returnDate,
                    'cabin_class' => $cabinClass,
                    'adults' => $adults,
                    'children' => $children,
                    'from_type' => $fromType,
                    'to_type' => $toType,
                    'triptype' => $tripType,
                    'airlines' => $airlines,
                ]);
            }

            if (isset($request->sort_by)) {
                $sortBy = $request->sort_by;
                $offerRequests = collect($offerRequests);
                switch ($sortBy) {
                    case 'price_desc':
                        $offerRequests = $offerRequests->sortByDesc('total_amount');
                        break;
                    case 'duration_asc':
                        $offerRequests = $offerRequests->sortBy(function ($flight) {
                            return $flight['slices'][0]['segments'][0]['duration'] ?? PHP_INT_MAX;
                        });
                        break;
                    case 'duration_desc':
                        $offerRequests = $offerRequests->sortByDesc(function ($flight) {
                            return $offerRequests['slices'][0]['segments'][0]['duration'] ?? 0;
                        });
                        break;
                    case 'price_asc':
                    default:
                        $offerRequests = $offerRequests->sortBy('total_amount');
                        break;
                }
            }

            if (count($offerRequests ?? []) > 0) {
                foreach ($offerRequests as $flight) {
                    if (isset($flight['owner'])) {
                        $owner = $flight['owner'];
                        $ownerId = $owner['id'];
                        if (!isset($airlines[$ownerId])) {
                            $airlines[$ownerId] = $owner;
                        }
                    }
                }
            }

            if (!empty($request->airline)) {
                if (count($offerRequests ?? []) > 0) {
                    $offerRequests = $offerRequests
                        ->filter(function ($flight) use ($request) {
                            return $flight['owner']['id'] === $request->airline;
                        })
                        ->values();
                }
            }

            // Cache offer data in session keyed by offer ID.
            // showBookingForm will use this as a fallback if Duffel getOffer() fails.
            if (is_iterable($offerRequests)) {
                $sessionOffers = [];
                foreach ($offerRequests as $o) {
                    if (!empty($o['id'])) {
                        $sessionOffers[$o['id']] = $o;
                    }
                }
                session(['duffel_search_offers' => $sessionOffers]);
            }

            return view('flights.offers', [
                'flights' => $offerRequests,
                'from' => $from,
                'to' => $to,
                'travelling_date' => $travellingDate,
                'return_date' => $returnDate,
                'cabin_class' => $cabinClass,
                'adults' => $adults,
                'children' => $children,
                'from_type' => $fromType,
                'to_type' => $toType,
                'triptype' => $tripType,
                'airlines' => $airlines,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getOfferRequests: ' . $e->getMessage());

            return view('flights.offers', [
                'error' => 'An error occurred while fetching flight offers. Please try again later.',
                'from' => $request->input('from'),
                'to' => $request->input('to'),
                'travelling_date' => $request->input('travelling_date'),
                'return_date' => $request->input('return_date'),
                'cabin_class' => $request->input('cabin_class'),
                'adults' => $request->input('adults', 1),
                'children' => $request->input('children', 0),
                'from_type' => $request->input('from_type', 'name'),
                'to_type' => $request->input('to_type', 'name'),
                'triptype' => $request->input('triptype', 'oneway'),
                'airlines' => $airlines,
            ]);
        }
    }

    public function getFlights(Request $request)
    {
        try {
            $flights = $this->duffelService->getFlights($request->all());

            if (isset($flights['error'])) {
                return response()->json(['error' => $flights['error']], 400);
            }

            return response()->json($flights);
        } catch (\Exception $e) {
            \Log::error('Duffel Controller Error (Flights): ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    public function searchAirports(Request $request)
    {
        try {
            $query = $request->input('query');
            $airports = $this->duffelService->searchAirports($query);
            return response()->json($airports);
        } catch (\Exception $e) {
            \Log::error('Error in searchAirports: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $params = $request->all();
            $params['page'] = $request->get('page', 1);
            $params['return_date'] = $request->input('return_date'); // NEW

            $result = $this->duffelService->getOfferRequests($params);

            if (isset($result['error'])) {
                if ($request->ajax()) {
                    return response()->json(['error' => $result['error']], 400);
                }
                return back()->with('error', $result['error']);
            }

            if ($request->ajax()) {
                return response()->json($result);
            }

            return view('flights.search', [
                'flights' => $result['offers'],
                'total' => $result['total'],
                'per_page' => $result['per_page'],
                'current_page' => $result['current_page'],
                'last_page' => $result['last_page'],
            ]);
        } catch (\Exception $e) {
            \Log::error('Flight search error: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while searching for flights'], 500);
            }
            return back()->with('error', 'An error occurred while searching for flights');
        }
    }

    /**
     * Duffel Stays hotel search - shows hotel results from Duffel API
     */
    public function searchHotels(Request $request)
    {
        $keyword    = $request->input('keyword', '');
        $checkin    = $request->input('checkin', '');
        $checkout   = $request->input('checkout', '');
        $rooms      = max(1, (int)$request->input('rooms', 1));
        $adults     = max(1, (int)$request->input('adults', 2));
        $iataCode   = $request->input('iata_code', '');
        $hotels     = [];
        $error      = null;

        if ($checkin && $checkout && ($keyword || $iataCode)) {
            try {
                // Find airport IATA code from keyword if not provided
                if (!$iataCode && $keyword) {
                    $airport = \App\Models\Airport::whereIn('type', ['large_airport', 'medium_airport'])
                        ->where(function($q) use ($keyword) {
                            $q->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($keyword) . '%'])
                              ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%'])
                              ->orWhere('iata_code', strtoupper($keyword));
                        })
                        ->orderByRaw("FIELD(type, 'large_airport', 'medium_airport')")
                        ->first();
                    $iataCode = $airport ? $airport->iata_code : null;
                }

                if ($iataCode) {
                    $guests = [];
                    for ($i = 0; $i < $adults; $i++) { $guests[] = ['type' => 'adult']; }

                    $params = [
                        'data' => [
                            'rooms'          => $rooms,
                            'guests'         => $guests,
                            'check_in_date'  => $checkin,
                            'check_out_date' => $checkout,
                            'location'       => ['iata_code' => $iataCode],
                        ]
                    ];

                    $result = $this->duffelService->getHotels($params);

                    if (isset($result['error'])) {
                        $error = $result['error'];
                    } else {
                        $hotels = $result['data']['results'] ?? ($result['data'] ?? []);
                    }
                } else {
                    $error = 'Could not find an airport for that location. Try searching by airport code (e.g. LAX, JFK).';
                }
            } catch (\Exception $e) {
                \Log::error('Duffel Stays error: ' . $e->getMessage());
                $error = 'Unable to search hotels at this time. Please try again.';
            }
        }

        return view('hotels.duffel-search', compact('hotels', 'error', 'keyword', 'checkin', 'checkout', 'rooms', 'adults', 'iataCode'));
    }

}

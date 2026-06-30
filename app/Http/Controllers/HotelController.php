<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Services\LiteApiService;
use App\Services\DuffelStaysService;

class HotelController extends Controller
{
protected $liteApi;
private DuffelStaysService $duffelStays;

public function __construct(LiteApiService $liteApi, DuffelStaysService $duffelStays)
{
    $this->liteApi = $liteApi;
    $this->duffelStays = $duffelStays;
}

public function index()
{
return view('hotels.index');
}

public function search(Request $request)
{
$city = trim(preg_replace('/[,\s]+[A-Z]{2}$/', '', trim($request->city)));
$results = $this->liteApi->searchHotels(
$city,
$request->check_in,
$request->check_out,
$request->adults ?? 2
);
$hotelMap = $results['hotelMap'] ?? [];
$hotels = [];
foreach ($results['data'] ?? [] as $h) {
    $info = $hotelMap[$h['hotelId']] ?? [];
    $roomType = $h['roomTypes'][0] ?? null;
    $rate = $roomType['rates'][0] ?? null;
    $hotels[] = array_merge($h, [
        'name'      => $info['name'] ?? null,
        'thumbnail' => $info['thumbnail'] ?? null,
        'stars'     => $info['stars'] ?? 0,
        'city'      => $info['city'] ?? '',
        'country'   => $info['country'] ?? '',
        'address'   => $info['address'] ?? '',
        'minRate'   => $rate['retailRate']['total'][0]['amount'] ?? null,
        'offerId'   => $roomType['offerId'] ?? null,
    ]);
}
foreach ($hotels as &$h) { $h['source'] = $h['source'] ?? 'liteapi'; }
unset($h);
$this->mergeDuffel($hotels, $city, $request->check_in, $request->check_out, (int)($request->adults ?? 2));
usort($hotels, fn($a,$b) => ($a['minRate'] ?? PHP_INT_MAX) <=> ($b['minRate'] ?? PHP_INT_MAX));
return view('hotels.results', [
'hotels' => $hotels,
'search' => $request->all(),
]);
}

public function prebook(Request $request)
{
$result    = $this->liteApi->preBook($request->offer_id);
$prebook   = $result['data'] ?? [];
$prebookId = $prebook['prebookId'] ?? null;
return view('hotels.prebook', compact('prebook', 'prebookId'));
}

public function apiSearch(Request $request)
{
$city = trim(preg_replace('/[,\s]+[A-Z]{2}$/', '', trim($request->input('city', ''))));
$checkIn = $request->input('checkin', '');
$checkOut = $request->input('checkout', '');
$adults = $request->input('adults', 2);
if (!$city || !$checkIn || !$checkOut) {
return response()->json(['error' => 'Missing fields', 'hotels' => []]);
}
$result = $this->liteApi->searchHotels($city, $checkIn, $checkOut, $adults);
$hotelMap = $result['hotelMap'] ?? [];
$hotels = [];
foreach ($result['data'] ?? [] as $h) {
$rate = $h['roomTypes'][0]['rates'][0] ?? null;
$price = $rate['retailRate']['total'][0]['amount'] ?? 0;
$info = $hotelMap[$h['hotelId']] ?? [];
$hotels[] = [
'name' => $info['name'] ?? $h['hotelId'],
'hotelId' => $h['hotelId'],
'categoryCode' => $info['stars'] ?? ($h['starRating'] ?? 3),
'minRate' => $price,
'total_amount' => $price,
'address' => ($info['address'] ?? '') ?: ($h['address'] ?? ''),
'city' => ($info['city'] ?? '') . (($info['country'] ?? '') ? ', ' . strtoupper($info['country']) : ''),
'image' => $info['main_photo'] ?? '',
'images' => $h['images'] ?? [],
'rateId' => $rate['rateId'] ?? '',
];
}
$checkIn2 = $request->input('checkin',''); $checkOut2 = $request->input('checkout','');
if ($checkIn2 && $checkOut2) $this->mergeDuffel($hotels, $city, $checkIn2, $checkOut2, (int)$adults);
usort($hotels, fn($a,$b) => ($a['minRate'] ?? PHP_INT_MAX) <=> ($b['minRate'] ?? PHP_INT_MAX));
return response()->json(['hotels' => $hotels]);
}

    public function detail(Request $request, $hotelId)
    {
        $hotel    = $this->liteApi->getHotelDetail($hotelId);
        $checkIn  = $request->input('check_in',  date('Y-m-d', strtotime('+7 days')));
        $checkOut = $request->input('check_out', date('Y-m-d', strtotime('+9 days')));
        $adults   = (int) $request->input('adults', 2);
        $rooms    = $this->liteApi->getRatesForHotel($hotelId, $checkIn, $checkOut, $adults);

        // Build room name -> photos map from content API
        $roomPhotoMap = [];
        foreach ($hotel['rooms'] ?? [] as $contentRoom) {
            $rName  = strtolower(trim($contentRoom['roomName'] ?? ''));
            $photos = [];
            foreach ($contentRoom['photos'] ?? [] as $p) {
                $url = $p['hd_url'] ?? ($p['url'] ?? '');
                if ($url) $photos[] = $url;
            }
            if ($rName && !empty($photos)) {
                $roomPhotoMap[$rName] = $photos;
            }
        }

        return view('hotels.detail_api', compact('hotel', 'rooms', 'checkIn', 'checkOut', 'adults', 'roomPhotoMap'));
    }

    public function searchJson(Request $request)
    {
        $city    = trim(preg_replace('/[,\s]+[A-Z]{2}$/', '', trim($request->city)));
        $results = $this->liteApi->searchHotels($city, $request->check_in, $request->check_out, $request->adults ?? 2);
        $hotelMap = $results['hotelMap'] ?? [];
        $hotels = [];
        foreach ($results['data'] ?? [] as $h) {
            $info     = $hotelMap[$h['hotelId']] ?? [];
            $roomType = $h['roomTypes'][0] ?? null;
            $rate     = $roomType['rates'][0] ?? null;
            $hotels[] = [
                'hotelId'   => $h['hotelId'],
                'name'      => $info['name'] ?? $h['hotelId'],
                'thumbnail' => $info['thumbnail'] ?? null,
                'stars'     => $info['stars'] ?? 0,
                'city'      => $info['city'] ?? '',
                'country'   => $info['country'] ?? '',
                'address'   => $info['address'] ?? '',
                'minRate'   => $rate['retailRate']['total'][0]['amount'] ?? null,
            ];
        }
        $this->mergeDuffel($hotels, $city, $request->check_in, $request->check_out, (int)($request->adults ?? 2));
        usort($hotels, fn($a,$b) => ($a['minRate'] ?? PHP_INT_MAX) <=> ($b['minRate'] ?? PHP_INT_MAX));
        return response()->json(['hotels' => $hotels]);
    }

    public function homeDetail(Request $request, $hotelId)
    {
        $checkIn  = $request->input('check_in',  date('Y-m-d', strtotime('+7 days')));
        $checkOut = $request->input('check_out', date('Y-m-d', strtotime('+9 days')));
        $adults   = (int) $request->input('adults', 2);
        $apiKey   = config('services.liteapi.key');
        $baseUrl  = 'https://api.liteapi.travel/v3.0';

        // Run content + rates calls in parallel — cuts wait time roughly in half
        $responses = \Illuminate\Support\Facades\Http::pool(function ($pool) use ($apiKey, $baseUrl, $hotelId, $checkIn, $checkOut, $adults) {
            return [
                $pool->withHeaders(['X-API-Key' => $apiKey])
                     ->get("{$baseUrl}/data/hotel", ['hotelId' => $hotelId]),
                $pool->withHeaders(['X-API-Key' => $apiKey, 'Content-Type' => 'application/json'])
                     ->post("{$baseUrl}/hotels/rates", [
                         'hotelIds'         => [$hotelId],
                         'checkin'          => $checkIn,
                         'checkout'         => $checkOut,
                         'currency'         => 'USD',
                         'guestNationality' => 'US',
                         'occupancies'      => [['adults' => $adults]],
                     ]),
            ];
        });

        $hotel = $responses[0]->json()['data'] ?? null;
        $rooms = $responses[1]->json()['data'][0]['roomTypes'] ?? [];

        $roomPhotoMap = [];
        foreach ($hotel['rooms'] ?? [] as $contentRoom) {
            $rName  = strtolower(trim($contentRoom['roomName'] ?? ''));
            $photos = [];
            foreach ($contentRoom['photos'] ?? [] as $p) {
                $url = $p['hd_url'] ?? ($p['url'] ?? '');
                if ($url) $photos[] = $url;
            }
            if ($rName && !empty($photos)) $roomPhotoMap[$rName] = $photos;
        }
        return view('hotels._detail_partial', compact('hotel', 'rooms', 'checkIn', 'checkOut', 'adults', 'roomPhotoMap'));
    }

    public function homePrebook(Request $request)
    {
        $result = $this->liteApi->preBook($request->offer_id);
        $prebook   = $result['data'] ?? [];
        $prebookId = $prebook['prebookId'] ?? null;
        return view('hotels._prebook_partial', compact('prebook', 'prebookId'));
    }




    public function paymentIntent(Request $request)
    {
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $amount   = (int) round((float) $request->input('amount') * 100);
            $currency = strtolower($request->input('currency', 'usd'));
            $intent   = \Stripe\PaymentIntent::create([
                'amount'   => $amount,
                'currency' => $currency,
                'metadata' => ['source' => 'nomaly_hotel'],
            ]);
            return response()->json(['clientSecret' => $intent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function book(Request $request)
    {
        try {
            $prebookId = $request->input('prebook_id');
            $guestInfo = [
                'firstName' => $request->input('first_name'),
                'lastName'  => $request->input('last_name'),
                'email'     => $request->input('email'),
                'phone'     => $request->input('phone', ''),
            ];

            $result = $this->liteApi->bookHotel($prebookId, $guestInfo);

            if (!empty($result['data']['bookingId'])) {
                return response()->json([
                    'success'    => true,
                    'bookingId'  => $result['data']['bookingId'],
                    'hotel'      => $result['data']['hotel']['name'] ?? '',
                    'checkin'    => $result['data']['checkin'] ?? '',
                    'checkout'   => $result['data']['checkout'] ?? '',
                    'total'      => $result['data']['retailRate']['total'][0]['amount'] ?? '',
                    'currency'   => $result['data']['retailRate']['total'][0]['currency'] ?? 'USD',
                ]);
            }

            $error = $result['error'] ?? ($result['message'] ?? 'Booking failed. Please try again.');
            return response()->json(['success' => false, 'error' => $error], 422);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Hotel book error: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }


    private function geocodeCity(string $city): ?array
    {
        try {
            $resp = \Illuminate\Support\Facades\Http::withHeaders(['User-Agent' => 'NomalyTravel/1.0'])
                ->timeout(5)
                ->get('https://nominatim.openstreetmap.org/search', ['q' => $city, 'format' => 'json', 'limit' => 1]);
            $data = $resp->json();
            if (!empty($data[0])) {
                return ['latitude' => (float)$data[0]['lat'], 'longitude' => (float)$data[0]['lon']];
            }
        } catch (\Exception $e) {}
        return null;
    }

    private function normalizeDuffelResult(array $r, string $checkIn, string $checkOut, int $adults): array
    {
        $acc   = $r['accommodation'] ?? [];
        $loc   = $acc['location'] ?? [];
        $addr  = $loc['address'] ?? [];
        $photo = $acc['photos'][0]['url'] ?? null;
        $total = isset($r['cheapest_rate_public_amount']) ? (float)$r['cheapest_rate_public_amount'] : null;
        return [
            'source'         => 'duffel',
            'hotelId'        => $acc['id'] ?? null,
            'duffelResultId' => $r['id'] ?? null,
            'name'           => $acc['name'] ?? 'Hotel',
            'thumbnail'      => $photo,
            'image'          => $photo,
            'stars'          => $acc['rating'] ?? 0,
            'review_score'   => $acc['review_score'] ?? null,
            'city'           => $addr['city_name'] ?? '',
            'country'        => $addr['country_code'] ?? '',
            'address'        => $addr['line_one'] ?? '',
            'minRate'        => $total,
            'check_in'       => $checkIn,
            'check_out'      => $checkOut,
            'adults'         => $adults,
        ];
    }

    private function mergeDuffel(array &$hotels, string $city, string $checkIn, string $checkOut, int $adults): void
    {
        $coords = $this->geocodeCity($city);
        if (!$coords) return;
        try {
            $resp = $this->duffelStays->searchAccommodations(array_merge($coords, [
                'check_in_date'  => $checkIn,
                'check_out_date' => $checkOut,
                'rooms'          => 1,
                'adults'         => $adults,
            ]));
            foreach ($resp['data']['results'] ?? [] as $r) {
                $hotels[] = $this->normalizeDuffelResult($r, $checkIn, $checkOut, $adults);
            }
        } catch (\Exception $e) {}
    }

}
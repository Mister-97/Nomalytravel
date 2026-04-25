<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LiteApiService;

class HotelController extends Controller
{
protected $liteApi;

public function __construct(LiteApiService $liteApi)
{
$this->liteApi = $liteApi;
}

public function index()
{
return view('hotels.index');
}

public function search(Request $request)
{
$results = $this->liteApi->searchHotels(
$request->city,
$request->check_in,
$request->check_out,
$request->adults ?? 2
);
return view('hotels.results', [
'hotels' => $results['data'] ?? [],
'search' => $request->all(),
]);
}

public function prebook(Request $request)
{
$result = $this->liteApi->preBook($request->rate_id);
return view('hotels.prebook', ['prebook' => $result['data'] ?? []]);
}

public function apiSearch(Request $request)
{
$city = $request->input('city', '');
$checkIn = $request->input('checkin', '');
$checkOut = $request->input('checkout', '');
$adults = $request->input('adults', 2);
if (!$city || !$checkIn || !$checkOut) {
return response()->json(['error' => 'Missing fields', 'hotels' => []]);
}
$result = $this->liteApi->searchHotels($city, $checkIn, $checkOut, $adults);
$hotels = [];
foreach ($result['data'] ?? [] as $h) {
$rate = $h['roomTypes'][0]['rates'][0] ?? null;
$price = $rate['retailRate']['total'][0]['amount'] ?? 0;
$hotels[] = [
'name' => $result['hotelNames'][$h['hotelId']] ?? $h['hotelId'],
'hotelId' => $h['hotelId'],
'categoryCode' => $h['starRating'] ?? 3,
'minRate' => $price,
'total_amount' => $price,
'address' => $h['address'] ?? '',
'images' => $h['images'] ?? [],
'rateId' => $rate['rateId'] ?? '',
];
}
return response()->json(['hotels' => $hotels]);
}
}

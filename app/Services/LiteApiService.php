<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LiteApiService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.liteapi.travel/v3.0';

    public function __construct()
    {
        $this->apiKey = config('services.liteapi.key');
    }

    public function searchHotels($cityCode, $checkIn, $checkOut, $adults = 2, $currency = 'USD')
{
$headers = ['X-API-Key' => $this->apiKey, 'Content-Type' => 'application/json'];

// Auto-detect country code from city name using free geocoding
$countryCode = Cache::remember('geo_country:' . strtolower($cityCode), 604800, function() use ($cityCode) {
    try {
        $geo = Http::withHeaders(['User-Agent' => 'NomalyTravel/1.0'])->timeout(5)->get('https://nominatim.openstreetmap.org/search', [
            'q' => $cityCode, 'format' => 'json', 'limit' => 1, 'addressdetails' => 1,
        ]);
        $data = $geo->json();
        return !empty($data[0]['address']['country_code']) ? strtoupper($data[0]['address']['country_code']) : 'US';
    } catch (\Exception $e) { return 'US'; }
});

$cacheKey = 'liteapi_hotels:' . strtolower($cityCode) . ':' . strtolower($countryCode);
[$hotelMap, $hotelIds] = Cache::remember($cacheKey, 21600, function() use ($headers, $cityCode, $countryCode) {
    $hotelRes = Http::withHeaders($headers)->get("{$this->baseUrl}/data/hotels", ['cityName' => $cityCode, 'countryCode' => $countryCode]);
    $hotelList = $hotelRes->json()['data'] ?? [];
    $map = collect($hotelList)->keyBy('id')->all();
    $ids = collect($hotelList)->pluck('id')->take(20)->values()->all();
    return [$map, $ids];
});
if (empty($hotelIds)) return ['error' => 'No hotels found', 'hotels' => []];
$ratesRes = Http::withHeaders($headers)->post("{$this->baseUrl}/hotels/rates", ['hotelIds' => $hotelIds, 'checkin' => $checkIn, 'checkout' => $checkOut, 'currency' => $currency, 'guestNationality' => 'US', 'occupancies' => [['adults' => (int)$adults]]]);
$result = $ratesRes->json();
$result['hotelMap'] = $hotelMap;
return $result;
}

    public function preBook($offerId)
    {
        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/rates/prebook", [
            'offerId' => $offerId,
        ]);

        return $response->json();
    }

    public function bookHotel($prebookId, $guestInfo)
    {
        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/rates/book", [
            'prebookId' => $prebookId,
            'holder'    => $guestInfo,
        ]);

        return $response->json();
    }

    public function getHotelDetail($hotelId)
    {
        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey,
        ])->get("{$this->baseUrl}/data/hotel", ['hotelId' => $hotelId]);

        return $response->json()['data'] ?? null;
    }

    public function getRatesForHotel($hotelId, $checkIn, $checkOut, $adults = 2, $currency = 'USD')
    {
        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/hotels/rates", [
            'hotelIds'        => [$hotelId],
            'checkin'         => $checkIn,
            'checkout'        => $checkOut,
            'currency'        => $currency,
            'guestNationality'=> 'US',
            'occupancies'     => [['adults' => (int)$adults]],
        ]);

        $data = $response->json();
        return $data['data'][0]['roomTypes'] ?? [];
    }

}
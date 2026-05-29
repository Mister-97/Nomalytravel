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
$countryCode = 'US';
try {
    $geo = Http::withHeaders(['User-Agent' => 'NomalyTravel/1.0'])->get('https://nominatim.openstreetmap.org/search', [
        'q' => $cityCode, 'format' => 'json', 'limit' => 1, 'addressdetails' => 1,
    ]);
    $geoData = $geo->json();
    if (!empty($geoData[0]['address']['country_code'])) {
        $countryCode = strtoupper($geoData[0]['address']['country_code']);
    }
} catch (\Exception $e) {}

$hotelRes = Http::withHeaders($headers)->get("{$this->baseUrl}/data/hotels", ['cityName' => $cityCode, 'countryCode' => $countryCode]);
$hotelList = $hotelRes->json()['data'] ?? [];
$hotelMap = collect($hotelList)->keyBy('id')->all();
$hotelIds = collect($hotelList)->pluck('id')->take(20)->values()->all();
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
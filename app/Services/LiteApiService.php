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
$hotelRes = Http::withHeaders($headers)->get("{$this->baseUrl}/data/hotels", ['cityName' => $cityCode, 'countryCode' => 'US']);
$hotelList = $hotelRes->json()['data'] ?? [];
$hotelNames = collect($hotelList)->pluck('name', 'id')->all();
$hotelIds = collect($hotelList)->pluck('id')->take(20)->values()->all();
if (empty($hotelIds)) return ['error' => 'No hotels found', 'hotels' => []];
$ratesRes = Http::withHeaders($headers)->post("{$this->baseUrl}/hotels/rates", ['hotelIds' => $hotelIds, 'checkin' => $checkIn, 'checkout' => $checkOut, 'currency' => $currency, 'guestNationality' => 'US', 'occupancies' => [['adults' => (int)$adults]]]);
$result = $ratesRes->json();
$result['hotelNames'] = $hotelNames;
return $result;
}

    public function preBook($rateId)
    {
        $response = Http::withHeaders([
            'X-API-Key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/rates/prebook", [
            'rateId' => $rateId,
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
}

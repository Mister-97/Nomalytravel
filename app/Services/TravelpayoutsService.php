<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TravelpayoutsService
{
    protected string $token;
    protected string $marker;

    private const TARGET_AIRLINES = ["UA", "DL"];
    private const AIRLINE_NAMES   = ["UA" => "United Airlines", "DL" => "Delta Air Lines"];

    public function __construct()
    {
        $this->token  = config("services.travelpayouts.token", "");
        $this->marker = config("services.travelpayouts.marker", "");
    }

    public function searchFlights(string $origin, string $destination, string $departureDate, bool $oneWay = true, string $currency = "usd"): array
    {
        if (!$this->token) return [];

        $cacheKey = "tp_flights_" . md5("{$origin}_{$destination}_{$departureDate}_{$currency}");

        return Cache::remember($cacheKey, 900, function () use ($origin, $destination, $departureDate, $oneWay, $currency) {
            try {
                $response = Http::timeout(10)->get("https://api.travelpayouts.com/aviasales/v3/prices_for_dates", [
                    "origin"       => strtoupper($origin),
                    "destination"  => strtoupper($destination),
                    "departure_at" => $departureDate,
                    "unique"       => "false",
                    "sorting"      => "price",
                    "direct"       => "false",
                    "currency"     => $currency,
                    "limit"        => 50,
                    "one_way"      => $oneWay ? "true" : "false",
                    "token"        => $this->token,
                ]);

                if (!$response->successful()) {
                    Log::warning("Travelpayouts API error", ["status" => $response->status(), "body" => $response->body()]);
                    return [];
                }

                $data = $response->json("data", []);

                return array_map(function ($f) {
                    $code = strtoupper($f["airline"] ?? "");
                    return array_merge($f, [
                        "airline_name"   => self::AIRLINE_NAMES[$code] ?? $code,
                        "booking_link"   => "https://www.aviasales.com" . ($f["link"] ?? "") . "?marker=" . $this->marker,
                        "price_display"  => "$" . number_format($f["price"] ?? 0),
                    ]);
                }, array_values($data));

            } catch (\Exception $e) {
                Log::error("TravelpayoutsService: " . $e->getMessage());
                return [];
            }
        });
    }
}

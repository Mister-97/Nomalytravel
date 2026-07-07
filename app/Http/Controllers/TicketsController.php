<?php

namespace App\Http\Controllers;

use App\Services\TicketSqueezeService;
use App\Services\TicketNetworkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TicketsController extends Controller
{
    public function __construct(
        protected TicketSqueezeService $ticketSqueeze,
        protected TicketNetworkService $ticketNetwork,
    ) {}

    private function parseDateParams(Request $request): array
    {
        $params = $request->only('city', 'keyword');
        $date   = $request->input('date');
        if ($date && preg_match('/^\d{4}-\d{2}$/', $date)) {
            $params['date_from']  = $date . '-01';
            $params['date_to']    = \Carbon\Carbon::parse($date . '-01')->endOfMonth()->toDateString();
            $params['date_label'] = \Carbon\Carbon::parse($date . '-01')->format('F Y');
        } elseif ($date) {
            $params['date_from']  = $date;
            $params['date_label'] = \Carbon\Carbon::parse($date)->format('M j, Y');
        }
        return $params;
    }

    public function sports(Request $request)
    {
        $params = $this->parseDateParams($request);

        // Upstream ticket APIs take 2-6s combined; inventory doesn't change
        // minute-to-minute, so serve a 10-minute cached copy per search combo
        // and only the first visitor pays the fetch cost.
        [$events, $error] = Cache::remember(
            'events_sports_' . md5(json_encode($params)),
            600,
            function () use ($params) {
                $tsResult = $this->ticketSqueeze->getSportsEvents($params);
                $tnResult = $this->ticketNetwork->getSportsEvents($params);
                $events = array_merge($tsResult['events'], $tnResult['events']);
                $error  = $tsResult['error'] && $tnResult['error']
                    ? 'Both ticket sources returned errors.'
                    : null;
                return [$events, $error];
            }
        );

        if ($error) {
            Cache::forget('events_sports_' . md5(json_encode($params)));
        }

        $suggestedTeams = Cache::remember(
            'suggested_sports_' . md5(json_encode($params)),
            21600,
            fn() => $this->buildSuggestedEntities($events, 'sports')
        );

        return view('tickets.sports', compact('events', 'error', 'suggestedTeams'));
    }

    public function concerts(Request $request)
    {
        $params = $this->parseDateParams($request);

        [$events, $error] = Cache::remember(
            'events_concerts_' . md5(json_encode($params)),
            600,
            function () use ($params) {
                $tsResult = $this->ticketSqueeze->getConcertEvents($params);
                $tnResult = $this->ticketNetwork->getConcertEvents($params);
                $events = array_merge($tsResult['events'], $tnResult['events']);
                $error  = $tsResult['error'] && $tnResult['error']
                    ? 'Both ticket sources returned errors.'
                    : null;
                return [$events, $error];
            }
        );

        if ($error) {
            Cache::forget('events_concerts_' . md5(json_encode($params)));
        }

        $suggestedArtists = Cache::remember(
            'suggested_concerts_' . md5(json_encode($params)),
            21600,
            fn() => $this->buildSuggestedEntities($events, 'concerts')
        );

        return view('tickets.concerts', compact('events', 'error', 'suggestedArtists'));
    }

    // "Suggested teams/artists" chips shown above city-scoped results — built
    // from our own event data (performer frequency), not a licensed dataset,
    // so counts and images are self-consistent with what the site actually has.
    private function buildSuggestedEntities(array $events, string $categoryType, int $limit = 6): array
    {
        $skipWords = ['preseason', 'playoffs', 'summer league', 'classic', 'showcase',
            'tournament', 'invitational', 'village', 'exhibition', 'all-star', 'all star',
            'fan fest', 'festival'];

        $counts = [];
        foreach ($events as $event) {
            foreach ($event['performers'] ?? [] as $p) {
                $name = trim($p['name'] ?? '');
                if ($name === '') continue;

                $lower = mb_strtolower($name);
                foreach ($skipWords as $skip) {
                    if (str_contains($lower, $skip)) continue 2;
                }

                $counts[$name] ??= ['count' => 0, 'category' => $event['category']['name'] ?? ($event['category']['path'] ?? '')];
                $counts[$name]['count']++;
            }
        }

        arsort($counts);
        $top = array_slice($counts, 0, $limit, true);

        $suggestions = [];
        foreach ($top as $name => $meta) {
            $suggestions[] = [
                'name'     => $name,
                'category' => $meta['category'],
                'count'    => $meta['count'],
                'image'    => $this->ticketSqueeze->getSuggestedEntityImage($name, $categoryType),
            ];
        }
        return $suggestions;
    }
}

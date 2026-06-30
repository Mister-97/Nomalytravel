<?php

namespace App\Http\Controllers;

use App\Services\TicketSqueezeService;
use App\Services\TicketNetworkService;
use Illuminate\Http\Request;

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

        $tsResult = $this->ticketSqueeze->getSportsEvents($params);
        $tnResult = $this->ticketNetwork->getSportsEvents($params);

        $events = array_merge($tsResult['events'], $tnResult['events']);
        $error  = $tsResult['error'] && $tnResult['error']
            ? 'Both ticket sources returned errors.'
            : null;

        return view('tickets.sports', compact('events', 'error'));
    }

    public function concerts(Request $request)
    {
        $params = $this->parseDateParams($request);

        $tsResult = $this->ticketSqueeze->getConcertEvents($params);
        $tnResult = $this->ticketNetwork->getConcertEvents($params);

        $events = array_merge($tsResult['events'], $tnResult['events']);
        $error  = $tsResult['error'] && $tnResult['error']
            ? 'Both ticket sources returned errors.'
            : null;

        return view('tickets.concerts', compact('events', 'error'));
    }
}

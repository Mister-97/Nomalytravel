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

    public function sports(Request $request)
    {
        $params = $request->only('city', 'keyword', 'date');

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
        $params = $request->only('city', 'keyword', 'date');

        $tsResult = $this->ticketSqueeze->getConcertEvents($params);
        $tnResult = $this->ticketNetwork->getConcertEvents($params);

        $events = array_merge($tsResult['events'], $tnResult['events']);
        $error  = $tsResult['error'] && $tnResult['error']
            ? 'Both ticket sources returned errors.'
            : null;

        return view('tickets.concerts', compact('events', 'error'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\TicketmasterService;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function __construct(protected TicketmasterService $ticketmaster) {}

    public function sports(Request $request)
    {
        $result = $this->ticketmaster->getSportsEvents($request->only('city', 'keyword', 'date'));
        return view('tickets.sports', [
            'events' => $result['events'],
            'error'  => $result['error'],
        ]);
    }

    public function concerts(Request $request)
    {
        $result = $this->ticketmaster->getConcertEvents($request->only('city', 'keyword', 'date'));
        return view('tickets.concerts', [
            'events' => $result['events'],
            'error'  => $result['error'],
        ]);
    }
}

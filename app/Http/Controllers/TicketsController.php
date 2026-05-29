<?php

namespace App\Http\Controllers;

use App\Services\TicketSqueezeService;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    public function __construct(protected TicketSqueezeService $tickets) {}

    public function sports(Request $request)
    {
        $result = $this->tickets->getSportsEvents($request->only('city', 'keyword', 'date'));
        return view('tickets.sports', [
            'events' => $result['events'],
            'error'  => $result['error'],
        ]);
    }

    public function concerts(Request $request)
    {
        $result = $this->tickets->getConcertEvents($request->only('city', 'keyword', 'date'));
        return view('tickets.concerts', [
            'events' => $result['events'],
            'error'  => $result['error'],
        ]);
    }
}

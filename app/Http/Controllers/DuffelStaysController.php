<?php

namespace App\Http\Controllers;

use App\Services\DuffelStaysService;
use Illuminate\Http\Request;

class DuffelStaysController extends Controller
{
    public function __construct(protected DuffelStaysService $stays) {}

    public function index()
    {
        return view('stays.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'destination'    => 'required|string',
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'check_in_date'  => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults'         => 'required|integer|min:1',
            'rooms'          => 'required|integer|min:1',
        ]);

        try {
            $result = $this->stays->searchAccommodations($request->all());
            $accommodations = $result['data'] ?? [];
            $searchId = $result['data'][0]['search_id'] ?? null;
        } catch (\Exception $e) {
            $accommodations = [];
            $searchId = null;
            $error = $e->getMessage();
        }

        return view('stays.results', [
            'accommodations' => $accommodations,
            'searchId'       => $searchId,
            'params'         => $request->all(),
            'error'          => $error ?? null,
        ]);
    }

    public function detail(Request $request, string $searchId, string $accommodationId)
    {
        try {
            $result        = $this->stays->getAccommodation($searchId, $accommodationId);
            $accommodation = $result['data'] ?? [];
        } catch (\Exception $e) {
            $accommodation = [];
            $error = $e->getMessage();
        }

        return view('stays.detail', [
            'accommodation' => $accommodation,
            'searchId'      => $searchId,
            'params'        => $request->all(),
            'error'         => $error ?? null,
        ]);
    }

    public function quote(Request $request)
    {
        $request->validate([
            'accommodation_id' => 'required|string',
            'rate_plan_id'     => 'required|string',
            'check_in_date'    => 'required|date',
            'check_out_date'   => 'required|date',
            'rooms'            => 'required|integer|min:1',
            'adults'           => 'required|integer|min:1',
        ]);

        try {
            $guests = [];
            for ($i = 0; $i < (int) $request->adults; $i++) {
                $guests[] = ['type' => 'adult'];
            }

            $result = $this->stays->createQuote(array_merge($request->all(), ['guests' => $guests]));
            $quote  = $result['data'] ?? [];
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return view('stays.checkout', [
            'quote'  => $quote,
            'params' => $request->all(),
        ]);
    }

    public function reserve(Request $request)
    {
        $request->validate([
            'quote_id'   => 'required|string',
            'amount'     => 'required|numeric',
            'currency'   => 'required|string',
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|email',
            'phone'      => 'required|string',
        ]);

        try {
            $guests = [[
                'given_name'   => $request->first_name,
                'family_name'  => $request->last_name,
                'email'        => $request->email,
                'phone_number' => $request->phone,
            ]];

            $result      = $this->stays->createReservation(array_merge($request->all(), ['guests' => $guests]));
            $reservation = $result['data'] ?? [];
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('stays.confirmation', ['id' => $reservation['id']]);
    }

    public function confirmation(string $id)
    {
        try {
            $result      = $this->stays->getReservation($id);
            $reservation = $result['data'] ?? [];
        } catch (\Exception $e) {
            $reservation = [];
            $error = $e->getMessage();
        }

        return view('stays.confirmation', [
            'reservation' => $reservation,
            'error'       => $error ?? null,
        ]);
    }
}

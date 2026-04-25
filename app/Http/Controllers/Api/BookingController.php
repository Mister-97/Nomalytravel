<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FlightBooking;
use App\Models\Hotels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\DuffelService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    protected $duffelService;

    public function __construct(DuffelService $duffelService)
    {
        $this->duffelService = $duffelService;
    }

    /**
     * Get all bookings for authenticated user
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            $flightBookings = FlightBooking::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            $hotelBookings = Hotels::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'flights' => $flightBookings,
                    'hotels' => $hotelBookings,
                    'total_bookings' => $flightBookings->count() + $hotelBookings->count()
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get bookings error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific booking
     */
    public function show($id)
    {
        try {
            $user = request()->user();
            
            // Try to find flight booking
            $flightBooking = FlightBooking::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if ($flightBooking) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'type' => 'flight',
                        'booking' => $flightBooking
                    ]
                ]);
            }

            // Try to find hotel booking
            $hotelBooking = Hotels::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if ($hotelBooking) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'type' => 'hotel',
                        'booking' => $hotelBooking
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get flight bookings
     */
    public function flightBookings(Request $request)
    {
        try {
            $user = $request->user();
            
            $bookings = FlightBooking::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);

        } catch (\Exception $e) {
            Log::error('Get flight bookings error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch flight bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store flight booking
     */
    /**
     * Store flight booking (status: pending, payment_status: pending)
     */
    public function storeFlightBooking(Request $request)
{
    try {
        $offer_id = $request->offer_id;
        $booking = FlightBooking::where('offer_id', $offer_id)->first();

        if ($booking && $booking->booking_status === 'hold') {
            return response()->json([
                'status' => 'error',
                'message' => 'This flight is already on hold for you. Please proceed to payment to confirm your booking.'
            ]);
        }

        // Validation rules
        $validationRules = [
            'passenger_details' => 'required|array',
        ];

        foreach ($request->input('passenger_details', []) as $passengerId => $passenger) {
    $validationRules["passenger_details.$passengerId.title"] = 'required';
    $validationRules["passenger_details.$passengerId.given_name"] = 'required';
    $validationRules["passenger_details.$passengerId.family_name"] = 'required';
    $validationRules["passenger_details.$passengerId.email"] = 'required|email';
    $validationRules["passenger_details.$passengerId.phone_number"] = 'required';
                $validationRules["passenger_details.$passengerId.phonecode"] = 'required';
    $validationRules["passenger_details.$passengerId.born_on"] = 'required|date';
    $validationRules["passenger_details.$passengerId.gender"] = 'required';
}


        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $passengers = $validated['passenger_details'];
        
        if (!$booking) {
            $booking = new FlightBooking();
        }
        
        $booking->passenger_details = $passengers;

        // Hold booking logic
        if ($request->booking_type === 'hold') {
            $hold_data = $this->duffelService->createHeldDuffelOrder($offer_id, $request->passengers);

            if ($hold_data['success']) {
                $orderData = $hold_data['data'];
                $booking->system_order_id = $orderData['id'] ?? null;
                $booking->order_expire_at = $orderData['payment_status']['payment_required_by'] ?? null;
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $hold_data['error']
                ]);
            }
        }

        $offer = $this->duffelService->getOffer($offer_id);

        if (!$offer || isset($offer['error'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'The selected flight offer is no longer available.'
            ]);
        }

        // Save booking data
        $user = $request->user();
        $booking->user_id = $user->id;
        $booking->offer_id = $offer_id;
        $booking->trip_type = count($offer['slices']) > 1 ? 'two-way' : 'one-way';
        $booking->departure_date = $offer['slices'][0]['segments'][0]['departing_at'];

        if (count($offer['slices']) > 1) {
            $booking->return_date = $offer['slices'][1]['segments'][0]['departing_at'];
        }

        $booking->origin_code = $offer['slices'][0]['origin']['iata_code'];
        $booking->destination_code = $offer['slices'][0]['destination']['iata_code'];
        $booking->airline_code = $offer['slices'][0]['segments'][0]['operating_carrier']['iata_code'] ?? null;
        $booking->flight_info = json_encode($offer);

        // Match selected services
        $selectedServiceIds = $request->input('selected_services', []);
        $matchedServices = [];

        if (!empty($selectedServiceIds) && !empty($offer['available_services'])) {
            foreach ($offer['available_services'] as $service) {
                if (in_array($service['id'], $selectedServiceIds)) {
                    $matchedServices[] = $service;
                }
            }
        }

        $selectedServicesTotal = 0;
        foreach ($matchedServices as $service) {
            $selectedServicesTotal += (float) $service['total_amount'];
        }

        // Passenger counts
        $adults = 0;
        $children = 0;
        foreach ($offer['passengers'] as $passenger) {
            if ($passenger['type'] === 'adult') $adults++;
            if ($passenger['type'] === 'child') $children++;
        }

        $booking->adults = $adults;
        $booking->children = $children;
        $booking->services_total = $selectedServicesTotal;
        $booking->selected_services = json_encode($matchedServices);
        $booking->selected_services_ids = json_encode($selectedServiceIds);

        // Service charges
        $serviceFee = (float)(widget(29)->extra_field_2 ?? 0);
        $servicePercent = (float)(widget(29)->extra_field_3 ?? 0);
        $sub_total = (float)$offer['total_amount'];
        $servicePercentAmount = ($sub_total * $servicePercent) / 100;
        $totalServiceAmount = $serviceFee + $servicePercentAmount;

        $booking->total_amount = $sub_total + $selectedServicesTotal + $totalServiceAmount;
        $booking->service_charges = $totalServiceAmount;
        $booking->currency = $offer['total_currency'] ?? 'USD';
        //$booking->passenger_details = $validated['passengers'];
        $booking->payment_status = 'pending';
        $booking->booking_status = $request->booking_type === 'hold' ? 'hold' : 'pending';

        // Outbound flight info
        $outboundSegment = $offer['slices'][0]['segments'][0];
        $outboundSlice = $offer['slices'][0];

        $booking->airline_name = $outboundSegment['operating_carrier']['name'] ?? null;
        $booking->airline_code = $outboundSegment['operating_carrier']['iata_code'] ?? null;
        $booking->flight_number = $outboundSegment['operating_carrier_flight_number'] ?? null;
        $booking->departure_terminal = $outboundSegment['departing_at_terminal'] ?? null;
        $booking->arrival_terminal = $outboundSegment['arriving_at_terminal'] ?? null;
        $booking->origin_airport = $outboundSegment['origin']['name'] ?? null;
        $booking->destination_airport = $outboundSegment['destination']['name'] ?? null;
        $booking->checked_baggage = json_encode($outboundSlice['baggages']['checked_bags'] ?? null);
        $booking->carry_on_baggage = json_encode($outboundSlice['baggages']['carry_on'] ?? null);
        $booking->cabin_class = $outboundSlice['cabin_class'] ?? null;
        $booking->departure_time = $outboundSegment['departing_at'] ?? null;
        $booking->arrival_time = $outboundSegment['arriving_at'] ?? null;

        // Return flight info
        if (count($offer['slices']) > 1) {
            $returnSegment = $offer['slices'][1]['segments'][0];
            $returnSlice = $offer['slices'][1];

            $booking->return_airline_name = $returnSegment['operating_carrier']['name'] ?? null;
            $booking->return_airline_code = $returnSegment['operating_carrier']['iata_code'] ?? null;
            $booking->return_flight_number = $returnSegment['operating_carrier_flight_number'] ?? null;
            $booking->return_departure_terminal = $returnSegment['departing_at_terminal'] ?? null;
            $booking->return_arrival_terminal = $returnSegment['arriving_at_terminal'] ?? null;
            $booking->return_departure_airport = $returnSegment['origin']['name'] ?? null;
            $booking->return_arrival_airport = $returnSegment['destination']['name'] ?? null;
            $booking->return_checked_baggage = json_encode($returnSlice['baggages']['checked_bags'] ?? null);
            $booking->return_carry_on_baggage = json_encode($returnSlice['baggages']['carry_on'] ?? null);
            $booking->return_cabin_class = $returnSlice['cabin_class'] ?? null;
            $booking->return_departure_time = $returnSegment['departing_at'] ?? null;
            $booking->return_arrival_time = $returnSegment['arriving_at'] ?? null;
        }

        $booking->save();

        // Send confirmation emails (same as web version)
        try {
            Mail::to($user->email)->send(new \App\Mail\FlightBookingMail($booking, $user, false)); // User email
            
            // Send to admin
            $adminEmail = widget(1)->extra_field_2;
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new \App\Mail\FlightBookingMail($booking, $user, true)); // Admin email
            }
            
            Log::info('Flight booking confirmation emails sent successfully', [
                'booking_id' => $booking->id,
                'user_email' => $user->email,
                'admin_email' => $adminEmail
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send flight booking confirmation emails: ' . $e->getMessage());
            // Continue with the flow even if email fails
        }

        return response()->json([
            'success' => true,
            'message' => 'Flight booking created successfully',
            'data' => ['booking' => $booking],
        ], 201);
    } catch (Exception $e) {
        Log::error('Error processing booking: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while processing your booking. Please try again. ' . $e->getMessage(),
]);
}
}

    /**
     * Mark booking as paid (call this after payment success)
     */
    public function markBookingPaid(Request $request, $id)
    {
        try {
            $booking = FlightBooking::findOrFail($id);
            $booking->update([
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
                'total_amount' => $request->amount
            ]);

            // Send confirmation emails when payment is completed
            try {
                Mail::to($booking->user->email)->send(new \App\Mail\FlightBookingMail($booking, $booking->user, false)); // User email
                
                // Send to admin
                $adminEmail = widget(1)->extra_field_2;
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new \App\Mail\FlightBookingMail($booking, $booking->user, true)); // Admin email
                }
                
                Log::info('Payment confirmation emails sent successfully', [
                    'booking_id' => $booking->id,
                    'user_email' => $booking->user->email,
                    'admin_email' => $adminEmail
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send payment confirmation emails: ' . $e->getMessage());
            }

            return response()->json(['success' => true, 'message' => 'Booking marked as paid']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to mark booking as paid', 'error' => $e->getMessage()], 500);
        }
    }


    /**
     * Get specific flight booking
     */
    public function showFlightBooking($id)
    {
        try {
            $user = request()->user();
            
            $booking = FlightBooking::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Flight booking not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $booking
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch flight booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel flight booking
     */
    public function cancelFlightBooking(Request $request, $id)
    {
        try {
            $user = $request->user();
            
            $booking = FlightBooking::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Flight booking not found'
                ], 404);
            }

            if ($booking->booking_status === 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking is already cancelled'
                ], 400);
            }

            $booking->update([
                'booking_status' => 'cancelled'
            ]);

            Log::info('Flight booking cancelled:', [
                'booking_id' => $booking->id,
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Flight booking cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Cancel flight booking error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel flight booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get hotel bookings
     */
    public function hotelBookings(Request $request)
    {
        try {
            $user = $request->user();
            
            $bookings = Hotels::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $bookings
            ]);

        } catch (\Exception $e) {
            Log::error('Get hotel bookings error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch hotel bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store hotel booking
     */
    public function storeHotelBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|integer',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1|max:10',
            'childrens' => 'sometimes|integer|min:0|max:10',
            'rooms' => 'required|integer|min:1|max:10',
            'guest_details' => 'required|array',
            'price' => 'required|string',
            'travelling_from' => 'required|string|max:255',
            'status' => 'sometimes|string|in:paid,pending,failed', // optional but recommended
            'booking_status' => 'sometimes|string|in:confirmed,pending,cancelled',
            'payment_via' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            
            // Generate booking reference
            $bookingReference = 'HTL' . strtoupper(uniqid());
            
            $booking = Hotels::create([
                'user_id' => $user->id,
                'hotel_id' => $request->hotel_id,
                'transaction_id' => $bookingReference,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'adults' => $request->adults,
                'childrens' => $request->childrens ?? 0,
                'rooms' => $request->rooms,
                'guest_details' => $request->guest_details,
                'price' => $request->price,
                'travelling_from' => $request->travelling_from, // ✅ added this
                'status' => $request->status ?? 'pending', // ✅ use provided status if available
                'payment_via' => $request->payment_via,
                'booking_status' => $request->booking_status ?? 'confirmed' // optional override
            ]);

            // Get hotel details for email
            $hotel = \App\Models\ModulesData::where('id', $request->hotel_id)->first();

            // Send confirmation emails (same as web version)
            try {
                Log::info('Attempting to send hotel booking confirmation emails', [
                    'booking_id' => $booking->id,
                    'user_email' => $user->email,
                    'hotel_id' => $hotel->id ?? 'N/A'
                ]);

                Mail::to($user->email)->send(new \App\Mail\HotelBookingMail($booking, $hotel, $user, false)); // User email
                
                // Send to admin
                $adminEmail = widget(1)->extra_field_2;
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new \App\Mail\HotelBookingMail($booking, $hotel, $user, true)); // Admin email
                }
                
                Log::info('Hotel booking confirmation emails sent successfully', [
                    'booking_id' => $booking->id,
                    'user_email' => $user->email,
                    'admin_email' => $adminEmail
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send hotel booking confirmation emails', [
                    'booking_id' => $booking->id,
                    'user_email' => $user->email,
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
                // Continue with the flow even if email fails
            }

            Log::info('Hotel booking created:', [
                'booking_id' => $booking->id,
                'user_id' => $user->id,
                'transaction_id' => $bookingReference
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hotel booking created successfully',
                'data' => [
                    'booking' => $booking,
                    'transaction_id' => $bookingReference
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Hotel booking error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create hotel booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific hotel booking
     */
  public function getUserHotelBookings()
{
    try {
        $user = request()->user();

        $bookings = Hotels::with(['hotel', 'user', 'user.country']) // <-- eager load user and country
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch bookings',
            'error' => $e->getMessage()
        ], 500);
    }
}




     public function showHotelBooking($id)
{
    try {
        $user = request()->user();

        $booking = Hotels::with([
                'hotel',
                'user.country',
                'user.state',
                'user.city'
            ])
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel booking not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $booking
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to fetch hotel booking',
            'error' => $e->getMessage()
        ], 500);
    }
}


    /**
     * Cancel hotel booking
     */
    public function cancelHotelBooking(Request $request, $id)
    {
        try {
            $user = $request->user();
            
            $booking = Hotels::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hotel booking not found'
                ], 404);
            }

            if ($booking->booking_status === 'cancelled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking is already cancelled'
                ], 400);
            }

            $booking->update([
                'booking_status' => 'cancelled'
            ]);

            Log::info('Hotel booking cancelled:', [
                'booking_id' => $booking->id,
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Hotel booking cancelled successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Cancel hotel booking error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel hotel booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Admin methods
    /**
     * Get all bookings (admin)
     */
    public function adminIndex(Request $request)
    {
        try {
            $flightBookings = FlightBooking::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            $hotelBookings = Hotels::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return response()->json([
                'success' => true,
                'data' => [
                    'flights' => $flightBookings,
                    'hotels' => $hotelBookings
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Admin get bookings error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch bookings',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update booking status (admin)
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:confirmed,cancelled,completed,pending'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Try to find flight booking
            $flightBooking = FlightBooking::find($id);
            if ($flightBooking) {
                $flightBooking->update(['booking_status' => $request->status]);
                $booking = $flightBooking;
            } else {
                // Try to find hotel booking
                $hotelBooking = Hotels::find($id);
                if ($hotelBooking) {
                    $hotelBooking->update(['booking_status' => $request->status]);
                    $booking = $hotelBooking;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Booking not found'
                    ], 404);
                }
            }

            Log::info('Booking status updated:', [
                'booking_id' => $booking->id,
                'new_status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking status updated successfully',
                'data' => $booking
            ]);

        } catch (\Exception $e) {
            Log::error('Update booking status error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update booking status',
                'error' => $e->getMessage()
            ], 500);
        }
    }   
    
    
} 
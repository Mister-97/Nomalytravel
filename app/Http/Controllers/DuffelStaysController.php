<?php

namespace App\Http\Controllers;

use App\Mail\StayBookingMail;
use App\Services\DuffelStaysService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DuffelStaysController extends Controller
{
    public function __construct(protected DuffelStaysService $stays) {}

    public function index()
    {
        return redirect()->route('hotels.index');
    }

    public function quote(Request $request)
    {
        $request->validate([
            'rate_id' => 'required|string',
        ]);

        try {
            $result = $this->stays->createQuote($request->rate_id);
            $quote  = $result['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Duffel quote failed: ' . $e->getMessage());
            return redirect()->route('hotels.index')
                ->with('error', 'That rate is no longer available. Please search again.');
        }

        if (empty($quote['id'])) {
            return redirect()->route('hotels.index')
                ->with('error', 'That rate is no longer available. Please search again.');
        }

        return view('stays.checkout', [
            'quote'  => $quote,
            'params' => $request->all(),
            // The quote response doesn't carry cancellation terms — only the
            // originating rate does, so it's forwarded from the room-select form.
            'roomName'        => $request->input('room_name'),
            'freeCancelUntil' => $request->input('free_cancel_until'),
            'nonRefundable'   => (bool) $request->input('non_refundable'),
            'cancellationTimeline' => json_decode($request->input('cancellation_timeline', '[]'), true) ?: [],
        ]);
    }

    public function reserve(Request $request)
    {
        $request->validate([
            'quote_id'          => 'required|string',
            'amount'            => 'required|numeric',
            'currency'          => 'required|string',
            'payment_intent_id' => 'required|string',
            'first_name'        => 'required|string',
            'last_name'         => 'required|string',
            'email'             => 'required|email',
            'phone'             => 'required|string',
            'base_amount'       => 'nullable|numeric',
            'tax_amount'        => 'nullable|numeric',
            'fee_amount'        => 'nullable|numeric',
            'due_at_property'   => 'nullable|numeric',
            'room_name'         => 'nullable|string',
            'free_cancel_until' => 'nullable|string',
            'non_refundable'    => 'nullable|string',
            'cancellation_timeline' => 'nullable|string',
            'check_in_time'     => 'nullable|string',
            'check_out_time'    => 'nullable|string',
        ]);

        // Payment must be captured by Stripe before we commit the Duffel booking.
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);

            $expectedAmount = (int) round((float) $request->amount * 100);
            if (
                $intent->status !== 'succeeded'
                || (int) $intent->amount !== $expectedAmount
                || strtolower($intent->currency) !== strtolower($request->currency)
            ) {
                return view('stays.confirmation', [
                    'reservation' => [],
                    'error'       => 'We could not verify your payment. You have not been charged for this booking — please try again or contact contact@nomalytravel.com.',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Stay payment verification failed: ' . $e->getMessage());
            return view('stays.confirmation', [
                'reservation' => [],
                'error'       => 'We could not verify your payment. Please contact contact@nomalytravel.com before retrying.',
            ]);
        }

        // The booking response has no pricing or cancellation fields — those only
        // exist on the rate/quote — so they're captured here as metadata and
        // re-merged onto $reservation for the email + confirmation page.
        $meta = [
            'total_amount'                => (string) $request->amount,
            'total_currency'              => strtoupper($request->currency),
            'base_amount'                 => (string) ($request->base_amount ?? 0),
            'tax_amount'                  => (string) ($request->tax_amount ?? 0),
            'fee_amount'                  => (string) ($request->fee_amount ?? 0),
            'due_at_accommodation_amount' => (string) ($request->due_at_property ?? 0),
            'room_name'                   => (string) ($request->room_name ?? ''),
            'free_cancel_until'           => (string) ($request->free_cancel_until ?? ''),
            'non_refundable'              => $request->boolean('non_refundable') ? '1' : '0',
            'cancellation_timeline'       => (string) ($request->cancellation_timeline ?? '[]'),
            'check_in_time'               => (string) ($request->check_in_time ?? ''),
            'check_out_time'              => (string) ($request->check_out_time ?? ''),
            'payment_intent_id'           => $request->payment_intent_id,
        ];

        try {
            $result = $this->stays->createBooking([
                'quote_id'     => $request->quote_id,
                'guests'       => [[
                    'given_name'  => $request->first_name,
                    'family_name' => $request->last_name,
                ]],
                'email'        => $request->email,
                'phone_number' => $this->normalizePhoneE164($request->phone),
                'metadata'     => $meta,
            ]);
            $reservation = $result['data'] ?? [];
        } catch (\Exception $e) {
            Log::error('Duffel booking failed after payment ' . $request->payment_intent_id . ': ' . $e->getMessage());

            // The guest's card was already charged — if Duffel can't confirm the room,
            // refund immediately instead of leaving them charged with no booking.
            $refunded = false;
            try {
                \Stripe\Refund::create(['payment_intent' => $request->payment_intent_id]);
                $refunded = true;
            } catch (\Exception $refundError) {
                Log::error('Auto-refund failed for ' . $request->payment_intent_id . ': ' . $refundError->getMessage());
            }

            return view('stays.confirmation', [
                'reservation' => ['total_amount' => (float) $request->amount, 'total_currency' => strtoupper($request->currency)],
                'error'       => $refunded
                    ? 'The hotel booking could not be completed, so your payment has been automatically refunded in full. Please try again or contact contact@nomalytravel.com.'
                    : 'Your payment was received but the hotel booking could not be completed. Our team has been notified — contact contact@nomalytravel.com and we will finish your booking or refund you in full.',
            ]);
        }

        $reservation = $this->mergeBookingPaymentFields($reservation, $meta);

        // Confirmation emails: guest + owner copy. Never block the booking on a mail failure.
        try {
            $guestName = trim($request->first_name . ' ' . $request->last_name);
            Mail::to($request->email)->send(new StayBookingMail($reservation, $guestName));

            $adminEmail = widget(1)->extra_field_2 ?: config('mail.from.address');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new StayBookingMail($reservation, $guestName, true));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send stay booking confirmation emails: ' . $e->getMessage());
        }

        return redirect()->route('stays.confirmation', ['id' => $reservation['id']]);
    }

    public function confirmation(string $id)
    {
        try {
            $result      = $this->stays->getBooking($id);
            $reservation = $result['data'] ?? [];
        } catch (\Exception $e) {
            $reservation = [];
            $error = 'We could not load this booking. Please check your confirmation email or contact contact@nomalytravel.com.';
        }

        if (!empty($reservation)) {
            $reservation = $this->mergeBookingPaymentFields($reservation, $reservation['metadata'] ?? []);
        }

        return view('stays.confirmation', [
            'reservation' => $reservation,
            'error'       => $error ?? null,
        ]);
    }

    // Duffel's stays/bookings response carries no pricing/cancellation data —
    // that lived on the rate/quote — so it's restored here from metadata using
    // the same field names the old reservations-shaped views/emails expect.
    private function mergeBookingPaymentFields(array $reservation, array $meta): array
    {
        if (empty($meta)) {
            return $reservation;
        }

        $reservation['total_amount']                = (float) ($meta['total_amount'] ?? 0);
        $reservation['total_currency']               = $meta['total_currency'] ?? 'USD';
        $reservation['base_amount']                  = (float) ($meta['base_amount'] ?? 0);
        $reservation['tax_amount']                   = (float) ($meta['tax_amount'] ?? 0);
        $reservation['fee_amount']                   = (float) ($meta['fee_amount'] ?? 0);
        $reservation['due_at_accommodation_amount']  = (float) ($meta['due_at_accommodation_amount'] ?? 0);
        $reservation['room_name']                    = $meta['room_name'] ?? null;
        $reservation['free_cancel_until']            = $meta['free_cancel_until'] ?? null;
        $reservation['non_refundable']               = ($meta['non_refundable'] ?? '0') === '1';
        $reservation['cancellation_timeline']        = json_decode($meta['cancellation_timeline'] ?? '[]', true) ?: [];
        $reservation['check_in_time']                = $meta['check_in_time'] ?? null;
        $reservation['check_out_time']               = $meta['check_out_time'] ?? null;

        return $reservation;
    }

    // Duffel requires E.164 (leading "+" and country code) and rejects bare
    // national numbers like "7083787367" — default to US (+1) since that's
    // the only market this site currently serves.
    private function normalizePhoneE164(string $phone): string
    {
        $digits = preg_replace('/[^+\d]/', '', $phone);

        if (str_starts_with($digits, '+')) {
            return $digits;
        }

        if (strlen($digits) === 10) {
            return '+1' . $digits;
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '1')) {
            return '+' . $digits;
        }

        return '+' . $digits;
    }
}

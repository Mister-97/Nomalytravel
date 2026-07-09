<?php

namespace App\Http\Controllers;

use App\Mail\TicketBookingMail;
use App\Services\TicketNetworkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TicketCheckoutController extends Controller
{
    public function __construct(protected TicketNetworkService $tn) {}

    public function event(int $id)
    {
        try {
            $event = $this->tn->getEvent($id);
        } catch (\Exception $e) {
            Log::error('TN event lookup failed for ' . $id . ': ' . $e->getMessage());
            $event = null;
        }

        if (!$event) {
            return redirect()->route('tickets.sports')
                ->with('error', 'That event could not be found. It may have already taken place.');
        }

        try {
            $groups = $this->tn->getTicketGroups($id);
            $error  = null;
        } catch (\Exception $e) {
            Log::error('TN ticket groups failed for event ' . $id . ': ' . $e->getMessage());
            $groups = [];
            $error  = 'Live ticket inventory is temporarily unavailable. Please try again in a few minutes.';
        }

        return view('tickets.event', [
            'event'  => $event,
            'groups' => $groups,
            'error'  => $error,
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'event_id'        => 'required|integer',
            'ticket_group_id' => 'required|integer',
            'quantity'        => 'required|integer|min:1|max:20',
        ]);

        [$event, $group, $problem] = $this->loadEventAndGroup(
            (int) $request->event_id, (int) $request->ticket_group_id, (int) $request->quantity
        );

        if ($problem) {
            return redirect()->route('tickets.event', ['id' => $request->event_id])
                ->with('error', $problem);
        }

        return view('tickets.checkout', [
            'event'    => $event,
            'group'    => $group,
            'quantity' => (int) $request->quantity,
            'total'    => round($group['price'] * (int) $request->quantity, 2),
        ]);
    }

    // The amount is always computed server-side from live Mercury inventory —
    // nothing price-related is trusted from the browser.
    public function paymentIntent(Request $request)
    {
        $request->validate([
            'event_id'        => 'required|integer',
            'ticket_group_id' => 'required|integer',
            'quantity'        => 'required|integer|min:1|max:20',
        ]);

        [, $group, $problem] = $this->loadEventAndGroup(
            (int) $request->event_id, (int) $request->ticket_group_id, (int) $request->quantity
        );

        if ($problem) {
            return response()->json(['error' => $problem], 422);
        }

        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $intent = \Stripe\PaymentIntent::create([
                'amount'   => (int) round($group['price'] * (int) $request->quantity * 100),
                'currency' => strtolower($group['currency']),
                'metadata' => [
                    'product'         => 'tn_tickets',
                    'event_id'        => (string) $request->event_id,
                    'ticket_group_id' => (string) $request->ticket_group_id,
                    'quantity'        => (string) $request->quantity,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Ticket payment intent failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment could not be started. Please try again.'], 500);
        }

        return response()->json(['clientSecret' => $intent->client_secret]);
    }

    public function reserve(Request $request)
    {
        $request->validate([
            'event_id'          => 'required|integer',
            'ticket_group_id'   => 'required|integer',
            'quantity'          => 'required|integer|min:1|max:20',
            'payment_intent_id' => 'required|string',
            'first_name'        => 'required|string',
            'last_name'         => 'required|string',
            'email'             => 'required|email',
            'phone'             => 'required|string',
        ]);

        [$event, $group, $problem] = $this->loadEventAndGroup(
            (int) $request->event_id, (int) $request->ticket_group_id, (int) $request->quantity
        );

        $expectedTotal = $group ? round($group['price'] * (int) $request->quantity, 2) : 0.0;

        // Payment must be captured by Stripe (for the server-computed price)
        // before we commit the TicketNetwork order.
        try {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $intent = \Stripe\PaymentIntent::retrieve($request->payment_intent_id);

            $paid = $intent->status === 'succeeded';
            $matches = $group
                && (int) $intent->amount === (int) round($expectedTotal * 100)
                && strtolower($intent->currency) === strtolower($group['currency'])
                && ($intent->metadata['ticket_group_id'] ?? '') === (string) $request->ticket_group_id;

            if (!$paid) {
                return view('tickets.confirmation', [
                    'error' => 'We could not verify your payment. You have not been charged — please try again or contact contact@nomalytravel.com.',
                ]);
            }

            if (!$matches) {
                // Charged, but the tickets are gone or repriced — refund immediately.
                \Stripe\Refund::create(['payment_intent' => $request->payment_intent_id]);
                return view('tickets.confirmation', [
                    'error' => 'These tickets sold out or changed price while you were checking out. Your payment has been refunded in full.',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Ticket payment verification failed: ' . $e->getMessage());
            return view('tickets.confirmation', [
                'error' => 'We could not verify your payment. Please contact contact@nomalytravel.com before retrying.',
            ]);
        }

        try {
            $order = $this->tn->placeOrder($group, (int) $request->quantity, [
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
            ]);
        } catch (\Exception $e) {
            // Demo mode: TN's sandbox broker can't place orders yet (account
            // gate, not a real failure), so simulate a confirmed order instead
            // of refunding. MUST be switched off when TN enables purchasing:
            // set TN_DEMO_MODE=false in .env.
            if (config('services.ticketnetwork.demo')) {
                Log::warning('TN demo mode: simulating order after payment ' . $request->payment_intent_id . ' (real TN error: ' . $e->getMessage() . ')');
                $order = ['orderId' => 'DEMO-' . strtoupper(\Illuminate\Support\Str::random(8))];
            } else {
                Log::error('TN order failed after payment ' . $request->payment_intent_id . ': ' . $e->getMessage());

                // The buyer's card was already charged — if TN can't confirm the
                // tickets, refund immediately instead of leaving a paid non-order.
                $refunded = false;
                try {
                    \Stripe\Refund::create(['payment_intent' => $request->payment_intent_id]);
                    $refunded = true;
                } catch (\Exception $refundError) {
                    Log::error('Ticket auto-refund failed for ' . $request->payment_intent_id . ': ' . $refundError->getMessage());
                }

                return view('tickets.confirmation', [
                    'error' => $refunded
                        ? 'The ticket order could not be completed, so your payment has been automatically refunded in full. Please try again or contact contact@nomalytravel.com.'
                        : 'Your payment was received but the ticket order could not be completed. Our team has been notified — contact contact@nomalytravel.com and we will finish your order or refund you in full.',
                ]);
            }
        }

        $booking = [
            'order_id'   => $order['orderId'] ?? $order['id'] ?? null,
            'event'      => $event,
            'group'      => $group,
            'quantity'   => (int) $request->quantity,
            'total'      => $expectedTotal,
            'currency'   => $group['currency'],
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ];

        // Confirmation emails: buyer + owner copy. Never block the order on a mail failure.
        try {
            $buyerName = trim($request->first_name . ' ' . $request->last_name);
            Mail::to($request->email)->send(new TicketBookingMail($booking, $buyerName));

            $adminEmail = widget(1)->extra_field_2 ?: config('mail.from.address');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new TicketBookingMail($booking, $buyerName, true));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send ticket confirmation emails: ' . $e->getMessage());
        }

        return view('tickets.confirmation', [
            'booking' => $booking,
            'error'   => null,
        ]);
    }

    // Re-fetches live inventory and confirms the group still exists and the
    // requested quantity is actually purchasable. Returns [event, group, problem].
    private function loadEventAndGroup(int $eventId, int $ticketGroupId, int $quantity): array
    {
        try {
            $event = $this->tn->getEvent($eventId);
            $group = $this->tn->findTicketGroup($eventId, $ticketGroupId);
        } catch (\Exception $e) {
            Log::error('TN inventory check failed: ' . $e->getMessage());
            return [null, null, 'Live ticket inventory is temporarily unavailable. Please try again in a few minutes.'];
        }

        if (!$event || !$group) {
            return [$event, null, 'Those tickets are no longer available. Please pick another listing.'];
        }

        if (!in_array($quantity, $group['quantities'] ?? [], false)) {
            return [$event, $group, 'That quantity is not available for this listing — the seller only splits it certain ways.'];
        }

        return [$event, $group, null];
    }
}

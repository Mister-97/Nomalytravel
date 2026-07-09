<x-app-layout>
@push('css')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
:root { --navy:#070D1A; --gold:#C9A84C; --gold-lt:#e8c96a; }
.stf-header { background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%); padding:36px 0; text-align:center; }
.stf-body { background:#f7f8fc; padding:40px 0 60px; min-height:60vh; }
.stf-card { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,.08); padding:26px 28px; margin-bottom:20px; }
.stf-confirm-icon { font-size:3.5rem; color:#27ae60; margin-bottom:10px; }
.stf-ref { display:inline-block; background:#f0f4ff; color:var(--navy); font-size:15px; font-weight:800; padding:10px 24px; border-radius:10px; margin:10px 0; border:2px solid #d0dbf5; letter-spacing:1px; }
.stf-err-icon { font-size:3.5rem; color:#e74c3c; margin-bottom:10px; }
.stf-section-label { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#aaa; margin-bottom:12px; display:flex; align-items:center; gap:8px; }
.stf-section-label::after { content:''; flex:1; height:1px; background:#f0f0f0; }
.stf-row { display:flex; justify-content:space-between; font-size:13px; padding:8px 0; border-bottom:1px solid #f0f0f0; }
.stf-row:last-child { border-bottom:none; }
.stf-row .lbl { color:#888; }
.stf-row .val { font-weight:700; color:var(--navy); }
.stf-total { display:flex; justify-content:space-between; padding:14px 0 0; font-size:17px; font-weight:900; }
.stf-total .val { color:var(--gold); }
.stf-btn { display:inline-block; background:linear-gradient(135deg,var(--gold),var(--gold-lt)); color:var(--navy); border:none; border-radius:10px; padding:12px 28px; font-size:14px; font-weight:800; text-decoration:none; }
.stf-btn:hover { filter:brightness(1.07); color:var(--navy); }
</style>
@endpush

@php
    $b     = $booking ?? [];
    $event = $b['event'] ?? [];
    $group = $b['group'] ?? [];
    $venue = $event['venue'] ?? [];
    $when  = !empty($event['date']) ? date('D, M j, Y g:i A', strtotime($event['date'])) : 'TBA';
@endphp

<div class="stf-header">
    <div class="container">
        @if ($error ?? null)
            <i class="fas fa-exclamation-circle stf-err-icon"></i>
            <h1 style="color:#fff;font-weight:800;font-size:1.6rem;">We hit a snag</h1>
        @else
            <i class="fas fa-check-circle stf-confirm-icon"></i>
            <h1 style="color:#fff;font-weight:800;font-size:1.6rem;">Tickets Confirmed!</h1>
        @endif
    </div>
</div>

<div class="stf-body">
    <div class="container" style="max-width:720px;">

        @if ($error ?? null)
            <div class="stf-card text-center">
                <p style="color:#c0392b;font-weight:600;">{{ $error }}</p>
                <a href="{{ route('tickets.sports') }}" class="stf-btn mt-2">Browse Events</a>
            </div>
        @else
            <div class="stf-card text-center">
                @if (!empty($b['order_id']))
                    <p style="color:#666;">Your order reference is</p>
                    <div class="stf-ref">{{ $b['order_id'] }}</div>
                @endif
                <p style="font-size:13px;color:#999;">A confirmation has been sent to {{ $b['email'] ?? 'your email address' }}.</p>
            </div>

            <div class="stf-card">
                <div class="stf-section-label"><i class="fas fa-ticket-alt" style="color:var(--gold)"></i> Event Details</div>
                <p style="font-weight:800;color:var(--navy);margin-bottom:4px;">{{ $event['name'] ?? '' }}</p>
                <p style="font-size:13px;color:#888;margin-bottom:14px;">
                    {{ $venue['name'] ?? '' }}{{ !empty($venue['city']) ? ', '.$venue['city'] : '' }}
                </p>
                <div class="stf-row"><span class="lbl"><i class="fas fa-calendar me-1" style="color:var(--gold)"></i>Date</span><span class="val">{{ $when }}</span></div>
                <div class="stf-row"><span class="lbl"><i class="fas fa-couch me-1" style="color:var(--gold)"></i>Section</span><span class="val">{{ $group['section'] ?: 'General Admission' }}{{ !empty($group['row']) ? ' · Row '.$group['row'] : '' }}</span></div>
                <div class="stf-row"><span class="lbl"><i class="fas fa-hashtag me-1" style="color:var(--gold)"></i>Quantity</span><span class="val">{{ $b['quantity'] ?? 1 }}</span></div>
                <div class="stf-row"><span class="lbl"><i class="fas fa-paper-plane me-1" style="color:var(--gold)"></i>Delivery</span><span class="val">{{ implode(', ', $group['delivery_methods'] ?? []) ?: 'E-Ticket' }}</span></div>
            </div>

            <div class="stf-card">
                <div class="stf-section-label"><i class="fas fa-credit-card" style="color:var(--gold)"></i> Payment Summary</div>
                <div class="stf-row"><span class="lbl">Price per ticket</span><span class="val">{{ $b['currency'] }} {{ number_format(($b['quantity'] ?? 1) ? $b['total'] / ($b['quantity'] ?? 1) : 0, 2) }}</span></div>
                <div class="stf-row"><span class="lbl">Quantity</span><span class="val">{{ $b['quantity'] ?? 1 }}</span></div>
                <div class="stf-total"><span>Total charged</span><span class="val">{{ $b['currency'] }} {{ number_format($b['total'] ?? 0, 2) }}</span></div>
            </div>

            <div class="stf-card" style="border:1px solid #fef0d6;">
                <div class="stf-section-label"><i class="fas fa-envelope-open-text" style="color:var(--gold)"></i> Ticket Delivery</div>
                <p style="font-size:13px;color:#555;margin-bottom:0;">
                    Your tickets will be delivered to <strong>{{ $b['email'] ?? '' }}</strong>.
                    E-Tickets typically arrive by email before the event; if the event is close, they usually arrive within hours of purchase.
                </p>
            </div>

            <div class="stf-card" style="background:#f8f9fc;box-shadow:none;border:1px solid #eee;">
                <p style="font-weight:700;color:#666;font-size:13px;margin-bottom:4px;">Nomaly Travel</p>
                <p style="font-size:12px;color:#999;margin-bottom:0;">
                    All ticket sales are final unless the event is cancelled and not rescheduled.
                    This order is subject to our <a href="/terms" target="_blank" style="color:var(--gold);">Terms &amp; Conditions</a>.
                    For support, email contact@nomalytravel.com.
                </p>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('tickets.sports') }}" class="stf-btn"><i class="fas fa-search me-2"></i>Browse More Events</a>
            </div>
        @endif

    </div>
</div>

</x-app-layout>

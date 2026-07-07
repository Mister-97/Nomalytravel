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
    $r        = $reservation ?? [];
    $acc      = $r['accommodation'] ?? [];
    $addr     = $acc['location']['address'] ?? [];
    $guests   = $r['guests'] ?? [];
@endphp

<div class="stf-header">
    <div class="container">
        @if ($error ?? null)
            <i class="fas fa-exclamation-circle stf-err-icon"></i>
            <h1 style="color:#fff;font-weight:800;font-size:1.6rem;">We hit a snag</h1>
        @else
            <i class="fas fa-check-circle stf-confirm-icon"></i>
            <h1 style="color:#fff;font-weight:800;font-size:1.6rem;">Booking Confirmed!</h1>
        @endif
    </div>
</div>

<div class="stf-body">
    <div class="container" style="max-width:720px;">

        @if ($error ?? null)
            <div class="stf-card text-center">
                <p style="color:#c0392b;font-weight:600;">{{ $error }}</p>
                @if (!empty($r['total_amount']))
                    <p style="font-size:13px;color:#888;">Amount charged: {{ $r['total_currency'] ?? 'USD' }} {{ number_format($r['total_amount'], 2) }}</p>
                @endif
                <a href="{{ route('hotels.index') }}" class="stf-btn mt-2">Search Hotels</a>
            </div>
        @else
            <div class="stf-card text-center">
                <p style="color:#666;">Your reservation reference is</p>
                <div class="stf-ref">{{ $r['reference'] ?? $r['id'] ?? 'N/A' }}</div>
                <p style="font-size:13px;color:#999;">A confirmation has been sent to your email address.</p>
            </div>

            <div class="stf-card">
                <div class="stf-section-label"><i class="fas fa-hotel" style="color:var(--gold)"></i> Stay Details</div>
                <p style="font-weight:800;color:var(--navy);margin-bottom:4px;">{{ $acc['name'] ?? 'Your Stay' }}</p>
                <p style="font-size:13px;color:#888;margin-bottom:14px;">
                    {{ $addr['line_one'] ?? '' }}{{ !empty($addr['city_name']) ? ', '.$addr['city_name'] : '' }}
                </p>
                <div class="stf-row"><span class="lbl"><i class="fas fa-calendar-check me-1" style="color:var(--gold)"></i>Check-in</span><span class="val">{{ $r['check_in_date'] ?? '' }}</span></div>
                <div class="stf-row"><span class="lbl"><i class="fas fa-calendar-times me-1" style="color:var(--gold)"></i>Check-out</span><span class="val">{{ $r['check_out_date'] ?? '' }}</span></div>
                <div class="stf-row"><span class="lbl"><i class="fas fa-info-circle me-1" style="color:var(--gold)"></i>Status</span><span class="val text-capitalize">{{ $r['status'] ?? 'confirmed' }}</span></div>
            </div>

            @if (!empty($r['total_amount']))
            <div class="stf-card">
                <div class="stf-section-label"><i class="fas fa-credit-card" style="color:var(--gold)"></i> Payment Summary</div>
                @if (!empty($r['room_name']))<div class="stf-row"><span class="lbl">Room</span><span class="val">{{ $r['room_name'] }}</span></div>@endif
                <div class="stf-row"><span class="lbl">Base rate</span><span class="val">{{ $r['total_currency'] }} {{ number_format($r['base_amount'] ?? 0, 2) }}</span></div>
                <div class="stf-row"><span class="lbl">Tax</span><span class="val">{{ $r['total_currency'] }} {{ number_format($r['tax_amount'] ?? 0, 2) }}</span></div>
                <div class="stf-row"><span class="lbl">Fees</span><span class="val">{{ $r['total_currency'] }} {{ number_format($r['fee_amount'] ?? 0, 2) }}</span></div>
                @if (!empty($r['due_at_accommodation_amount']))
                <div class="stf-row"><span class="lbl">Due at property</span><span class="val">{{ $r['total_currency'] }} {{ number_format($r['due_at_accommodation_amount'], 2) }}</span></div>
                @endif
                <div class="stf-total"><span>Total charged</span><span class="val">{{ $r['total_currency'] }} {{ number_format($r['total_amount'], 2) }}</span></div>
            </div>

            <div class="stf-card">
                <div class="stf-section-label"><i class="fas fa-undo" style="color:var(--gold)"></i> Cancellation Policy</div>
                @if (!empty($r['free_cancel_until']))
                    <p style="font-size:13px;color:#27ae60;font-weight:700;">Free cancellation before {{ date('M j, Y g:i A', strtotime($r['free_cancel_until'])) }}</p>
                @elseif (!empty($r['non_refundable']))
                    <p style="font-size:13px;color:#c0392b;font-weight:700;">Non-refundable — this rate cannot be cancelled or refunded.</p>
                @else
                    <p style="font-size:13px;color:#888;">Contact the property or Nomaly Travel for cancellation details.</p>
                @endif
            </div>
            @endif

            <div class="stf-card" style="border:1px solid #fef0d6;">
                <div class="stf-section-label"><i class="fas fa-key" style="color:var(--gold)"></i> Key Collection</div>
                @if (!empty($acc['key_collection']['instructions']))
                    <p style="font-size:13px;color:#555;">{{ $acc['key_collection']['instructions'] }}</p>
                @else
                    <p style="font-size:13px;color:#888;">Key collection details will be provided by the property. Check your confirmation email or contact them directly.</p>
                @endif
            </div>

            @if (!empty($guests))
            <div class="stf-card">
                <div class="stf-section-label"><i class="fas fa-users" style="color:var(--gold)"></i> Guest Details</div>
                @foreach ($guests as $guest)
                    <p style="font-size:13px;color:#555;">{{ $guest['given_name'] ?? '' }} {{ $guest['family_name'] ?? '' }}</p>
                @endforeach
                @if (!empty($r['email']))<p style="font-size:13px;color:#888;"><i class="fas fa-envelope me-1"></i>{{ $r['email'] }}</p>@endif
                @if (!empty($r['phone_number']))<p style="font-size:13px;color:#888;"><i class="fas fa-phone me-1"></i>{{ $r['phone_number'] }}</p>@endif
            </div>
            @endif

            <div class="stf-card" style="background:#f8f9fc;box-shadow:none;border:1px solid #eee;">
                <p style="font-weight:700;color:#666;font-size:13px;margin-bottom:4px;">Nomaly Travel</p>
                <p style="font-size:12px;color:#999;margin-bottom:0;">
                    This booking is subject to our <a href="/terms" target="_blank" style="color:var(--gold);">Terms &amp; Conditions</a>.
                    For support, email contact@nomalytravel.com.
                </p>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('hotels.index') }}" class="stf-btn"><i class="fas fa-search me-2"></i>Search More Hotels</a>
            </div>
        @endif

    </div>
</div>

</x-app-layout>

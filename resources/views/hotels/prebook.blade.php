<x-app-layout>
@push('css')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
:root { --navy:#070D1A; --gold:#C9A84C; --gold-lt:#e8c96a; }
.htb-header { background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%); padding:28px 0; }
.htb-header h2 { color:var(--gold); font-weight:900; font-size:1.4rem; margin:0; }
.htb-back { color:var(--gold); text-decoration:none; font-size:13px; font-weight:600; }
.htb-back:hover { color:var(--gold-lt); }
.htb-body { background:#f7f8fc; padding:40px 0 60px; min-height:60vh; }

/* Summary card */
.htb-summary { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,.08); padding:22px 26px; margin-bottom:24px; }
.htb-summary-title { font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#aaa; margin-bottom:14px; }
.htb-summary-hotel { font-size:18px; font-weight:800; color:var(--navy); margin-bottom:4px; }
.htb-summary-room  { font-size:13px; color:#777; margin-bottom:14px; }
.htb-row { display:flex; justify-content:space-between; font-size:13px; padding:8px 0; border-bottom:1px solid #f0f0f0; }
.htb-row:last-child { border-bottom:none; }
.htb-row .lbl { color:#888; }
.htb-row .val { font-weight:700; color:var(--navy); }
.htb-total { display:flex; justify-content:space-between; padding:14px 0 0; font-size:18px; font-weight:900; }
.htb-total .val { color:var(--gold); }

/* Form card */
.htb-form-card { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,.08); padding:26px 28px; }
.htb-section-label { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#aaa; margin-bottom:14px; margin-top:4px; display:flex; align-items:center; gap:8px; }
.htb-section-label::after { content:''; flex:1; height:1px; background:#f0f0f0; }
.htb-field { margin-bottom:14px; }
.htb-field label { display:block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#666; margin-bottom:5px; }
.htb-field input { width:100%; border:1.5px solid #dde2ec; border-radius:10px; padding:11px 14px; font-size:14px; font-family:'DM Sans',sans-serif; outline:none; transition:border-color .2s; }
.htb-field input:focus { border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,.12); }
.htb-card-wrap { border:1.5px solid #dde2ec; border-radius:10px; padding:13px 14px; }
.htb-card-wrap.focused { border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,.12); }
.htb-card-err { font-size:12px; color:#e74c3c; margin-top:6px; min-height:18px; }
.htb-msg { border-radius:10px; padding:12px 16px; font-size:13px; margin-top:12px; display:none; }
.htb-msg.err  { background:#fef0f0; color:#c0392b; border:1px solid #f5c6cb; display:block; }
.htb-msg.ok   { background:#eafaf1; color:#1e8449; border:1px solid #a9dfbf; display:block; }

/* Pay button */
.htb-pay-btn { display:block; width:100%; margin-top:20px; background:linear-gradient(135deg,var(--gold),var(--gold-lt)); color:var(--navy); border:none; border-radius:11px; padding:15px; font-size:15px; font-weight:800; font-family:'DM Sans',sans-serif; cursor:pointer; transition:all .2s; }
.htb-pay-btn:hover:not(:disabled) { filter:brightness(1.07); transform:translateY(-1px); }
.htb-pay-btn:disabled { opacity:.6; cursor:not-allowed; transform:none; }
.htb-secure { text-align:center; font-size:11px; color:#bbb; margin-top:10px; }

/* Confirmation */
.htb-confirm { text-align:center; padding:40px 20px; }
.htb-confirm-icon { font-size:4rem; color:#27ae60; margin-bottom:16px; }
.htb-confirm h3 { font-size:22px; font-weight:900; color:var(--navy); margin-bottom:8px; }
.htb-confirm p { font-size:14px; color:#666; }
.htb-ref { display:inline-block; background:#f0f4ff; color:var(--navy); font-size:15px; font-weight:800; padding:10px 24px; border-radius:10px; margin:12px 0; border:2px solid #d0dbf5; letter-spacing:1px; }
</style>
@endpush

@php
    $hotel    = $prebook['hotel'] ?? [];
    $room     = $prebook['roomType'] ?? [];
    $rate     = $prebook['rate'] ?? $prebook;
    $total    = $rate['retailRate']['total'][0]['amount'] ?? ($rate['price'] ?? null);
    $currency = $rate['retailRate']['total'][0]['currency'] ?? 'USD';
    $checkin  = $prebook['checkin'] ?? '';
    $checkout = $prebook['checkout'] ?? '';
    $prebookId = $prebook['prebookId'] ?? '';
    $hotelName = $hotel['name'] ?? 'Hotel';
    $roomName  = $room['name'] ?? 'Standard Room';
    $nights    = ($checkin && $checkout) ? max(1,(int)((strtotime($checkout)-strtotime($checkin))/86400)) : 1;
@endphp

<div class="htb-header">
    <div class="container d-flex justify-content:space-between align-items-center">
        <h2><i class="fas fa-clipboard-check me-2"></i>Complete Your Booking</h2>
        <a href="javascript:history.back()" class="htb-back ms-auto"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

<div class="htb-body">
    <div class="container">
        @if(empty($prebook) || !$prebookId)
            <div class="text-center py-5">
                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3 d-block"></i>
                <h5>Rate expired or unavailable</h5>
                <p class="text-muted">Room rates expire quickly. Please search again and select a room.</p>
                <a href="{{ route('hotels.index') }}" class="btn btn-outline-secondary mt-2">Search Again</a>
            </div>
        @else
        <div class="row g-4 justify-content-center">

            {{-- LEFT: Form --}}
            <div class="col-lg-7">
                <div id="htb-booking-form">
                    <div class="htb-form-card">

                        <div class="htb-section-label"><i class="fas fa-user me-1" style="color:var(--gold)"></i>Guest Information</div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="htb-field">
                                    <label>First Name *</label>
                                    <input type="text" id="htb-fn" placeholder="John" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="htb-field">
                                    <label>Last Name *</label>
                                    <input type="text" id="htb-ln" placeholder="Smith" required>
                                </div>
                            </div>
                        </div>
                        <div class="htb-field">
                            <label>Email Address *</label>
                            <input type="email" id="htb-em" placeholder="john@example.com" required>
                        </div>
                        <div class="htb-field">
                            <label>Phone Number</label>
                            <input type="tel" id="htb-ph" placeholder="+1 (555) 000-0000">
                        </div>

                        <div class="htb-section-label" style="margin-top:20px;"><i class="fas fa-credit-card me-1" style="color:var(--gold)"></i>Payment Details</div>
                        <div class="htb-field">
                            <label>Card Details *</label>
                            <div class="htb-card-wrap" id="htb-card-wrap">
                                <div id="htb-card-el"></div>
                            </div>
                            <div class="htb-card-err" id="htb-card-err"></div>
                        </div>

                        <div class="htb-msg" id="htb-msg"></div>

                        <button class="htb-pay-btn" id="htb-pay-btn" onclick="htbSubmit()">
                            <i class="fas fa-lock me-2"></i>
                            Pay {{ $currency }} {{ number_format($total, 2) }} &amp; Confirm Booking
                        </button>
                        <p class="htb-secure"><i class="fas fa-shield-alt me-1"></i>Secured by Stripe · SSL Encrypted · Instant Confirmation</p>
                    </div>
                </div>

                {{-- Confirmation (hidden until success) --}}
                <div id="htb-confirmed" style="display:none;">
                    <div class="htb-form-card htb-confirm">
                        <div class="htb-confirm-icon"><i class="fas fa-check-circle"></i></div>
                        <h3>Booking Confirmed!</h3>
                        <p>Your room has been booked. A confirmation has been sent to your email.</p>
                        <div class="htb-ref" id="htb-booking-ref"></div>
                        <p style="font-size:13px;color:#999;" id="htb-booking-hotel"></p>
                        <a href="{{ route('hotels.index') }}" class="htb-pay-btn mt-3" style="text-decoration:none;display:inline-block;width:auto;padding:12px 30px;">
                            <i class="fas fa-search me-2"></i>Search More Hotels
                        </a>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Summary --}}
            <div class="col-lg-4">
                <div class="htb-summary" style="position:sticky;top:72px;">
                    <div class="htb-summary-title">Booking Summary</div>
                    <div class="htb-summary-hotel">{{ $hotelName }}</div>
                    <div class="htb-summary-room"><i class="fas fa-bed me-1" style="color:var(--gold)"></i>{{ $roomName }}</div>
                    @if($checkin)
                    <div class="htb-row">
                        <span class="lbl"><i class="fas fa-calendar-check me-1" style="color:var(--gold)"></i>Check-in</span>
                        <span class="val">{{ date('M d, Y', strtotime($checkin)) }}</span>
                    </div>
                    @endif
                    @if($checkout)
                    <div class="htb-row">
                        <span class="lbl"><i class="fas fa-calendar-times me-1" style="color:var(--gold)"></i>Check-out</span>
                        <span class="val">{{ date('M d, Y', strtotime($checkout)) }}</span>
                    </div>
                    @endif
                    <div class="htb-row">
                        <span class="lbl"><i class="fas fa-moon me-1" style="color:var(--gold)"></i>Nights</span>
                        <span class="val">{{ $nights }}</span>
                    </div>
                    @if($total)
                    <div class="htb-total">
                        <span>Total</span>
                        <span class="val">{{ $currency }} {{ number_format($total, 2) }}</span>
                    </div>
                    @endif
                    <div style="margin-top:14px;padding-top:14px;border-top:1px solid #f0f0f0;font-size:11px;color:#bbb;text-align:center;">
                        <i class="fas fa-redo me-1"></i>Free cancellation may be available · See room policy
                    </div>
                </div>
            </div>

        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
var _htbStripe = null, _htbCard = null;
var _prebookId = '{{ $prebookId ?? '' }}';
var _amount    = {{ $total ?? 0 }};
var _currency  = '{{ strtolower($currency ?? 'usd') }}';
var _csrf      = document.querySelector('meta[name="csrf-token"]')?.content || '';

// Load Stripe
(function(){
    var s = document.createElement('script');
    s.src = 'https://js.stripe.com/v3/';
    s.onload = function(){
        _htbStripe = Stripe('{{ config("services.stripe.key") }}');
        var els = _htbStripe.elements();
        _htbCard = els.create('card', {
            style:{ base:{ fontSize:'14px', color:'#070D1A', fontFamily:'DM Sans, sans-serif', '::placeholder':{ color:'#bbb' } } }
        });
        _htbCard.mount('#htb-card-el');
        _htbCard.on('focus', function(){ document.getElementById('htb-card-wrap').classList.add('focused'); });
        _htbCard.on('blur',  function(){ document.getElementById('htb-card-wrap').classList.remove('focused'); });
        _htbCard.on('change', function(e){
            document.getElementById('htb-card-err').textContent = e.error ? e.error.message : '';
        });
    };
    document.head.appendChild(s);
})();

function htbSetMsg(txt, type) {
    var el = document.getElementById('htb-msg');
    el.className = 'htb-msg ' + type;
    el.innerHTML = txt;
}

async function htbSubmit() {
    var fn = document.getElementById('htb-fn').value.trim();
    var ln = document.getElementById('htb-ln').value.trim();
    var em = document.getElementById('htb-em').value.trim();
    var ph = document.getElementById('htb-ph').value.trim();

    if (!fn || !ln || !em) { htbSetMsg('Please fill in your first name, last name, and email.', 'err'); return; }
    if (!em.includes('@'))  { htbSetMsg('Please enter a valid email address.', 'err'); return; }
    if (!_htbStripe || !_htbCard) { htbSetMsg('Payment not loaded yet. Please wait a moment.', 'err'); return; }

    var btn = document.getElementById('htb-pay-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing…';
    document.getElementById('htb-msg').className = 'htb-msg';

    try {
        // Step 1: Create Stripe PaymentIntent
        var piRes = await fetch('{{ route('hotels.payment.intent') }}', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': _csrf, 'X-Requested-With':'XMLHttpRequest' },
            body: JSON.stringify({ amount: _amount, currency: _currency })
        });
        var piData = await piRes.json();
        if (piData.error) throw new Error(piData.error);

        // Step 2: Confirm card with Stripe
        var { paymentIntent, error } = await _htbStripe.confirmCardPayment(piData.clientSecret, {
            payment_method: { card: _htbCard, billing_details: { name: fn + ' ' + ln, email: em } }
        });
        if (error) { document.getElementById('htb-card-err').textContent = error.message; throw new Error(error.message); }

        // Step 3: Book with LiteAPI
        var bookRes = await fetch('{{ route('hotels.book') }}', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': _csrf, 'X-Requested-With':'XMLHttpRequest' },
            body: JSON.stringify({
                prebook_id: _prebookId,
                first_name: fn, last_name: ln, email: em, phone: ph,
                payment_intent_id: paymentIntent.id
            })
        });
        var bookData = await bookRes.json();

        if (bookData.success) {
            document.getElementById('htb-booking-form').style.display = 'none';
            document.getElementById('htb-confirmed').style.display = 'block';
            document.getElementById('htb-booking-ref').textContent  = 'Ref: ' + bookData.bookingId;
            document.getElementById('htb-booking-hotel').textContent = bookData.hotel + ' · ' + bookData.checkin + ' → ' + bookData.checkout;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            throw new Error(bookData.error || 'Booking failed after payment. Please contact support.');
        }
    } catch(e) {
        if (e.message !== document.getElementById('htb-card-err').textContent) {
            htbSetMsg('<i class="fas fa-exclamation-triangle me-2"></i>' + e.message, 'err');
        }
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-lock me-2"></i>Retry Payment';
    }
}
</script>
@endpush

</x-app-layout>

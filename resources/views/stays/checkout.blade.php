<x-app-layout>
@push('css')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
:root { --navy:#070D1A; --gold:#C9A84C; --gold-lt:#e8c96a; }
.stc-header { background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%); padding:28px 0; }
.stc-header h2 { color:var(--gold); font-weight:900; font-size:1.4rem; margin:0; }
.stc-back { color:var(--gold); text-decoration:none; font-size:13px; font-weight:600; }
.stc-back:hover { color:var(--gold-lt); }
.stc-body { background:#f7f8fc; padding:40px 0 60px; min-height:60vh; }

.stc-summary { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,.08); padding:22px 26px; margin-bottom:24px; }
.stc-summary-title { font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#aaa; margin-bottom:14px; }
.stc-summary-hotel { font-size:18px; font-weight:800; color:var(--navy); margin-bottom:4px; }
.stc-summary-dates { font-size:13px; color:#777; margin-bottom:14px; }
.stc-row { display:flex; justify-content:space-between; font-size:13px; padding:8px 0; border-bottom:1px solid #f0f0f0; }
.stc-row:last-child { border-bottom:none; }
.stc-row .lbl { color:#888; }
.stc-row .val { font-weight:700; color:var(--navy); }
.stc-total { display:flex; justify-content:space-between; padding:14px 0 0; font-size:18px; font-weight:900; }
.stc-total .val { color:var(--gold); }

.stc-policy { background:#fef9e7; border:1px solid #f0e2b0; border-radius:12px; padding:16px 18px; margin-bottom:24px; }
.stc-policy h6 { font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:.6px; color:#8a6d1a; margin-bottom:6px; }
.stc-policy p { font-size:13px; color:#6b5a1e; margin:0 0 4px; }

.stc-form-card { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,.08); padding:26px 28px; }
.stc-section-label { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; color:#aaa; margin-bottom:14px; margin-top:4px; display:flex; align-items:center; gap:8px; }
.stc-section-label::after { content:''; flex:1; height:1px; background:#f0f0f0; }
.stc-field { margin-bottom:14px; }
.stc-field label { display:block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#666; margin-bottom:5px; }
.stc-field input { width:100%; border:1.5px solid #dde2ec; border-radius:10px; padding:11px 14px; font-size:14px; font-family:'DM Sans',sans-serif; outline:none; transition:border-color .2s; }
.stc-field input:focus { border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,.12); }
.stc-card-wrap { border:1.5px solid #dde2ec; border-radius:10px; padding:13px 14px; }
.stc-card-wrap.focused { border-color:var(--gold); box-shadow:0 0 0 3px rgba(201,168,76,.12); }
.stc-card-err { font-size:12px; color:#e74c3c; margin-top:6px; min-height:18px; }
.stc-msg { border-radius:10px; padding:12px 16px; font-size:13px; margin-top:12px; display:none; }
.stc-msg.err { background:#fef0f0; color:#c0392b; border:1px solid #f5c6cb; display:block; }
.stc-agree { font-size:12px; color:#888; margin-top:14px; display:flex; align-items:flex-start; gap:8px; }
.stc-agree input { margin-top:3px; }
.stc-agree a { color:var(--gold); font-weight:700; }

.stc-pay-btn { display:block; width:100%; margin-top:18px; background:linear-gradient(135deg,var(--gold),var(--gold-lt)); color:var(--navy); border:none; border-radius:11px; padding:15px; font-size:15px; font-weight:800; font-family:'DM Sans',sans-serif; cursor:pointer; transition:all .2s; }
.stc-pay-btn:hover:not(:disabled) { filter:brightness(1.07); transform:translateY(-1px); }
.stc-pay-btn:disabled { opacity:.6; cursor:not-allowed; transform:none; }
.stc-secure { text-align:center; font-size:11px; color:#bbb; margin-top:10px; }
</style>
@endpush

@php
    $q          = $quote;
    $baseAmount = (float) ($q['base_amount'] ?? 0);
    $taxAmt     = (float) ($q['tax_amount'] ?? 0);
    $feeAmt     = (float) ($q['fee_amount'] ?? 0);
    $dueAtProp  = (float) ($q['due_at_accommodation_amount'] ?? 0);
    $total      = (float) ($q['total_amount'] ?? 0);
    $currency   = $q['total_currency'] ?? 'USD';
    $accName    = $q['accommodation']['name'] ?? 'Your Stay';
    $roomName   = $roomName ?: ($q['rooms'][0]['name'] ?? null);
    $checkIn    = $q['check_in_date'] ?? '';
    $checkOut   = $q['check_out_date'] ?? '';
    $nights     = ($checkIn && $checkOut) ? max(1, (int)((strtotime($checkOut)-strtotime($checkIn))/86400)) : 1;
    // Duffel returns 24-hour "HH:MM" strings; display them 12-hour with AM/PM.
    $fmtHotelTime = function($t) {
        if (!$t || preg_match('/[AaPp][Mm]/', $t)) return $t;
        $ts = strtotime($t);
        return $ts ? date('g:i A', $ts) : $t;
    };
    $checkInTime  = $fmtHotelTime($q['accommodation']['check_in_information']['check_in_after_time'] ?? '') ?: '3:00 PM';
    $checkOutTime = $fmtHotelTime($q['accommodation']['check_in_information']['check_out_before_time'] ?? '') ?: '12:00 PM';
    $cancellationTimeline = $cancellationTimeline ?? [];
@endphp

<div class="stc-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-clipboard-check me-2"></i>Complete Your Booking</h2>
        <a href="javascript:history.back()" class="stc-back"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

<div class="stc-body">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="row g-4 justify-content-center">

            {{-- LEFT: Form --}}
            <div class="col-lg-7">

                <div class="stc-policy">
                    <h6><i class="fas fa-info-circle me-1"></i> Cancellation Policy</h6>
                    @if (!empty($cancellationTimeline))
                        @foreach ($cancellationTimeline as $ct)
                            <p><strong>Cancel before {{ date('M j, Y g:i A', strtotime($ct['before'] ?? '')) }}:</strong> refund of {{ $ct['currency'] ?? $currency }} {{ number_format((float)($ct['refund_amount'] ?? 0), 2) }}</p>
                        @endforeach
                    @elseif ($freeCancelUntil)
                        <p><strong style="color:#1e8449;">Free cancellation</strong> before {{ date('M j, Y g:i A', strtotime($freeCancelUntil)) }}.</p>
                    @elseif ($nonRefundable)
                        <p><strong style="color:#c0392b;">Non-refundable.</strong> This rate cannot be cancelled or refunded.</p>
                    @else
                        <p>Please review the room's cancellation policy on the hotel page before booking.</p>
                    @endif
                </div>

                <div class="stc-form-card">

                    <div class="stc-section-label"><i class="fas fa-user me-1" style="color:var(--gold)"></i>Guest Information</div>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stc-field">
                                <label>First Name *</label>
                                <input type="text" id="stc-fn" placeholder="John" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stc-field">
                                <label>Last Name *</label>
                                <input type="text" id="stc-ln" placeholder="Smith" required>
                            </div>
                        </div>
                    </div>
                    <div class="stc-field">
                        <label>Email Address *</label>
                        <input type="email" id="stc-em" placeholder="john@example.com" required>
                    </div>
                    <div class="stc-field">
                        <label>Phone Number (with country code) *</label>
                        <input type="tel" id="stc-ph" placeholder="+1 555 555 0100" required>
                    </div>

                    <div class="stc-section-label" style="margin-top:20px;"><i class="fas fa-credit-card me-1" style="color:var(--gold)"></i>Payment Details</div>
                    <div class="stc-field">
                        <label>Card Details *</label>
                        <div class="stc-card-wrap" id="stc-card-wrap">
                            <div id="stc-card-el"></div>
                        </div>
                        <div class="stc-card-err" id="stc-card-err"></div>
                    </div>

                    <label class="stc-agree">
                        <input type="checkbox" id="stc-agree" required>
                        <span>I agree to the <a href="/terms" target="_blank">Terms &amp; Conditions</a> and the property's cancellation policy shown above.</span>
                    </label>

                    <div class="stc-msg" id="stc-msg"></div>

                    <button class="stc-pay-btn" id="stc-pay-btn" onclick="stcSubmit()">
                        <i class="fas fa-lock me-2"></i>
                        Pay {{ $currency }} {{ number_format($total, 2) }} &amp; Confirm Booking
                    </button>
                    <p class="stc-secure"><i class="fas fa-shield-alt me-1"></i>Secured by Stripe · SSL Encrypted · Instant Confirmation</p>
                </div>
            </div>

            {{-- RIGHT: Summary --}}
            <div class="col-lg-4">
                <div class="stc-summary" style="position:sticky;top:72px;">
                    <div class="stc-summary-title">Booking Summary</div>
                    <div class="stc-summary-hotel">{{ $accName }}</div>
                    @if($roomName)<div class="stc-summary-dates"><i class="fas fa-bed me-1" style="color:var(--gold);"></i>{{ $roomName }}</div>@endif
                    <div class="stc-summary-dates">
                        {{ $checkIn ? date('M d, Y', strtotime($checkIn)) : '' }} &ndash; {{ $checkOut ? date('M d, Y', strtotime($checkOut)) : '' }}
                        &bull; {{ $nights }} night{{ $nights>1?'s':'' }}
                    </div>
                    <div class="stc-summary-dates" style="margin-top:-8px;">
                        Check-in from {{ $checkInTime }} &bull; Check-out by {{ $checkOutTime }}
                    </div>
                    <div class="stc-row"><span class="lbl">Base rate</span><span class="val">{{ $currency }} {{ number_format($baseAmount, 2) }}</span></div>
                    <div class="stc-row"><span class="lbl">Tax</span><span class="val">{{ $currency }} {{ number_format($taxAmt, 2) }}</span></div>
                    <div class="stc-row"><span class="lbl">Fees</span><span class="val">{{ $currency }} {{ number_format($feeAmt, 2) }}</span></div>
                    @if($dueAtProp > 0)
                    <div class="stc-row"><span class="lbl">Due at property</span><span class="val">{{ $currency }} {{ number_format($dueAtProp, 2) }}</span></div>
                    @endif
                    <div class="stc-total"><span>Total charged now</span><span class="val">{{ $currency }} {{ number_format($total, 2) }}</span></div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
var _stcStripe = null, _stcCard = null;
var _stcQuoteId  = '{{ $q['id'] ?? '' }}';
var _stcAmount   = {{ $total ?? 0 }};
var _stcCurrency = '{{ strtolower($currency ?? 'usd') }}';
var _csrf        = document.querySelector('meta[name="csrf-token"]')?.content || '';
// Forwarded so the booking confirmation (no pricing/policy fields of its own) can
// still show the real breakdown — see DuffelStaysController::mergeBookingPaymentFields.
var _stcBaseAmount  = {{ $baseAmount ?? 0 }};
var _stcTaxAmount   = {{ $taxAmt ?? 0 }};
var _stcFeeAmount   = {{ $feeAmt ?? 0 }};
var _stcDueAtProp   = {{ $dueAtProp ?? 0 }};
var _stcRoomName    = {!! json_encode($roomName ?? '') !!};
var _stcFreeCancel  = {!! json_encode($freeCancelUntil ?? '') !!};
var _stcNonRefund   = {{ $nonRefundable ? 'true' : 'false' }};
var _stcCancelTimeline = {!! json_encode($cancellationTimeline ?? []) !!};
var _stcCheckInTime  = {!! json_encode($checkInTime ?? '') !!};
var _stcCheckOutTime = {!! json_encode($checkOutTime ?? '') !!};

(function(){
    var s = document.createElement('script');
    s.src = 'https://js.stripe.com/v3/';
    s.onload = function(){
        _stcStripe = Stripe('{{ config("services.stripe.key") }}');
        var els = _stcStripe.elements();
        _stcCard = els.create('card', {
            style:{ base:{ fontSize:'14px', color:'#070D1A', fontFamily:'DM Sans, sans-serif', '::placeholder':{ color:'#bbb' } } }
        });
        _stcCard.mount('#stc-card-el');
        _stcCard.on('focus', function(){ document.getElementById('stc-card-wrap').classList.add('focused'); });
        _stcCard.on('blur',  function(){ document.getElementById('stc-card-wrap').classList.remove('focused'); });
        _stcCard.on('change', function(e){
            document.getElementById('stc-card-err').textContent = e.error ? e.error.message : '';
        });
    };
    document.head.appendChild(s);
})();

function stcSetMsg(txt) {
    var el = document.getElementById('stc-msg');
    el.className = 'stc-msg err';
    el.innerHTML = txt;
}

// Server/Stripe errors aren't always plain strings — pull the real message out
// instead of letting `new Error(obj)` collapse it to "[object Object]".
function stcErrText(v) {
    if (!v) return 'Something went wrong. Please try again.';
    if (typeof v === 'string') return v;
    if (typeof v.message === 'string') return v.message;
    if (v.error) return stcErrText(v.error);
    try { return JSON.stringify(v); } catch (e) { return 'Something went wrong. Please try again.'; }
}

async function stcSubmit() {
    var fn = document.getElementById('stc-fn').value.trim();
    var ln = document.getElementById('stc-ln').value.trim();
    var em = document.getElementById('stc-em').value.trim();
    var ph = document.getElementById('stc-ph').value.trim();
    var agreed = document.getElementById('stc-agree').checked;

    if (!fn || !ln || !em || !ph) { stcSetMsg('Please fill in all guest details.'); return; }
    if (!em.includes('@')) { stcSetMsg('Please enter a valid email address.'); return; }
    if (!agreed) { stcSetMsg('Please agree to the Terms &amp; Conditions to continue.'); return; }
    if (!_stcStripe || !_stcCard) { stcSetMsg('Payment not loaded yet. Please wait a moment.'); return; }

    var btn = document.getElementById('stc-pay-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing…';
    document.getElementById('stc-msg').className = 'stc-msg';

    try {
        var piRes = await fetch('{{ route('hotels.payment.intent') }}', {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': _csrf, 'X-Requested-With':'XMLHttpRequest' },
            body: JSON.stringify({ amount: _stcAmount, currency: _stcCurrency })
        });
        var piText = await piRes.text();
        var piData;
        try { piData = JSON.parse(piText); } catch (e) {
            console.error('Payment-intent response was not JSON:', piRes.status, piText);
            throw new Error('Payment could not be started (server returned an unexpected response). Please try again.');
        }
        if (!piRes.ok || piData.error) {
            console.error('Payment-intent error:', piRes.status, piData);
            throw new Error(stcErrText(piData.error) + (piRes.ok ? '' : ' (HTTP ' + piRes.status + ')'));
        }

        var { paymentIntent, error } = await _stcStripe.confirmCardPayment(piData.clientSecret, {
            payment_method: { card: _stcCard, billing_details: { name: fn + ' ' + ln, email: em } }
        });
        if (error) {
            console.error('Stripe confirmCardPayment error:', error);
            var msg = stcErrText(error);
            document.getElementById('stc-card-err').textContent = msg;
            throw new Error(msg);
        }

        var form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('stays.reserve') }}';
        var fields = {
            _token: _csrf,
            quote_id: _stcQuoteId,
            amount: _stcAmount,
            currency: _stcCurrency,
            payment_intent_id: paymentIntent.id,
            first_name: fn, last_name: ln, email: em, phone: ph,
            base_amount: _stcBaseAmount, tax_amount: _stcTaxAmount, fee_amount: _stcFeeAmount,
            due_at_property: _stcDueAtProp, room_name: _stcRoomName,
            free_cancel_until: _stcFreeCancel, non_refundable: _stcNonRefund ? '1' : '0',
            cancellation_timeline: JSON.stringify(_stcCancelTimeline),
            check_in_time: _stcCheckInTime, check_out_time: _stcCheckOutTime,
        };
        for (var k in fields) {
            var input = document.createElement('input');
            input.type = 'hidden'; input.name = k; input.value = fields[k];
            form.appendChild(input);
        }
        document.body.appendChild(form);
        form.submit();
    } catch(e) {
        console.error('Stays checkout failed:', e);
        var msg = stcErrText(e && e.message ? e.message : e);
        if (msg !== document.getElementById('stc-card-err').textContent) {
            stcSetMsg('<i class="fas fa-exclamation-triangle me-2"></i>' + msg);
        }
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-lock me-2"></i>Retry Payment';
    }
}
</script>
@endpush

</x-app-layout>

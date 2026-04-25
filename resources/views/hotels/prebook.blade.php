<x-app-layout>
@push('css')
<style>
.ht-prebook-header { background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%); padding:28px 0; }
.ht-prebook-header h2 { color:#C9A84C; font-weight:900; font-size:1.4rem; margin:0; }
.ht-prebook-body { background:#f7f8fc; padding:40px 0 60px; }
.ht-prebook-card { background:#fff; border-radius:14px; box-shadow:0 4px 20px rgba(0,0,0,0.08); padding:28px; max-width:640px; margin:0 auto; }
.ht-prebook-card h4 { font-size:18px; font-weight:800; color:#070D1A; margin-bottom:16px; }
.ht-detail-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f0f0f0; font-size:14px; }
.ht-detail-row:last-child { border-bottom:none; }
.ht-detail-label { color:#888; }
.ht-detail-val { font-weight:700; color:#070D1A; }
.ht-total-row { display:flex; justify-content:space-between; padding:14px 0 0; font-size:18px; font-weight:900; }
.ht-total-row .ht-detail-val { color:#C9A84C; }
.ht-confirm-btn { display:block; width:100%; margin-top:20px; background:linear-gradient(135deg,#C9A84C,#e8c96a); color:#070D1A; border:none; border-radius:10px; padding:14px; text-align:center; font-size:15px; font-weight:800; cursor:pointer; }
.ht-confirm-btn:hover { filter:brightness(1.08); }
.ht-back-btn { color:#C9A84C; text-decoration:none; font-size:13px; font-weight:600; }
</style>
@endpush

<div class="ht-prebook-header">
    <div class="container d-flex justify-content-between align-items-center">
        <h2><i class="fas fa-clipboard-check me-2"></i>Review Your Booking</h2>
        <a href="{{ route('hotels.index') }}" class="ht-back-btn"><i class="fas fa-arrow-left me-1"></i> Back</a>
    </div>
</div>

<div class="ht-prebook-body">
    <div class="container">
        @if(empty($prebook))
            <div class="text-center py-5 text-muted">
                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3 d-block"></i>
                <h5>Unable to retrieve booking details</h5>
                <p>The rate may have expired. Please search again.</p>
                <a href="{{ route('hotels.index') }}" class="btn btn-outline-secondary mt-2">New Search</a>
            </div>
        @else
        @php
            $hotel    = $prebook['hotel'] ?? [];
            $room     = $prebook['roomType'] ?? [];
            $rate     = $prebook['rate'] ?? $prebook;
            $total    = $rate['retailRate']['total'][0]['amount'] ?? ($rate['price'] ?? null);
            $currency = $rate['retailRate']['total'][0]['currency'] ?? 'USD';
            $checkin  = $prebook['checkin'] ?? '';
            $checkout = $prebook['checkout'] ?? '';
            $prebookId = $prebook['prebookId'] ?? '';
        @endphp
        <div class="ht-prebook-card">
            <h4>{{ $hotel['name'] ?? 'Hotel' }}</h4>
            <div class="ht-detail-row">
                <span class="ht-detail-label">Room</span>
                <span class="ht-detail-val">{{ $room['name'] ?? 'Standard Room' }}</span>
            </div>
            @if($checkin)
            <div class="ht-detail-row">
                <span class="ht-detail-label">Check-in</span>
                <span class="ht-detail-val">{{ $checkin }}</span>
            </div>
            @endif
            @if($checkout)
            <div class="ht-detail-row">
                <span class="ht-detail-label">Check-out</span>
                <span class="ht-detail-val">{{ $checkout }}</span>
            </div>
            @endif
            @if($total)
            <div class="ht-total-row">
                <span>Total</span>
                <span class="ht-detail-val">{{ $currency }} {{ number_format($total, 2) }}</span>
            </div>
            @endif

            @if($prebookId)
            <form method="POST" action="{{ route('hotels.search') }}">
                @csrf
                <input type="hidden" name="prebook_id" value="{{ $prebookId }}">
                <button type="submit" class="ht-confirm-btn">
                    <i class="fas fa-lock me-2"></i>Confirm & Pay
                </button>
            </form>
            @endif
        </div>
        @endif
    </div>
</div>

</x-app-layout>

<x-app-layout>
@push('css')
<style>
.ht-results-header { background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%); padding:28px 0; }
.ht-results-header h2 { color:#C9A84C; font-weight:900; font-size:1.4rem; margin:0; }
.ht-results-header p { color:rgba(255,255,255,0.7); font-size:13px; margin:4px 0 0; }
.ht-back-btn { color:#C9A84C; text-decoration:none; font-size:13px; font-weight:600; }
.ht-back-btn:hover { color:#e8c96a; }
.ht-results-body { background:#f7f8fc; padding:30px 0 60px; }
.ht-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }
.ht-card { background:#fff; border-radius:14px; box-shadow:0 3px 14px rgba(0,0,0,0.08); overflow:hidden; display:flex; flex-direction:column; transition:transform .2s,box-shadow .2s; }
.ht-card:hover { transform:translateY(-4px); box-shadow:0 10px 30px rgba(0,0,0,0.14); }
.ht-card-img { height:175px; object-fit:cover; width:100%; display:block; }
.ht-card-ph { height:175px; background:linear-gradient(135deg,#070D1A,#1a3a6b); display:flex; align-items:center; justify-content:center; font-size:3rem; color:#C9A84C; }
.ht-card-body { padding:14px 16px; flex:1; display:flex; flex-direction:column; }
.ht-card-name { font-size:15px; font-weight:800; color:#070D1A; margin-bottom:4px; line-height:1.3; }
.ht-card-loc { font-size:12px; color:#888; margin-bottom:8px; }
.ht-card-loc i { color:#C9A84C; }
.ht-card-stars { color:#C9A84C; font-size:12px; margin-bottom:8px; }
.ht-card-price { font-size:22px; font-weight:900; color:#070D1A; margin-bottom:12px; }
.ht-card-price span { font-size:11px; font-weight:400; color:#999; }
.ht-book-btn { display:block; margin-top:auto; background:#070D1A; color:#C9A84C; border-radius:9px; padding:9px; text-align:center; font-size:13px; font-weight:700; border:2px solid #C9A84C; cursor:pointer; text-decoration:none; transition:all .2s; }
.ht-book-btn:hover { background:#C9A84C; color:#070D1A; }
.ht-empty { text-align:center; padding:60px 20px; color:#888; }
.ht-empty i { font-size:3rem; color:#C9A84C; margin-bottom:16px; display:block; }
</style>
@endpush

<div class="ht-results-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-hotel me-2"></i>Hotels in {{ $search['city'] }}</h2>
            <p>{{ $search['check_in'] }} &rarr; {{ $search['check_out'] }} &bull; {{ $search['adults'] }} adult{{ $search['adults']>1?'s':'' }}</p>
        </div>
        <a href="{{ route('hotels.index') }}" class="ht-back-btn"><i class="fas fa-arrow-left me-1"></i> New Search</a>
    </div>
</div>

<div class="ht-results-body">
    <div class="container">
        @if(empty($hotels))
            <div class="ht-empty">
                <i class="fas fa-search"></i>
                <h4>No hotels found</h4>
                <p>Try a different city or date range.</p>
                <a href="{{ route('hotels.index') }}" class="btn btn-outline-secondary mt-2">Search Again</a>
            </div>
        @else
            <p class="text-muted mb-3" style="font-size:13px;">{{ count($hotels) }} propert{{ count($hotels)==1?'y':'ies' }} found</p>
            <div class="ht-grid">
                @foreach($hotels as $hotel)
                @php
                    $name     = $hotel['name'] ?? ($hotel['hotelName'] ?? 'Hotel');
                    $hotelId  = $hotel['hotelId'] ?? ($hotel['id'] ?? '');
                    $city     = $hotel['city'] ?? ($hotel['address']['city'] ?? '');
                    $country  = $hotel['country'] ?? ($hotel['address']['country'] ?? '');
                    $stars    = $hotel['starRating'] ?? ($hotel['stars'] ?? 0);
                    $img      = $hotel['thumbnail'] ?? ($hotel['image'] ?? null);
                    $minRate  = $hotel['minRate'] ?? null;
                    if (!$minRate && !empty($hotel['roomTypes'])) {
                        $minRate = collect($hotel['roomTypes'])->min('rates.0.retailRate.total.0.amount')
                                ?? collect($hotel['roomTypes'])->min('minRate');
                    }
                    $offerId  = $hotel['offerId'] ?? ($hotel['roomTypes'][0]['offerId'] ?? null);
                @endphp
                <div class="ht-card">
                    @if($img)
                        <img class="ht-card-img" src="{{ $img }}" alt="{{ $name }}" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                        <div class="ht-card-ph" style="display:none"><i class="fas fa-hotel"></i></div>
                    @else
                        <div class="ht-card-ph"><i class="fas fa-hotel"></i></div>
                    @endif
                    <div class="ht-card-body">
                        <div class="ht-card-name">{{ $name }}</div>
                        @if($city || $country)
                        <div class="ht-card-loc"><i class="fas fa-map-marker-alt me-1"></i>{{ implode(', ', array_filter([$city, $country])) }}</div>
                        @endif
                        @if($stars > 0)
                        <div class="ht-card-stars">
                            @for($s=1;$s<=$stars;$s++)<i class="fas fa-star"></i>@endfor
                        </div>
                        @endif
                        @if($minRate)
                        <div class="ht-card-price">${{ number_format($minRate, 0) }} <span>/ night</span></div>
                        @endif
                        <a href="{{ route('hotels.detail', $hotelId) }}?check_in={{ $search['check_in'] }}&check_out={{ $search['check_out'] }}&adults={{ $search['adults'] }}" class="ht-book-btn">View Hotel &amp; Rooms &rarr;</a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

</x-app-layout>

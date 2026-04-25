<x-app-layout>
@push('css')
<style>
:root { --nm-navy:#0a1628; --nm-gold:#c9a84c; }
.nm-hotels-hero {
    background: linear-gradient(160deg,rgba(10,22,40,0.85) 0%,rgba(10,22,40,0.65) 100%),
    url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1920&q=80') center/cover;
    padding:100px 0 50px; min-height:380px; display:flex; align-items:center;
}
.nm-hotel-search { background:rgba(255,255,255,0.97); border-radius:16px; padding:24px 28px; margin-top:24px; box-shadow:0 8px 40px rgba(0,0,0,0.25); }
.nm-hotel-search .form-control { height:46px; border:1.5px solid #dde2ec; border-radius:10px; font-size:14px; }
.nm-hotel-search label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#666; }
.nm-search-btn-gold { background:linear-gradient(135deg,#c9a84c,#e8c96a); color:#0a1628; border:none; height:46px; border-radius:10px; font-weight:800; font-size:15px; width:100%; }
.nm-hotels-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px; margin-top:24px; }
.nm-hotel-card { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,0.08); overflow:hidden; transition:transform .2s,box-shadow .2s; display:flex; flex-direction:column; }
.nm-hotel-card:hover { transform:translateY(-4px); box-shadow:0 10px 32px rgba(0,0,0,0.14); }
.nm-hotel-img { width:100%; height:200px; object-fit:cover; }
.nm-hotel-img-ph { width:100%; height:200px; background:linear-gradient(135deg,#0a1628,#1a3a6b); display:flex; align-items:center; justify-content:center; font-size:3rem; }
.nm-hotel-body { padding:16px; flex:1; display:flex; flex-direction:column; }
.nm-hotel-name { font-size:17px; font-weight:800; color:#0a1628; margin-bottom:6px; }
.nm-hotel-location { font-size:12px; color:#888; margin-bottom:10px; }
.nm-hotel-location i { color:#c9a84c; }
.nm-hotel-stars { color:#c9a84c; font-size:13px; margin-bottom:8px; }
.nm-hotel-price { font-size:22px; font-weight:900; color:#0a1628; margin-top:auto; }
.nm-hotel-price span { font-size:11px; color:#999; font-weight:400; }
.nm-hotel-btn { display:block; margin-top:10px; background:#0a1628; color:#c9a84c; border-radius:9px; padding:10px 0; text-align:center; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s; border:2px solid #c9a84c; }
.nm-hotel-btn:hover { background:#c9a84c; color:#0a1628; }
</style>
@endpush

<div class="nm-hotels-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <p style="font-size:12px;letter-spacing:4px;text-transform:uppercase;color:#c9a84c;font-weight:700;">Best Stays</p>
                <h1 style="font-size:clamp(2rem,4vw,3.2rem);font-weight:900;color:#fff;margin-bottom:8px;">Find Your Perfect Hotel</h1>
                <p style="color:rgba(255,255,255,0.8);font-size:1.1rem;">Thousands of hotels powered by the Duffel Stays network</p>

                <div class="nm-hotel-search">
                    <form method="GET" action="{{ route('hotels.search') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label>Destination</label>
                                <input type="text" name="keyword" class="form-control" placeholder="City, airport or hotel" value="{{ $keyword }}">
                            </div>
                            <div class="col-md-2">
                                <label>Check-in</label>
                                <input type="date" name="checkin" class="form-control" value="{{ $checkin }}" min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-2">
                                <label>Check-out</label>
                                <input type="date" name="checkout" class="form-control" value="{{ $checkout }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                            <div class="col-md-1">
                                <label>Rooms</label>
                                <input type="number" name="rooms" class="form-control" value="{{ $rooms }}" min="1" max="9">
                            </div>
                            <div class="col-md-2">
                                <label>Adults</label>
                                <input type="number" name="adults" class="form-control" value="{{ $adults }}" min="1" max="9">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="nm-search-btn-gold"><i class="fas fa-search me-1"></i> Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    @if($error)
        <div class="alert alert-info d-flex align-items-center gap-3">
            <i class="fas fa-info-circle fa-2x" style="color:#c9a84c;"></i>
            <div>
                <strong>Note:</strong> {{ $error }}
                <div class="mt-2"><small>You can also <a href="{{ url('/hotels') }}" style="color:#c9a84c;">browse our curated hotel listings</a> or <a href="{{ url('/contact') }}" style="color:#c9a84c;">contact our team</a> for personalized hotel recommendations.</small></div>
            </div>
        </div>
    @endif

    @if(!empty($hotels))
        <h3 style="font-weight:800;color:#0a1628;margin-bottom:20px;">{{ count($hotels) }} Hotels Found</h3>
        <div class="nm-hotels-grid">
            @foreach($hotels as $hotel)
            @php
            $name      = $hotel['accommodation']['name'] ?? $hotel['name'] ?? 'Hotel';
            $address   = $hotel['accommodation']['location']['address'] ?? '';
            $city      = $hotel['accommodation']['location']['city_name'] ?? '';
            $stars     = $hotel['accommodation']['star_rating'] ?? 0;
            $imgUrl    = $hotel['accommodation']['photos'][0]['url'] ?? null;
            $amenities = $hotel['accommodation']['amenities'] ?? [];
            $rate      = $hotel['cheapest_rate_total_amount'] ?? ($hotel['total_amount'] ?? null);
            $currency  = $hotel['cheapest_rate_currency'] ?? 'USD';
            $hotelId   = $hotel['id'] ?? '';
            @endphp
            <div class="nm-hotel-card">
                @if($imgUrl)
                <img class="nm-hotel-img" src="{{ $imgUrl }}" alt="{{ $name }}" loading="lazy">
                @else
                <div class="nm-hotel-img-ph">🏨</div>
                @endif
                <div class="nm-hotel-body">
                    <h4 class="nm-hotel-name">{{ $name }}</h4>
                    @if($stars > 0)
                    <div class="nm-hotel-stars">
                        @for($s=1; $s<=$stars; $s++)<i class="fas fa-star"></i>@endfor
                        @for($s=$stars+1; $s<=5; $s++)<i class="far fa-star"></i>@endfor
                    </div>
                    @endif
                    @if($city || $address)
                    <div class="nm-hotel-location"><i class="fas fa-map-marker-alt me-1"></i>{{ $city }}{{ $city && $address ? ' · ' : '' }}{{ Str::limit($address, 40) }}</div>
                    @endif
                    @if($rate)
                    <div class="nm-hotel-price">${{ number_format((float)$rate, 0) }} <span>/ night · {{ $currency }}</span></div>
                    @endif
                    <a href="{{ url('/contact?hotel='.urlencode($name)) }}" class="nm-hotel-btn"><i class="fas fa-bed me-1"></i> Book Now</a>
                </div>
            </div>
            @endforeach
        </div>

    @elseif($keyword || $checkin)
        @if(!$error)
        <div class="alert alert-info text-center">
            <i class="fas fa-search fa-2x mb-3 d-block" style="color:#c9a84c;"></i>
            No hotels found for that search. Try a different city or adjust your dates.
        </div>
        @endif
    @endif

    {{-- Show curated hotels from DB --}}
    @if(empty($hotels))
    @php $dbHotels = App\Models\ModulesData::where('module_id', 1)->where('status','active')->limit(9)->get(); @endphp
    @if($dbHotels->count() > 0)
    <div class="mt-4">
        <h3 style="font-weight:800;color:#0a1628;margin-bottom:20px;">Featured Hotels</h3>
        <div class="nm-hotels-grid">
            @foreach($dbHotels as $hotel)
            <div class="nm-hotel-card">
                <img class="nm-hotel-img" src="{{ asset('images/' . $hotel->image) }}" alt="{{ $hotel->title }}">
                <div class="nm-hotel-body">
                    <h4 class="nm-hotel-name">{{ $hotel->title }}</h4>
                    @php $stars = (int)($hotel->extra_field_2 ?? 0); @endphp
                    @if($stars > 0)
                    <div class="nm-hotel-stars">@for($s=1;$s<=$stars;$s++)<i class="fas fa-star"></i>@endfor</div>
                    @endif
                    @if($hotel->extra_field_18)
                    <div class="nm-hotel-location"><i class="fas fa-map-marker-alt me-1"></i>{{ $hotel->extra_field_18 }}</div>
                    @endif
                    @if($hotel->extra_field_1)
                    <div class="nm-hotel-price">${{ $hotel->extra_field_1 }} <span>/ night</span></div>
                    @endif
                    <a href="{{ route('hotel.detail', $hotel->slug) }}" class="nm-hotel-btn"><i class="fas fa-bed me-1"></i> View Hotel</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @endif
</div>
</x-app-layout>
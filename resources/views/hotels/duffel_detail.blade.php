<x-app-layout>
@push('css')
<style>
.dd-header{background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%);padding:28px 0;}
.dd-header h2{color:#C9A84C;font-weight:900;font-size:1.5rem;margin:0;}
.dd-header p{color:rgba(255,255,255,0.7);font-size:13px;margin:4px 0 0;}
.dd-back{color:#C9A84C;text-decoration:none;font-size:13px;font-weight:600;}
.dd-body{background:#f7f8fc;padding:30px 0 60px;}
.dd-card{background:#fff;border-radius:14px;box-shadow:0 3px 14px rgba(0,0,0,0.08);overflow:hidden;}
.dd-photos{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:10px;padding:16px;}
.dd-photo{height:200px;object-fit:cover;width:100%;border-radius:10px;}
.dd-info{padding:24px;}
.dd-name{font-size:1.4rem;font-weight:900;color:#070D1A;}
.dd-stars{color:#C9A84C;margin:6px 0;}
.dd-loc{color:#888;font-size:14px;margin-bottom:12px;}
.dd-price-box{background:#f0f4ff;border-radius:12px;padding:16px 20px;margin:16px 0;display:flex;align-items:center;justify-content:space-between;}
.dd-price{font-size:2rem;font-weight:900;color:#070D1A;}
.dd-price span{font-size:13px;font-weight:400;color:#888;}
.dd-nights{font-size:13px;color:#666;}
.dd-book-btn{display:block;background:#070D1A;color:#C9A84C;border:2px solid #C9A84C;border-radius:10px;padding:14px;text-align:center;font-size:15px;font-weight:700;text-decoration:none;margin-top:20px;transition:all .2s;}
.dd-book-btn:hover{background:#C9A84C;color:#070D1A;}
.dd-amenities{margin-top:16px;}
.dd-amenity{display:inline-block;background:#f0f4ff;border-radius:20px;padding:4px 12px;font-size:12px;color:#555;margin:3px;}
.dd-score{background:#C9A84C;color:#070D1A;font-weight:900;border-radius:8px;padding:4px 10px;font-size:14px;margin-left:8px;}
</style>
@endpush

@php
$loc   = $acc['location'] ?? [];
$addr  = $loc['address'] ?? [];
$photos = array_slice($acc['photos'] ?? [], 0, 6);
$total = isset($r['cheapest_rate_public_amount']) ? (float)$r['cheapest_rate_public_amount'] : null;
$nights = max(1, \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)));
$perNight = $total ? round($total / $nights, 2) : null;
$stars = $acc['rating'] ?? 0;
$amenities = array_slice($acc['amenities'] ?? [], 0, 12);
$cityName = $addr['city_name'] ?? '';
$country  = $addr['country_code'] ?? '';
$line1    = $addr['line_one'] ?? '';
@endphp

<div class="dd-header">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <h2>{{ $acc['name'] ?? 'Hotel' }}
                @if($acc['review_score'] ?? null)
                    <span class="dd-score">{{ $acc['review_score'] }}</span>
                @endif
            </h2>
            <p>{{ $checkIn }} &rarr; {{ $checkOut }} &bull; {{ $adults }} adult{{ $adults > 1 ? 's' : '' }} &bull; {{ $nights }} night{{ $nights > 1 ? 's' : '' }}</p>
        </div>
        <a href="{{ route('hotels.index') }}" class="dd-back"><i class="fas fa-arrow-left me-1"></i> New Search</a>
    </div>
</div>

<div class="dd-body">
    <div class="container">
        <div class="dd-card">
            @if(!empty($photos))
            <div class="dd-photos">
                @foreach($photos as $photo)
                    <img class="dd-photo" src="{{ $photo['url'] }}" alt="{{ $acc['name'] ?? 'Hotel' }}" onerror="this.style.display='none'">
                @endforeach
            </div>
            @endif
            <div class="dd-info">
                <div class="dd-name">{{ $acc['name'] ?? 'Hotel' }}</div>
                @if($stars > 0)
                <div class="dd-stars">@for($s=1;$s<=$stars;$s++)<i class="fas fa-star"></i>@endfor</div>
                @endif
                @if($line1 || $cityName)
                <div class="dd-loc"><i class="fas fa-map-marker-alt me-1" style="color:#C9A84C;"></i>{{ implode(', ', array_filter([$line1, $cityName, $country])) }}</div>
                @endif

                @if($total)
                <div class="dd-price-box">
                    <div>
                        <div class="dd-price">${{ number_format($total, 0) }} <span>total</span></div>
                        @if($nights > 1 && $perNight)
                        <div class="dd-nights">${{ number_format($perNight, 0) }}/night &bull; {{ $nights }} nights</div>
                        @endif
                    </div>
                    <div style="color:#666;font-size:13px;">Taxes & fees may apply</div>
                </div>
                @endif

                @if($acc['description'] ?? null)
                <p style="color:#555;font-size:14px;line-height:1.6;margin-top:12px;">{{ $acc['description'] }}</p>
                @endif

                @if(!empty($amenities))
                <div class="dd-amenities">
                    <strong style="font-size:13px;display:block;margin-bottom:6px;">Amenities</strong>
                    @foreach($amenities as $a)
                        <span class="dd-amenity"><i class="fas fa-check me-1" style="color:#C9A84C;font-size:10px;"></i>{{ ucwords(strtolower(str_replace('_', ' ', is_array($a) ? ($a['type'] ?? '') : $a))) }}</span>
                    @endforeach
                </div>
                @endif

                <a href="mailto:reservations@nomalytravel.com?subject=Hotel Booking - {{ urlencode($acc['name'] ?? 'Hotel') }}&body=I would like to book {{ $acc['name'] ?? 'Hotel' }} from {{ $checkIn }} to {{ $checkOut }} for {{ $adults }} adult(s)." class="dd-book-btn">
                    <i class="fas fa-envelope me-2"></i>Request Booking
                </a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
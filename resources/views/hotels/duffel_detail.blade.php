<x-app-layout>
@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
:root { --navy:#070D1A; --navy2:#0E1D36; --gold:#C9A84C; --gold-lt:#e8c96a; }

/* ── Hero Gallery ── */
.htd-gallery { position:relative; height:420px; background:var(--navy); overflow:hidden; }
@media(max-width:768px){
  .htd-gallery { height:240px; }
  .htd-gallery-thumbs { display:none !important; }
  .htd-see-all { bottom:12px; right:12px; font-size:11px; padding:5px 11px; }
  .htd-gallery-count { top:10px; right:10px; font-size:11px; }
  .htd-bar-inner { flex-wrap:wrap; gap:6px; padding:8px 0; }
  .htd-bar-name { font-size:13px; }
  .htd-bar-price { font-size:16px; }
  .htd-bar-btn { font-size:12px; padding:7px 14px; }
  .htd-name { font-size:1.4rem; }
  .htd-body { padding:20px 0 40px; }
  .htd-main { padding:16px; border-radius:12px; }
  .htd-room .col-md-4 { width:100%; }
  .htd-room .col-md-8 { width:100%; }
  .htd-room-img { height:160px; width:100%; border-radius:0; }
  .htd-room-ph { height:120px; }
  .htd-rate-row { flex-direction:column; align-items:flex-start; gap:10px; }
  .htd-book-room-btn { width:100%; text-align:center; }
  .htd-amenities { grid-template-columns:repeat(2,1fr); }
  .col-lg-4 { display:none; }
}
.htd-gallery-main { width:100%; height:100%; object-fit:cover; display:block; }
.htd-gallery-overlay { position:absolute; inset:0; background:linear-gradient(to bottom, transparent 50%, rgba(7,13,26,.75) 100%); }
.htd-gallery-thumbs { position:absolute; bottom:16px; left:50%; transform:translateX(-50%); display:flex; gap:8px; z-index:5; }
.htd-gallery-thumbs img { width:64px; height:48px; object-fit:cover; border-radius:6px; border:2px solid transparent; cursor:pointer; opacity:.7; transition:all .2s; }
.htd-gallery-thumbs img.active, .htd-gallery-thumbs img:hover { border-color:var(--gold); opacity:1; }
.htd-gallery-count { position:absolute; top:16px; right:16px; background:rgba(0,0,0,.55); color:#fff; font-size:12px; font-weight:700; padding:4px 10px; border-radius:20px; z-index:5; }
.htd-see-all { position:absolute; bottom:16px; right:16px; background:rgba(255,255,255,.92); color:var(--navy); font-size:12px; font-weight:700; padding:6px 14px; border-radius:8px; cursor:pointer; z-index:5; border:none; }

/* ── Sticky header bar ── */
.htd-bar { background:#fff; border-bottom:1px solid #e8edf5; position:sticky; top:0; z-index:100; box-shadow:0 2px 12px rgba(0,0,0,.07); }
.htd-bar-inner { display:flex; align-items:center; justify-content:space-between; padding:12px 0; }
.htd-bar-name { font-size:15px; font-weight:800; color:var(--navy); }
.htd-bar-price { font-size:20px; font-weight:900; color:var(--gold); }
.htd-bar-btn { background:linear-gradient(135deg,var(--gold),var(--gold-lt)); color:var(--navy); border:none; border-radius:9px; padding:9px 22px; font-size:13px; font-weight:800; cursor:pointer; text-decoration:none; display:inline-block; }
.htd-bar-btn:hover { filter:brightness(1.07); color:var(--navy); }

/* ── Body layout ── */
.htd-body { background:#f7f8fc; padding:36px 0 60px; }
.htd-main { background:#fff; border-radius:16px; padding:28px 32px; box-shadow:0 3px 16px rgba(0,0,0,.07); margin-bottom:24px; }
@media(max-width:768px){ .htd-main { padding:20px 18px; } }

/* ── Hotel name / stars ── */
.htd-name { font-family:'Cormorant Garamond',Georgia,serif; font-size:2rem; font-weight:600; color:var(--navy); margin-bottom:6px; line-height:1.2; }
.htd-stars { color:var(--gold); font-size:14px; margin-bottom:10px; }
.htd-loc { font-size:13px; color:#777; margin-bottom:16px; }
.htd-loc i { color:var(--gold); }
.htd-badges { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:18px; }
.htd-badge { background:#f0f4ff; color:#1a3a6b; font-size:11px; font-weight:700; padding:4px 12px; border-radius:20px; border:1px solid #d0dbf5; }
.htd-score { background:var(--gold); color:var(--navy); font-weight:900; border-radius:8px; padding:3px 10px; font-size:14px; margin-left:10px; vertical-align:middle; }

/* ── Description ── */
.htd-desc { font-size:14px; color:#555; line-height:1.75; }
.htd-desc.collapsed { display:-webkit-box; -webkit-line-clamp:4; -webkit-box-orient:vertical; overflow:hidden; }
.htd-read-more { color:var(--gold); font-size:13px; font-weight:700; cursor:pointer; background:none; border:none; padding:0; margin-top:8px; }

/* ── Section titles ── */
.htd-section-title { font-size:16px; font-weight:800; color:var(--navy); margin-bottom:18px; padding-bottom:10px; border-bottom:2px solid #f0f0f0; display:flex; align-items:center; gap:8px; }
.htd-section-title i { color:var(--gold); }

/* ── Amenities ── */
.htd-amenities { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:10px; }
.htd-amenity { display:flex; align-items:center; gap:8px; font-size:13px; color:#444; padding:8px 12px; background:#f8f9fc; border-radius:9px; }
.htd-amenity i { color:var(--gold); width:16px; text-align:center; flex-shrink:0; }

/* ── Rooms ── */
.htd-room { border:1.5px solid #e8edf5; border-radius:14px; overflow:hidden; margin-bottom:16px; background:#fff; }
.htd-room-img { width:100%; height:100%; min-height:190px; object-fit:cover; display:block; }
.htd-room-ph { height:190px; background:linear-gradient(135deg,#f0f4ff,#dce8ff); display:flex; align-items:center; justify-content:center; font-size:2.5rem; color:#b0bcd8; }
.htd-room-body { padding:18px 20px; }
.htd-room-name { font-size:15px; font-weight:800; color:var(--navy); margin-bottom:6px; }
.htd-room-features { display:flex; flex-wrap:wrap; gap:6px; margin-bottom:12px; }
.htd-room-feat { font-size:11px; background:#f0f4ff; color:#1a3a6b; padding:3px 10px; border-radius:20px; font-weight:600; }
.htd-rate { border-top:1px solid #f0f2f7; padding:12px 0 4px; margin-top:8px; }
.htd-rate:first-of-type { border-top:none; margin-top:0; padding-top:4px; }
.htd-rate-row { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.htd-room-price { font-size:24px; font-weight:900; color:var(--navy); }
.htd-room-price sup { font-size:14px; }
.htd-room-price small { font-size:12px; font-weight:400; color:#999; }
.htd-book-room-btn { background:linear-gradient(135deg,var(--gold),var(--gold-lt)); color:var(--navy); border:none; border-radius:9px; padding:10px 24px; font-size:13px; font-weight:800; cursor:pointer; text-decoration:none; display:inline-block; }
.htd-book-room-btn:hover { filter:brightness(1.07); color:var(--navy); }
.htd-rate-conditions { margin-top:8px; font-size:12px; color:#777; }
.htd-rate-conditions summary { cursor:pointer; color:var(--gold); font-weight:700; font-size:12px; list-style:none; }
.htd-rate-conditions summary::-webkit-details-marker { display:none; }
.htd-rate-conditions p { margin:8px 0 0; line-height:1.6; }
.htd-rate-conditions strong { color:#555; }

/* ── Policies ── */
.htd-policy-row { display:flex; gap:12px; padding:12px 0; border-bottom:1px solid #f0f0f0; font-size:13px; }
.htd-policy-row:last-child { border-bottom:none; }
.htd-policy-icon { width:32px; height:32px; border-radius:8px; background:#fef9e7; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--gold); }
.htd-policy-label { font-weight:700; color:var(--navy); margin-bottom:2px; }
.htd-policy-val { color:#666; }

/* ── Sidebar ── */
.htd-sidebar-card { background:#fff; border-radius:14px; padding:22px; box-shadow:0 3px 16px rgba(0,0,0,.07); }
.htd-sidebar-price { font-size:28px; font-weight:900; color:var(--navy); }
.htd-sidebar-price sup { font-size:16px; }
.htd-sidebar-price small { font-size:13px; font-weight:400; color:#999; }
.htd-sidebar-cta { display:block; width:100%; margin-top:14px; background:linear-gradient(135deg,var(--gold),var(--gold-lt)); color:var(--navy); border:none; border-radius:10px; padding:13px; text-align:center; font-size:15px; font-weight:800; cursor:pointer; text-decoration:none; }
.htd-sidebar-cta:hover { filter:brightness(1.07); color:var(--navy); }
.htd-sidebar-divider { border-top:1px solid #f0f0f0; margin:14px 0; }
.htd-sidebar-row { display:flex; justify-content:space-between; font-size:13px; margin-bottom:8px; }
.htd-sidebar-row .label { color:#888; }
.htd-sidebar-row .val { font-weight:700; color:var(--navy); }

/* ── Lightbox ── */
.htd-lightbox { display:none; position:fixed; inset:0; background:rgba(0,0,0,.92); z-index:9999; align-items:center; justify-content:center; }
.htd-lightbox.open { display:flex; }
.htd-lightbox img { max-width:90vw; max-height:85vh; border-radius:10px; object-fit:contain; }
.htd-lightbox-close { position:absolute; top:20px; right:24px; color:#fff; font-size:28px; cursor:pointer; background:none; border:none; line-height:1; }
.htd-lightbox-nav { position:absolute; top:50%; transform:translateY(-50%); background:rgba(255,255,255,.15); border:none; color:#fff; font-size:22px; width:46px; height:46px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; }
.htd-lightbox-nav.prev { left:20px; }
.htd-lightbox-nav.next { right:20px; }
.htd-lightbox-nav:hover { background:rgba(255,255,255,.3); }

/* ── Back link ── */
.htd-back { color:var(--gold); font-size:13px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:20px; }
.htd-back:hover { color:var(--gold-lt); }
</style>
@endpush

@php
    $loc      = $acc['location'] ?? [];
    $addr     = $loc['address'] ?? [];
    $coords   = $loc['geographic_coordinates'] ?? [];
    $lat      = $coords['latitude'] ?? null;
    $lng      = $coords['longitude'] ?? null;
    $name     = $acc['name'] ?? 'Hotel';
    $stars    = (int) ($acc['rating'] ?? 0);
    $score    = $acc['review_score'] ?? null;
    $desc     = $acc['description'] ?? '';
    $phone    = $acc['phone_number'] ?? '';
    $city     = $addr['city_name'] ?? '';
    $country  = $addr['country_code'] ?? '';
    $line1    = $addr['line_one'] ?? '';
    $checkInTime  = $acc['check_in_information']['check_in_after_time'] ?? '3:00 PM';
    $checkOutTime = $acc['check_in_information']['check_out_before_time'] ?? '12:00 PM';
    $keyInfo  = $acc['key_collection']['instructions'] ?? null;

    $images = [];
    foreach ($acc['photos'] ?? [] as $photo) {
        if (!empty($photo['url'])) $images[] = $photo['url'];
    }
    $mainImg = $images[0] ?? null;

    $amenities = $acc['amenities'] ?? [];

    $nights = max(1, (int)((strtotime($checkOut) - strtotime($checkIn)) / 86400));

    // Sort rooms by cheapest rate, cap rates shown per room
    $roomList = $rooms ?? [];
    $rateTotal = fn($room) => collect($room['rates'] ?? [])->min(fn($rt) => (float)($rt['total_amount'] ?? PHP_INT_MAX)) ?? PHP_INT_MAX;
    usort($roomList, fn($a, $b) => $rateTotal($a) <=> $rateTotal($b));

    // Cheapest total across every rate, falling back to the search summary
    $minTotal = null;
    foreach ($roomList as $room) {
        foreach ($room['rates'] ?? [] as $rt) {
            $t = (float)($rt['total_amount'] ?? 0);
            if ($t > 0 && ($minTotal === null || $t < $minTotal)) $minTotal = $t;
        }
    }
    if ($minTotal === null && isset($r['cheapest_rate_public_amount'])) {
        $minTotal = (float)$r['cheapest_rate_public_amount'];
    }
    $minPerNight = $minTotal ? round($minTotal / $nights, 2) : null;

    $amenityIcons = [
        'wifi' => 'fa-wifi', 'internet' => 'fa-wifi', 'pool' => 'fa-swimming-pool',
        'gym' => 'fa-dumbbell', 'fitness' => 'fa-dumbbell', 'spa' => 'fa-spa',
        'parking' => 'fa-parking', 'restaurant' => 'fa-utensils', 'bar' => 'fa-cocktail',
        'lounge' => 'fa-couch', 'air' => 'fa-wind', 'conditioning' => 'fa-wind',
        'laundry' => 'fa-tshirt', 'concierge' => 'fa-bell', 'breakfast' => 'fa-coffee',
        'room service' => 'fa-bell', 'room_service' => 'fa-bell', 'elevator' => 'fa-building',
        'lift' => 'fa-building', 'airport' => 'fa-plane', 'shuttle' => 'fa-shuttle-van',
        'pets' => 'fa-paw', 'pet' => 'fa-paw', 'beach' => 'fa-umbrella-beach',
        'jacuzzi' => 'fa-hot-tub', 'hot tub' => 'fa-hot-tub', 'safe' => 'fa-lock',
        'business' => 'fa-briefcase', 'meeting' => 'fa-briefcase', 'accessib' => 'fa-wheelchair',
        '24_hour' => 'fa-concierge-bell', 'front desk' => 'fa-concierge-bell',
    ];
@endphp

{{-- ── Lightbox ── --}}
<div class="htd-lightbox" id="htd-lightbox">
    <button class="htd-lightbox-close" onclick="htdLbClose()">&times;</button>
    <button class="htd-lightbox-nav prev" onclick="htdLbNav(-1)"><i class="fas fa-chevron-left"></i></button>
    <img id="htd-lb-img" src="" alt="">
    <button class="htd-lightbox-nav next" onclick="htdLbNav(1)"><i class="fas fa-chevron-right"></i></button>
</div>

{{-- ── Gallery ── --}}
<div class="htd-gallery">
    @if($mainImg)
        <img class="htd-gallery-main" id="htd-main-img" src="{{ $mainImg }}" alt="{{ $name }}">
    @else
        <div style="width:100%;height:100%;background:linear-gradient(135deg,#070D1A,#1a3a6b);display:flex;align-items:center;justify-content:center;font-size:5rem;color:#C9A84C;">
            <i class="fas fa-hotel"></i>
        </div>
    @endif
    <div class="htd-gallery-overlay"></div>

    @if(count($images) > 1)
        <div class="htd-gallery-count"><i class="fas fa-images me-1"></i>{{ count($images) }} photos</div>
        <button class="htd-see-all" onclick="htdLbOpen(0)"><i class="fas fa-expand-alt me-1"></i> See all photos</button>
        <div class="htd-gallery-thumbs" id="htd-thumbs">
            @foreach(array_slice($images, 0, 5) as $i => $img)
                <img src="{{ $img }}" alt="" class="{{ $i===0?'active':'' }}" onclick="htdSetMain('{{ $img }}',{{ $i }},this)">
            @endforeach
        </div>
    @endif
</div>

{{-- ── Sticky bar ── --}}
<div class="htd-bar">
    <div class="container htd-bar-inner">
        <div>
            <div class="htd-bar-name">{{ $name }}</div>
            @if($city) <div style="font-size:12px;color:#888;"><i class="fas fa-map-marker-alt" style="color:#C9A84C;"></i> {{ $city }}{{ $country ? ', '.$country : '' }}</div> @endif
        </div>
        <div class="d-flex align-items-center gap-3">
            @if($minPerNight)
                <div class="htd-bar-price">${{ number_format($minPerNight,0) }}<small style="font-size:12px;font-weight:400;color:#999;"> /night</small></div>
            @endif
            <a href="#htd-rooms" class="htd-bar-btn"><i class="fas fa-bed me-1"></i> Choose Room</a>
        </div>
    </div>
</div>

{{-- ── Body ── --}}
<div class="htd-body">
    <div class="container">
        <a href="javascript:history.back()" class="htd-back"><i class="fas fa-arrow-left"></i> Back to results</a>

        <div class="row g-4">
            {{-- ── LEFT COLUMN ── --}}
            <div class="col-lg-8">

                {{-- Info card --}}
                <div class="htd-main">
                    <h1 class="htd-name">{{ $name }}
                        @if($score)<span class="htd-score">{{ $score }}</span>@endif
                    </h1>
                    @if($stars > 0)
                    <div class="htd-stars">
                        @for($s=1;$s<=$stars;$s++)<i class="fas fa-star"></i>@endfor
                        <span style="font-size:12px;color:#999;margin-left:6px;">{{ $stars }}-Star Hotel</span>
                    </div>
                    @endif
                    @if($line1 || $city)
                    <div class="htd-loc"><i class="fas fa-map-marker-alt me-1"></i>{{ implode(', ', array_filter([$line1, $city, $country])) }}</div>
                    @endif

                    <div class="htd-badges">
                        <span class="htd-badge"><i class="fas fa-bolt me-1"></i> Instant Confirmation</span>
                        <span class="htd-badge"><i class="fas fa-shield-alt me-1"></i> Secure Booking</span>
                        @if($acc['review_count'] ?? null)
                        <span class="htd-badge"><i class="fas fa-comment me-1"></i> {{ number_format($acc['review_count']) }} Reviews</span>
                        @endif
                    </div>

                    @if($desc)
                    <p class="htd-desc collapsed" id="htd-desc">{{ strip_tags($desc) }}</p>
                    <button class="htd-read-more" onclick="htdExpandDesc(this)">Read more <i class="fas fa-chevron-down"></i></button>
                    @endif
                </div>

                {{-- Amenities --}}
                @if(!empty($amenities))
                <div class="htd-main">
                    <div class="htd-section-title"><i class="fas fa-concierge-bell"></i> Amenities & Facilities</div>
                    <div class="htd-amenities">
                        @foreach(array_slice($amenities, 0, 24) as $am)
                            @php
                                $amName = is_array($am) ? ($am['description'] ?? ucwords(str_replace('_',' ', $am['type'] ?? ''))) : $am;
                                $icon = 'fa-check-circle';
                                foreach($amenityIcons as $kw => $ic) {
                                    if(str_contains(strtolower($amName), $kw) || str_contains(strtolower(is_array($am) ? ($am['type'] ?? '') : ''), $kw)) { $icon = $ic; break; }
                                }
                            @endphp
                            @if($amName)
                            <div class="htd-amenity"><i class="fas {{ $icon }}"></i> {{ ucfirst($amName) }}</div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Rooms --}}
                <div class="htd-main" id="htd-rooms">
                    <div class="htd-section-title"><i class="fas fa-bed"></i> Available Rooms</div>
                    @if(empty($roomList))
                        <div style="text-align:center;padding:30px;color:#999;">
                            <i class="fas fa-calendar-times fa-2x" style="color:#C9A84C;margin-bottom:12px;display:block;"></i>
                            Live rates for this property have expired.
                            <a href="{{ route('hotels.index') }}" style="color:#C9A84C;font-weight:700;">Search again</a> to see current prices.
                        </div>
                    @else
                        @foreach($roomList as $room)
                        @php
                            $roomName = $room['name'] ?? 'Standard Room';
                            $roomImg  = $room['photos'][0]['url'] ?? (!empty($images) ? $images[$loop->index % count($images)] : null);
                            $bedsLine = collect($room['beds'] ?? [])
                                ->map(fn($b) => ($b['count'] ?? 1).' '.ucwords(str_replace('_',' ',$b['type'] ?? 'bed')).(($b['count'] ?? 1) > 1 ? ' beds' : ' bed'))
                                ->implode(' · ');
                            $rates = array_slice($room['rates'] ?? [], 0, 3);
                        @endphp
                        <div class="htd-room">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @if($roomImg)
                                        <img class="htd-room-img" src="{{ $roomImg }}" alt="{{ $roomName }}" onerror="this.parentNode.innerHTML='<div class=\'htd-room-ph\'><i class=\'fas fa-bed\'></i></div>'">
                                    @else
                                        <div class="htd-room-ph"><i class="fas fa-bed"></i></div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="htd-room-body">
                                        <div class="htd-room-name">{{ $roomName }}</div>
                                        @if($bedsLine)
                                        <div class="htd-room-features"><span class="htd-room-feat"><i class="fas fa-bed me-1"></i>{{ $bedsLine }}</span></div>
                                        @endif

                                        @foreach($rates as $rate)
                                        @php
                                            $total    = (float)($rate['total_amount'] ?? 0);
                                            $currency = $rate['total_currency'] ?? 'USD';
                                            $perNight = $total ? round($total / $nights, 2) : null;
                                            $dueAtProp = (float)($rate['due_at_accommodation_amount'] ?? 0);
                                            $board    = $rate['board_type'] ?? null;

                                            // Full refund available if any timeline entry refunds the full total
                                            $freeUntil = null;
                                            foreach ($rate['cancellation_timeline'] ?? [] as $ct) {
                                                if ((float)($ct['refund_amount'] ?? 0) >= $total - 0.01 && !empty($ct['before'])) {
                                                    $freeUntil = $ct['before'];
                                                }
                                            }
                                            $hasTimeline = !empty($rate['cancellation_timeline']);
                                        @endphp
                                        <div class="htd-rate">
                                            <div class="htd-room-features" style="margin-bottom:8px;">
                                                @if($board)<span class="htd-room-feat"><i class="fas fa-utensils me-1"></i>{{ ucwords(str_replace('_',' ',$board)) }}</span>@endif
                                                @if($freeUntil)
                                                    <span class="htd-room-feat" style="background:#eafaf1;color:#27ae60;"><i class="fas fa-check me-1"></i>Free cancellation before {{ date('M j, Y', strtotime($freeUntil)) }}</span>
                                                @elseif(!$hasTimeline)
                                                    <span class="htd-room-feat" style="background:#fef0f0;color:#e74c3c;"><i class="fas fa-times me-1"></i>Non-refundable</span>
                                                @else
                                                    <span class="htd-room-feat" style="background:#fef9e7;color:#b7791f;"><i class="fas fa-info-circle me-1"></i>Partial refund — see conditions</span>
                                                @endif
                                                @if(($rate['quantity_available'] ?? 99) <= 3)
                                                    <span class="htd-room-feat" style="background:#fef0f0;color:#e74c3c;">Only {{ $rate['quantity_available'] }} left</span>
                                                @endif
                                            </div>
                                            <div class="htd-rate-row">
                                                <div>
                                                    @if($total)
                                                    <div class="htd-room-price"><sup>$</sup>{{ number_format($perNight,0) }} <small>/night</small></div>
                                                    <div style="font-size:12px;color:#888;">{{ $currency }} {{ number_format($total,2) }} total for {{ $nights }} night{{ $nights>1?'s':'' }} · taxes &amp; fees included</div>
                                                    @if($dueAtProp > 0)
                                                    <div style="font-size:11px;color:#b7791f;">+ {{ $currency }} {{ number_format($dueAtProp,2) }} due at property</div>
                                                    @endif
                                                    @endif
                                                </div>
                                                <form method="POST" action="{{ route('stays.quote') }}" style="margin:0;">
                                                    @csrf
                                                    <input type="hidden" name="rate_id" value="{{ $rate['id'] }}">
                                                    <input type="hidden" name="room_name" value="{{ $roomName }}">
                                                    <input type="hidden" name="free_cancel_until" value="{{ $freeUntil ?? '' }}">
                                                    <input type="hidden" name="non_refundable" value="{{ $hasTimeline ? '0' : '1' }}">
                                                    <input type="hidden" name="cancellation_timeline" value="{{ json_encode($rate['cancellation_timeline'] ?? []) }}">
                                                    <button type="submit" class="htd-book-room-btn"><i class="fas fa-lock me-1"></i> Book This Rate</button>
                                                </form>
                                            </div>
                                            @if(!empty($rate['conditions']) || !empty($rate['cancellation_timeline']))
                                            <details class="htd-rate-conditions">
                                                <summary>Cancellation policy &amp; conditions <i class="fas fa-chevron-down" style="font-size:10px;"></i></summary>
                                                @foreach($rate['cancellation_timeline'] ?? [] as $ct)
                                                    <p><strong>Cancel before {{ date('M j, Y g:i A', strtotime($ct['before'] ?? '')) }}:</strong> refund of {{ $ct['currency'] ?? $currency }} {{ number_format((float)($ct['refund_amount'] ?? 0), 2) }}</p>
                                                @endforeach
                                                @if(empty($rate['cancellation_timeline']))
                                                    <p><strong>Non-refundable:</strong> this rate cannot be cancelled or refunded.</p>
                                                @endif
                                                @foreach(array_slice($rate['conditions'] ?? [], 0, 6) as $cond)
                                                    <p><strong>{{ $cond['title'] ?? 'Condition' }}:</strong> {{ $cond['description'] ?? '' }}</p>
                                                @endforeach
                                            </details>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                {{-- Policies --}}
                <div class="htd-main">
                    <div class="htd-section-title"><i class="fas fa-clipboard-list"></i> Hotel Policies</div>
                    <div class="htd-policy-row">
                        <div class="htd-policy-icon"><i class="fas fa-sign-in-alt"></i></div>
                        <div><div class="htd-policy-label">Check-in</div><div class="htd-policy-val">From {{ $checkInTime }}</div></div>
                    </div>
                    <div class="htd-policy-row">
                        <div class="htd-policy-icon"><i class="fas fa-sign-out-alt"></i></div>
                        <div><div class="htd-policy-label">Check-out</div><div class="htd-policy-val">Until {{ $checkOutTime }}</div></div>
                    </div>
                    <div class="htd-policy-row">
                        <div class="htd-policy-icon"><i class="fas fa-user-friends"></i></div>
                        <div><div class="htd-policy-label">Guests</div><div class="htd-policy-val">{{ $adults }} adult{{ $adults>1?'s':'' }}</div></div>
                    </div>
                    <div class="htd-policy-row">
                        <div class="htd-policy-icon"><i class="fas fa-key"></i></div>
                        <div><div class="htd-policy-label">Key Collection</div><div class="htd-policy-val">{{ $keyInfo ?: 'Key collection details will be confirmed in your booking confirmation email.' }}</div></div>
                    </div>
                    @if($phone)
                    <div class="htd-policy-row">
                        <div class="htd-policy-icon"><i class="fas fa-phone"></i></div>
                        <div><div class="htd-policy-label">Phone</div><div class="htd-policy-val">{{ $phone }}</div></div>
                    </div>
                    @endif
                </div>

                {{-- Map --}}
                @if($lat && $lng)
                <div class="htd-main" style="padding:0;overflow:hidden;">
                    <div class="htd-section-title" style="margin:20px 24px 14px;"><i class="fas fa-map-marked-alt"></i> Location</div>
                    <iframe
                        src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=15&output=embed"
                        width="100%" height="320" style="border:0;display:block;" loading="lazy">
                    </iframe>
                </div>
                @endif

                {{-- Business details — required by Duffel go-live --}}
                <div class="htd-main" style="font-size:12px;color:#999;">
                    <p class="mb-1" style="font-weight:700;color:#666;">Booking provided by Nomaly Travel</p>
                    <p class="mb-0">
                        Support: contact@nomalytravel.com · By completing a booking you agree to our
                        <a href="/terms" target="_blank" style="color:#C9A84C;">Terms &amp; Conditions</a>
                        and the rate conditions shown above.
                    </p>
                </div>

            </div>{{-- /col-lg-8 --}}

            {{-- ── RIGHT SIDEBAR ── --}}
            <div class="col-lg-4">
                <div class="htd-sidebar-card" style="position:sticky;top:72px;">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#aaa;margin-bottom:6px;">Starting from</div>
                    @if($minPerNight)
                    <div class="htd-sidebar-price"><sup>$</sup>{{ number_format($minPerNight,0) }} <small>/night</small></div>
                    <div style="font-size:12px;color:#999;">${{ number_format($minTotal,0) }} total · {{ $nights }} night{{ $nights>1?'s':'' }}</div>
                    @else
                    <div class="htd-sidebar-price" style="font-size:16px;color:#999;">Check availability</div>
                    @endif
                    <div class="htd-sidebar-divider"></div>
                    <div class="htd-sidebar-row"><span class="label"><i class="fas fa-calendar-check me-1" style="color:#C9A84C;"></i>Check-in</span><span class="val">{{ date('M d, Y', strtotime($checkIn)) }} from {{ $checkInTime }}</span></div>
                    <div class="htd-sidebar-row"><span class="label"><i class="fas fa-calendar-times me-1" style="color:#C9A84C;"></i>Check-out</span><span class="val">{{ date('M d, Y', strtotime($checkOut)) }} by {{ $checkOutTime }}</span></div>
                    <div class="htd-sidebar-row"><span class="label"><i class="fas fa-moon me-1" style="color:#C9A84C;"></i>Nights</span><span class="val">{{ $nights }}</span></div>
                    <div class="htd-sidebar-row"><span class="label"><i class="fas fa-users me-1" style="color:#C9A84C;"></i>Guests</span><span class="val">{{ $adults }} adult{{ $adults>1?'s':'' }}</span></div>
                    <a href="#htd-rooms" class="htd-sidebar-cta"><i class="fas fa-bed me-2"></i>View Available Rooms</a>
                    <div class="htd-sidebar-divider"></div>
                    <div style="font-size:11px;color:#999;text-align:center;"><i class="fas fa-shield-alt" style="color:#C9A84C;"></i> Secure booking · No hidden fees</div>
                </div>
            </div>

        </div>{{-- /row --}}
    </div>{{-- /container --}}
</div>{{-- /htd-body --}}

@push('scripts')
<script>
var htdImages = {!! json_encode(array_values(array_filter($images))) !!};
var htdLbIdx  = 0;

function htdSetMain(src, idx, el) {
    document.getElementById('htd-main-img').src = src;
    document.querySelectorAll('.htd-gallery-thumbs img').forEach(function(t){ t.classList.remove('active'); });
    el.classList.add('active');
}

function htdLbOpen(idx) {
    htdLbIdx = idx;
    document.getElementById('htd-lb-img').src = htdImages[idx];
    document.getElementById('htd-lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function htdLbClose() {
    document.getElementById('htd-lightbox').classList.remove('open');
    document.body.style.overflow = '';
}

function htdLbNav(dir) {
    htdLbIdx = (htdLbIdx + dir + htdImages.length) % htdImages.length;
    document.getElementById('htd-lb-img').src = htdImages[htdLbIdx];
}

document.getElementById('htd-lightbox').addEventListener('click', function(e){
    if(e.target === this) htdLbClose();
});

document.addEventListener('keydown', function(e){
    if(!document.getElementById('htd-lightbox').classList.contains('open')) return;
    if(e.key==='ArrowRight') htdLbNav(1);
    if(e.key==='ArrowLeft')  htdLbNav(-1);
    if(e.key==='Escape')     htdLbClose();
});

function htdExpandDesc(btn) {
    document.getElementById('htd-desc').classList.remove('collapsed');
    btn.style.display = 'none';
}
</script>
@endpush

</x-app-layout>

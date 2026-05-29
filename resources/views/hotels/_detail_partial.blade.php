
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
:root { --navy:#070D1A; --navy2:#0E1D36; --gold:#C9A84C; --gold-lt:#e8c96a; }

/* ── Hero Gallery ── */
.htd-gallery { position:relative; height:420px; background:var(--navy); overflow:hidden; }
@media(max-width:768px){
  /* Gallery */
  .htd-gallery { height:240px; }
  .htd-gallery-thumbs { display:none !important; }
  .htd-see-all { bottom:12px; right:12px; font-size:11px; padding:5px 11px; }
  .htd-gallery-count { top:10px; right:10px; font-size:11px; }

  /* Sticky bar */
  .htd-bar-inner { flex-wrap:wrap; gap:6px; padding-top:8px; padding-bottom:8px; }
  .htd-bar-name { font-size:13px; }
  .htd-bar-price { font-size:16px; }
  .htd-bar-btn { font-size:12px; padding:7px 14px; }

  /* Hotel name */
  .htd-name { font-size:1.4rem; }

  /* Body */
  .htd-body { padding:20px 0 40px; }
  .htd-main { padding:16px; border-radius:12px; }

  /* Rooms — stack image above content on mobile */
  .htd-room .col-md-4 { width:100%; }
  .htd-room .col-md-8 { width:100%; }
  .htd-room-img { height:160px; width:100%; border-radius:0; }
  .htd-room-ph { height:120px; }
  .htd-room-price-row { flex-direction:row; justify-content:space-between; align-items:center; gap:10px; }
  .htd-room-price { text-align:left; }
  .htd-book-room-btn { width:auto; white-space:nowrap; flex-shrink:0; }

  /* Amenities */
  .htd-amenities { grid-template-columns:repeat(2,1fr); }

  /* Sidebar hides on mobile — info is in sticky bar */
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
.htd-bar-inner { display:flex; align-items:center; justify-content:space-between; padding-top:12px; padding-bottom:12px; }
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
.htd-room-img { width:100%; height:190px; object-fit:cover; display:block; }
.htd-room-ph { height:190px; background:linear-gradient(135deg,#f0f4ff,#dce8ff); display:flex; align-items:center; justify-content:center; font-size:2.5rem; color:#b0bcd8; }
.htd-room-body { padding:18px 20px; }
.htd-room-name { font-size:15px; font-weight:800; color:var(--navy); margin-bottom:6px; }
.htd-room-features { display:flex; flex-wrap:wrap; gap:6px; margin-bottom:12px; }
.htd-room-feat { font-size:11px; background:#f0f4ff; color:#1a3a6b; padding:3px 10px; border-radius:20px; font-weight:600; }
.htd-room-price-row { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.htd-room-price { font-size:24px; font-weight:900; color:var(--navy); }
.htd-room-price sup { font-size:14px; }
.htd-room-price small { font-size:12px; font-weight:400; color:#999; }
.htd-room-refund { font-size:11px; color:#27ae60; font-weight:700; display:flex; align-items:center; gap:4px; }
.htd-room-refund.non { color:#e74c3c; }
.htd-book-room-btn { background:linear-gradient(135deg,var(--gold),var(--gold-lt)); color:var(--navy); border:none; border-radius:9px; padding:10px 24px; font-size:13px; font-weight:800; cursor:pointer; text-decoration:none; display:inline-block; }
.htd-book-room-btn:hover { filter:brightness(1.07); color:var(--navy); }

/* ── Policies ── */
.htd-policy-row { display:flex; gap:12px; padding:12px 0; border-bottom:1px solid #f0f0f0; font-size:13px; }
.htd-policy-row:last-child { border-bottom:none; }
.htd-policy-icon { width:32px; height:32px; border-radius:8px; background:#fef9e7; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:var(--gold); }
.htd-policy-label { font-weight:700; color:var(--navy); margin-bottom:2px; }
.htd-policy-val { color:#666; }

/* ── Sidebar ── */
.htd-sidebar-card { background:#fff; border-radius:14px; padding:22px; box-shadow:0 3px 16px rgba(0,0,0,.07);  }
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

/* ── Map placeholder ── */
.htd-map { border-radius:12px; overflow:hidden; height:220px; background:#e8edf5; display:flex; align-items:center; justify-content:center; color:#aaa; font-size:13px; flex-direction:column; gap:8px; }
.htd-map i { font-size:2rem; color:var(--gold); }

/* ── Back link ── */
.htd-back { color:var(--gold); font-size:13px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px; margin-bottom:20px; }
.htd-back:hover { color:var(--gold-lt); }
</style>


@php
    $name       = $hotel['name'] ?? 'Hotel';
    $stars      = $hotel['starRating'] ?? 0;
    $address    = $hotel['address'] ?? '';
    $city       = $hotel['city'] ?? '';
    $country    = $hotel['country'] ?? '';
    $desc       = $hotel['hotelDescription'] ?? '';
    $phone      = $hotel['phone'] ?? '';
    $lat        = $hotel['location']['latitude'] ?? null;
    $lng        = $hotel['location']['longitude'] ?? null;
    $checkInTime  = $hotel['checkinCheckoutTimes']['checkin_start'] ?? '3:00 PM';
    $checkOutTime = $hotel['checkinCheckoutTimes']['checkout'] ?? '12:00 PM';

    // Images — key is hotelImages with url/urlHd
    $images = [];
    if (!empty($hotel['hotelImages'])) {
        foreach ($hotel['hotelImages'] as $img) {
            $url = $img['urlHd'] ?? ($img['url'] ?? '');
            if ($url) $images[] = $url;
        }
    } elseif (!empty($hotel['main_photo'])) {
        $images[] = $hotel['main_photo'];
    }
    $mainImg = $images[0] ?? null;

    // Facilities
    $facilities = $hotel['facilities'] ?? [];

    // Policies (internet, pets, parking etc)
    $policies = $hotel['policies'] ?? [];

    // Deduplicate rooms by name, keep cheapest rate per unique room name — cap at 8
    $seenRoomNames = [];
    $dedupedRooms  = [];
    foreach ($rooms as $room) {
        $roomName = trim($room['name'] ?? ($room['roomType'] ?? 'Standard Room'));
        $price    = $room['rates'][0]['retailRate']['total'][0]['amount'] ?? PHP_INT_MAX;
        if (!isset($seenRoomNames[$roomName]) || $price < $seenRoomNames[$roomName]) {
            $seenRoomNames[$roomName] = $price;
            $dedupedRooms[$roomName]  = $room;
        }
    }
    $dedupedRooms = array_values($dedupedRooms);
    usort($dedupedRooms, fn($a,$b) =>
        ($a['rates'][0]['retailRate']['total'][0]['amount'] ?? 0) <=>
        ($b['rates'][0]['retailRate']['total'][0]['amount'] ?? 0)
    );
    $dedupedRooms = array_slice($dedupedRooms, 0, 8);

    // Min rate
    $minRate = null;
    foreach ($dedupedRooms as $room) {
        $rate = $room['rates'][0]['retailRate']['total'][0]['amount'] ?? null;
        if ($rate && ($minRate === null || $rate < $minRate)) $minRate = $rate;
    }

    $nights = (strtotime($checkOut) - strtotime($checkIn)) / 86400;
    $nights = max(1, (int)$nights);
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
            @if($minRate)
                <div class="htd-bar-price">${{ number_format($minRate,0) }}<small style="font-size:12px;font-weight:400;color:#999;"> /night</small></div>
            @endif
            <a href="#htd-rooms" class="htd-bar-btn"><i class="fas fa-bed me-1"></i> Choose Room</a>
        </div>
    </div>
</div>

{{-- ── Body ── --}}
<div class="htd-body">
    <div class="container">
        <button type="button" onclick="window._nmHotelBack&&window._nmHotelBack()" class="htd-back"><i class="fas fa-arrow-left"></i> Back to results</button>

        <div class="row g-4">
            {{-- ── LEFT COLUMN ── --}}
            <div class="col-lg-8">

                {{-- Info card --}}
                <div class="htd-main">
                    <h1 class="htd-name">{{ $name }}</h1>
                    @if($stars > 0)
                    <div class="htd-stars">
                        @for($s=1;$s<=$stars;$s++)<i class="fas fa-star"></i>@endfor
                        <span style="font-size:12px;color:#999;margin-left:6px;">{{ $stars }}-Star Hotel</span>
                    </div>
                    @endif
                    @if($address || $city)
                    <div class="htd-loc"><i class="fas fa-map-marker-alt me-1"></i>{{ implode(', ', array_filter([$address, $city, $country])) }}</div>
                    @endif

                    <div class="htd-badges">
                        <span class="htd-badge"><i class="fas fa-check me-1"></i> Free Cancellation Available</span>
                        <span class="htd-badge"><i class="fas fa-shield-alt me-1"></i> Secure Booking</span>
                        <span class="htd-badge"><i class="fas fa-bolt me-1"></i> Instant Confirmation</span>
                    </div>

                    @if($desc)
                    <p class="htd-desc collapsed" id="htd-desc">{{ strip_tags($desc) }}</p>
                    <button class="htd-read-more" onclick="htdExpandDesc(this)">Read more <i class="fas fa-chevron-down"></i></button>
                    @endif
                </div>

                {{-- Amenities --}}
                @if(!empty($facilities))
                <div class="htd-main">
                    <div class="htd-section-title"><i class="fas fa-concierge-bell"></i> Amenities & Facilities</div>
                    <div class="htd-amenities">
                        @php
                        $amenityIcons = [
                            'wifi' => 'fa-wifi', 'internet' => 'fa-wifi', 'pool' => 'fa-swimming-pool',
                            'gym' => 'fa-dumbbell', 'fitness' => 'fa-dumbbell', 'spa' => 'fa-spa',
                            'parking' => 'fa-parking', 'restaurant' => 'fa-utensils', 'bar' => 'fa-cocktail',
                            'air' => 'fa-wind', 'conditioning' => 'fa-wind', 'laundry' => 'fa-tshirt',
                            'concierge' => 'fa-bell', 'breakfast' => 'fa-coffee', 'room service' => 'fa-bell',
                            'elevator' => 'fa-building', 'lift' => 'fa-building', 'airport' => 'fa-plane',
                            'shuttle' => 'fa-shuttle-van', 'pets' => 'fa-paw', 'pet' => 'fa-paw',
                            'beach' => 'fa-umbrella-beach', 'jacuzzi' => 'fa-hot-tub', 'hot tub' => 'fa-hot-tub',
                            'safe' => 'fa-lock', 'business' => 'fa-briefcase', 'meeting' => 'fa-briefcase',
                        ];
                        @endphp
                        @foreach(array_slice($facilities, 0, 24) as $fac)
                            @php
                                $facName = is_array($fac) ? ($fac['name'] ?? ($fac['description'] ?? ($fac['code'] ?? ''))) : $fac;
                                $icon = 'fa-check-circle';
                                foreach($amenityIcons as $kw => $ic) {
                                    if(str_contains(strtolower($facName), $kw)) { $icon = $ic; break; }
                                }
                            @endphp
                            @if($facName)
                            <div class="htd-amenity"><i class="fas {{ $icon }}"></i> {{ ucfirst($facName) }}</div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Rooms --}}
                <div class="htd-main" id="htd-rooms">
                    <div class="htd-section-title"><i class="fas fa-bed"></i> Available Rooms</div>
                    @if(empty($dedupedRooms))
                        <div style="text-align:center;padding:30px;color:#999;">
                            <i class="fas fa-calendar-times fa-2x" style="color:#C9A84C;margin-bottom:12px;display:block;"></i>
                            No rates available for these dates. <a href="javascript:history.back()" style="color:#C9A84C;font-weight:700;">Try different dates</a>
                        </div>
                    @else
                        @foreach($dedupedRooms as $room)
                        @php
                            $roomName  = $room['name'] ?? ($room['roomType'] ?? 'Standard Room');
                            $rate      = $room['rates'][0] ?? null;
                            $price     = $rate['retailRate']['total'][0]['amount'] ?? null;
                            $currency  = $rate['retailRate']['total'][0]['currency'] ?? 'USD';
                            $offerId   = $rate['offerId'] ?? ($room['offerId'] ?? null);
                            $refund    = $rate['cancellationPolicies']['refundableTag'] ?? null;
                            $isRefund  = $refund && str_contains(strtolower($refund), 'refundable') && !str_contains(strtolower($refund), 'non');
                            $boardName = $rate['boardName'] ?? ($rate['boardCode'] ?? '');
                            // Match room photo from content API by name, fall back to hotel images
                            $roomImg = null;
                            $rKey = strtolower(trim($roomName));
                            if (isset($roomPhotoMap[$rKey])) {
                                $roomImg = $roomPhotoMap[$rKey][0];
                            } else {
                                // fuzzy match — find content room whose name contains rate room name words
                                foreach ($roomPhotoMap as $k => $photos) {
                                    $words = explode(' ', $rKey);
                                    $matches = array_filter($words, fn($w) => strlen($w) > 3 && str_contains($k, $w));
                                    if (count($matches) >= 1) { $roomImg = $photos[0]; break; }
                                }
                                // last resort: use hotel gallery image (cycle through)
                                if (!$roomImg && !empty($images)) {
                                    $roomImg = $images[$loop->index % count($images)];
                                }
                            }
                        @endphp
                        <div class="htd-room">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    @if($roomImg)
                                        <img class="htd-room-img" src="{{ $roomImg }}" alt="{{ $roomName }}" style="height:100%;min-height:190px;" onerror="this.parentNode.innerHTML='<div class=\'htd-room-ph\'><i class=\'fas fa-bed\'></i></div>'">
                                    @else
                                        <div class="htd-room-ph"><i class="fas fa-bed"></i></div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="htd-room-body">
                                        <div class="htd-room-name">{{ $roomName }}</div>
                                        <div class="htd-room-features">
                                            @if($boardName)<span class="htd-room-feat"><i class="fas fa-utensils me-1"></i>{{ $boardName }}</span>@endif
                                            @if($isRefund !== null)
                                                <span class="htd-room-feat" style="background:{{ $isRefund?'#eafaf1':'#fef0f0' }};color:{{ $isRefund?'#27ae60':'#e74c3c' }};">
                                                    <i class="fas fa-{{ $isRefund?'check':'times' }} me-1"></i>{{ $isRefund?'Free cancellation':'Non-refundable' }}
                                                </span>
                                            @endif
                                            @if(!empty($room['amenities']))
                                                @foreach(array_slice($room['amenities'],0,3) as $am)
                                                    <span class="htd-room-feat">{{ is_array($am)?($am['description']??''):$am }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="htd-room-price-row">
                                            <div>
                                                @if($price)
                                                <div class="htd-room-price"><sup>$</sup>{{ number_format($price,0) }} <small>/night</small></div>
                                                @if($nights > 1)<div style="font-size:12px;color:#888;">${{ number_format($price*$nights,0) }} total for {{ $nights }} nights</div>@endif
                                                @endif
                                            </div>
                                            @if($offerId)
                                            <button type="button" class="htd-book-room-btn" onclick="nmPrebook('{{ $offerId }}')">
                                                <i class="fas fa-lock me-1"></i> Book This Room
                                            </button>
                                            @endif
                                        </div>
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

            </div>{{-- /col-lg-8 --}}

            {{-- ── RIGHT SIDEBAR ── --}}
            <div class="col-lg-4">
                <div class="htd-sidebar-card">
                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#aaa;margin-bottom:6px;">Starting from</div>
                    @if($minRate)
                    <div class="htd-sidebar-price"><sup>$</sup>{{ number_format($minRate,0) }} <small>/night</small></div>
                    @else
                    <div class="htd-sidebar-price" style="font-size:16px;color:#999;">Check availability</div>
                    @endif
                    <div class="htd-sidebar-divider"></div>
                    <div class="htd-sidebar-row"><span class="label"><i class="fas fa-calendar-check me-1" style="color:#C9A84C;"></i>Check-in</span><span class="val">{{ date('M d, Y', strtotime($checkIn)) }}</span></div>
                    <div class="htd-sidebar-row"><span class="label"><i class="fas fa-calendar-times me-1" style="color:#C9A84C;"></i>Check-out</span><span class="val">{{ date('M d, Y', strtotime($checkOut)) }}</span></div>
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


<script>
// All images for lightbox
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
    var el = document.getElementById('htd-desc');
    el.classList.remove('collapsed');
    btn.style.display = 'none';
}
</script>



<x-app-layout>
@push('css')
<style>
:root { --nm-navy:#0a1628; --nm-gold:#c9a84c; --nm-gold-lt:#e8c96a; }
.nm-tickets-hero {
    background: linear-gradient(160deg,rgba(10,22,40,0.88) 0%,rgba(10,22,40,0.75) 100%),
    url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=1920&q=80') center/cover;
    padding: 100px 0 50px; min-height: 380px; display:flex; align-items:center;
}
.nm-ticket-search { background:rgba(255,255,255,0.97); border-radius:16px; padding:24px 28px; margin-top:24px; box-shadow:0 8px 40px rgba(0,0,0,0.25); }
.nm-ticket-search .form-control, .nm-ticket-search select { height:52px; border:1.5px solid #dde2ec; border-radius:10px; font-size:14px; padding:12px 14px; }
.nm-ticket-search select { -webkit-appearance:none; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23c9a84c' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; }
.nm-ticket-search label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#666; }
.nm-search-btn-gold { background:linear-gradient(135deg,#c9a84c,#e8c96a); color:#0a1628; border:none; height:52px; border-radius:10px; font-weight:800; font-size:15px; width:100%; }
/* Toolbar */
.ev-toolbar { background:#fff; border-bottom:1px solid #e8eaf0; padding:10px 0; position:sticky; top:0; z-index:99; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
.ev-toolbar-inner { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; }
.ev-count { font-size:13px; color:#666; font-weight:500; }
.ev-count strong { color:#0a1628; }
.ev-sort-group { display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
.ev-sort-label { font-size:12px; color:#999; margin-right:2px; white-space:nowrap; }
.ev-sort-btn { border:1.5px solid #ddd; background:#fff; color:#444; border-radius:20px; padding:5px 14px; font-size:12px; font-weight:600; cursor:pointer; transition:all .15s; white-space:nowrap; }
.ev-sort-btn:hover { border-color:#c9a84c; color:#c9a84c; }
.ev-sort-btn.active { background:#0a1628; color:#c9a84c; border-color:#0a1628; }
.ev-dm-btn { border:1px solid #ddd; background:#fff; color:#777; border-radius:12px; padding:3px 10px; font-size:11px; font-weight:700; cursor:pointer; transition:all .15s; white-space:nowrap; }
.ev-dm-btn.active { background:#0a1628; color:#c9a84c; border-color:#0a1628; }
/* Category tabs */
/* StubHub-style slim list rows — one compact row per event, no per-event image */
.nm-events-grid { display:flex; flex-direction:column; gap:14px; margin-top:24px; }
.nm-event-card { background:#fff; border-radius:10px; border:1.5px solid rgba(201,168,76,.32); box-shadow:0 1px 6px rgba(0,0,0,0.06); overflow:hidden; transition:box-shadow .2s,border-color .2s; display:flex; flex-direction:row; align-items:center; min-height:0; }
.nm-event-card:hover { border-color:#c9a84c; }
.nm-event-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.1); }
.nm-event-card > img, .nm-event-card > .nm-event-img-placeholder { display:none; }
.nm-event-datebox { display:flex; flex-direction:column; align-items:center; justify-content:center; width:56px; flex-shrink:0; align-self:stretch; background:#f7f8fc; border-right:1px solid #eee; padding:8px 4px; text-align:center; }
.nm-event-datebox .mon { font-size:9px; font-weight:800; text-transform:uppercase; color:#c9a84c; letter-spacing:.5px; }
.nm-event-datebox .day { font-size:18px; font-weight:900; color:#0a1628; line-height:1.1; }
.nm-event-datebox .wd { font-size:9px; color:#999; font-weight:600; }
.nm-ev-badges { display:inline-flex; flex-wrap:wrap; gap:5px; }
.nm-ev-badge { font-size:10px; font-weight:700; padding:2px 8px; border-radius:20px; display:inline-flex; align-items:center; gap:3px; white-space:nowrap; }
.nm-ev-badge.week { background:#eef1f8; color:#4a5578; }
.nm-ev-badge.hot { background:#fdeaea; color:#d64545; }
.nm-event-body { padding:10px 14px; flex:1; min-width:0; }
.nm-event-cat { font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.8px; color:#c9a84c; margin-bottom:2px; }
.nm-event-title { font-size:14px; font-weight:800; color:#0a1628; margin-bottom:2px; line-height:1.25; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.nm-event-meta { font-size:11.5px; color:#888; display:flex; flex-wrap:wrap; align-items:center; gap:4px 8px; }
.nm-event-meta span { display:inline-flex; align-items:center; gap:4px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:220px; }
.nm-event-meta i { color:#c9a84c; font-size:10px; }
.nm-event-action { display:flex; flex-direction:column; align-items:flex-end; justify-content:center; gap:4px; padding:10px 14px; flex-shrink:0; }
.nm-event-price { font-size:13px; font-weight:800; color:#0a1628; white-space:nowrap; }
.nm-event-price span { font-size:10px; font-weight:400; color:#999; }
.nm-book-ticket { display:inline-block; background:#0a1628; color:#c9a84c; border-radius:7px; padding:6px 14px; text-align:center; font-size:11.5px; font-weight:700; text-decoration:none; transition:all .2s; border:1.5px solid #c9a84c; white-space:nowrap; }
.nm-book-ticket:hover { background:#c9a84c; color:#0a1628; }
@media(max-width:768px){
    .nm-events-grid { gap:6px; margin-top:16px; }
    .nm-event-card { align-items:stretch; }
    .nm-event-body { padding:8px 10px; }
    .nm-event-action { padding:8px 10px 8px 0; }
    .nm-event-title { font-size:13px; }
    .nm-event-meta { font-size:10.5px; }
    .nm-event-meta span { max-width:130px; }
    .nm-book-ticket { padding:6px 10px; font-size:11px; }
}
.nm-cat-tabs { display:flex; gap:8px; flex-wrap:wrap; margin:20px 0 8px; }
.nm-cat-tab { padding:7px 16px; border-radius:25px; border:1.5px solid #dde2ec; background:#fff; font-size:13px; font-weight:600; cursor:pointer; transition:all .15s; text-decoration:none; color:#555; display:inline-flex; align-items:center; gap:5px; }
.nm-cat-tab.active, .nm-cat-tab:hover { background:#0a1628; color:#c9a84c; border-color:#0a1628; }
.nm-suggest-row { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:10px; margin-top:16px; }
.nm-suggest-chip { display:flex; align-items:center; gap:10px; background:#fff; border:1.5px solid #eee; border-radius:12px; padding:8px 12px; text-decoration:none; transition:all .15s; }
.nm-suggest-chip:hover { border-color:#c9a84c; box-shadow:0 3px 10px rgba(0,0,0,0.06); }
.nm-suggest-chip img { width:40px; height:40px; border-radius:8px; object-fit:cover; flex-shrink:0; background:#f0f2f6; }
.nm-suggest-info { display:flex; flex-direction:column; min-width:0; }
.nm-suggest-info strong { font-size:13px; color:#0a1628; font-weight:800; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.nm-suggest-info small { font-size:11px; color:#999; }
@media(max-width:768px){ .nm-suggest-row { grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:8px; } }
/* Two-column layout: results on the left, sidebar on the right instead of dead space */
.nm-results-layout { display:flex; gap:24px; align-items:flex-start; margin-top:8px; }
.nm-results-main { flex:1; min-width:0; }
.nm-results-sidebar { width:300px; flex-shrink:0; position:sticky; top:70px; }
.nm-suggest-col { display:flex; flex-direction:column; gap:10px; }
.nm-suggest-col .nm-suggest-chip { padding:10px 12px; }
.nm-suggest-col .nm-suggest-chip img { width:48px; height:48px; }
.nm-sidebar-title { font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#8b94a5; margin-bottom:12px; }
.nm-sidebar-hero { border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08); border:1.5px solid rgba(201,168,76,.32); }
.nm-sidebar-hero img { width:100%; height:200px; object-fit:cover; display:block; }
.nm-sidebar-hero-body { padding:16px; background:#fff; }
.nm-sidebar-hero-body p { font-size:13px; color:#666; line-height:1.6; margin:0; }
@media(max-width:992px){ .nm-results-sidebar { display:none; } }
.ev-source-badge { display:inline-block; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; padding:2px 6px; border-radius:4px; margin-left:6px; vertical-align:middle; }
.ev-source-ts { background:#e8f0fe; color:#1a56db; }
.ev-source-tn { background:linear-gradient(135deg,#c9a84c,#e8c96a); color:#0a1628; }
.nm-event-card[data-source="ticketnetwork"] { animation:tnGlow 3.2s ease-in-out infinite; }
@keyframes tnGlow { 0%,100% { border-color:rgba(201,168,76,.32); box-shadow:0 1px 6px rgba(0,0,0,0.06); } 50% { border-color:rgba(201,168,76,.95); box-shadow:0 0 12px 1px rgba(201,168,76,.30); } }
@media(max-width:600px){ .ev-toolbar-inner { flex-direction:column; align-items:flex-start; } }

/* Homepage-style field cards for the ticket search */
.evgf-row { display:flex; gap:10px; align-items:stretch; flex-wrap:wrap; }
.evgf-field { flex:1 1 170px; border:1.5px solid #e3e8f2; border-radius:12px; padding:10px 16px; background:#fff; min-height:64px; display:flex; flex-direction:column; justify-content:center; transition:border-color .2s, box-shadow .2s; cursor:text; }
.evgf-field:hover { border-color:#c8d4e8; }
.evgf-field:focus-within { border-color:#c9a84c; box-shadow:0 0 0 3px rgba(201,168,76,.12); }
.evgf-field > label, .evgf-labelrow label { display:block; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:1px; color:#8b94a5; margin-bottom:4px; }
.evgf-field label i { color:#c9a84c; margin-right:4px; font-size:9px; }
.evgf-labelrow { display:flex; justify-content:space-between; align-items:center; gap:8px; margin-bottom:4px; }
.evgf-labelrow label { margin-bottom:0; }
.evgf-field input, .evgf-field select { width:100%; border:none; outline:none; font-size:15px; font-weight:600; color:#0a1628; background:transparent; padding:0; -webkit-appearance:none; appearance:none; }
.evgf-field select { background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23C9A84C' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 4px center; padding-right:20px; cursor:pointer; }
.evgf-field input::placeholder { color:#bcc5d3; font-weight:400; font-size:14px; }
.evgf-dm { display:flex; gap:4px; }
.evgf-dm .ev-dm-btn { border:1px solid #e3e8f2; background:#fff; color:#666; font-size:9.5px; font-weight:700; padding:2px 10px; border-radius:20px; cursor:pointer; line-height:1.5; transition:all .15s; }
.evgf-dm .ev-dm-btn.active { background:#0a1628; color:#c9a84c; border-color:#0a1628; }
.evgf-btn { background:linear-gradient(135deg,#c9a84c 0%,#e3c76f 100%); color:#0a1628; border:none; border-radius:12px; padding:0 30px; font-size:15px; font-weight:700; letter-spacing:.3px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; white-space:nowrap; min-height:64px; transition:all .2s; }
.evgf-btn:hover { transform:translateY(-1px); box-shadow:0 8px 20px rgba(201,168,76,.35); }
@media(max-width:768px){
    .nm-tickets-hero { padding:70px 0 32px; min-height:auto; }
    .nm-ticket-search { padding:14px; border-radius:14px; margin-top:16px; }
    .evgf-row { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
    .evgf-field { min-height:0; height:auto; padding:9px 12px; border-radius:10px; }
    .evgf-field:nth-child(3) { grid-column:1 / -1; }
    .evgf-field > label, .evgf-labelrow label { font-size:8.5px; }
    .evgf-field input, .evgf-field select { font-size:13.5px; }
    .evgf-btn { grid-column:1 / -1; width:100%; height:auto; min-height:0; padding:12px; font-size:14px; border-radius:10px; }
}
</style>
@endpush

<div class="nm-tickets-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <p style="font-size:12px;letter-spacing:4px;text-transform:uppercase;color:#c9a84c;font-weight:700;">Live Events</p>
                <h1 style="font-size:clamp(2rem,4vw,3.2rem);font-weight:900;color:#fff;margin-bottom:8px;">Sports Tickets</h1>
                <p style="color:rgba(255,255,255,0.8);font-size:1.1rem;">NFL &bull; NBA &bull; MLB &bull; NHL &bull; MLS &bull; College Sports</p>

                <div class="nm-ticket-search">
                    <form method="GET">
                        <div class="evgf-row">
                            <div class="evgf-field" style="flex:1.25 1 190px;">
                                <label><i class="fas fa-trophy"></i>Sport or Team</label>
                                <input type="text" name="keyword" list="nm-sport-suggest" autocomplete="off"
                                    placeholder="e.g. Yankees, Lakers, NFL…" value="{{ request('keyword') }}">
                                <datalist id="nm-sport-suggest">
                                    <option value="NFL">
                                    <option value="NBA">
                                    <option value="WNBA">
                                    <option value="MLB">
                                    <option value="NHL">
                                    <option value="MLS">
                                    <option value="NWSL">
                                    <option value="Volleyball">
                                    <option value="College Football">
                                    <option value="College Basketball">
                                    <option value="MMA">
                                    <option value="Golf">
                                    <option value="Tennis">
                                    <option value="Boxing">
                                    <option value="Racing">
                                    <option value="Rodeo">
                                </datalist>
                            </div>
                            <div class="evgf-field">
                                <label><i class="fas fa-map-marker-alt"></i>City</label>
                                <input type="text" name="city" placeholder="e.g. New York, Chicago…" value="{{ request('city') }}">
                            </div>
                            <div class="evgf-field">
                                <div class="evgf-labelrow">
                                    <label><i class="fas fa-calendar"></i>Date</label>
                                    <div class="evgf-dm">
                                        <button type="button" class="ev-dm-btn {{ !request('date') || strlen(request('date'))==10 ? 'active' : '' }}" onclick="evToggleDM(this,'ev-date-input','date')">Exact</button>
                                        <button type="button" class="ev-dm-btn {{ strlen(request('date'))==7 ? 'active' : '' }}" onclick="evToggleDM(this,'ev-date-input','month')">Month</button>
                                    </div>
                                </div>
                                <input id="ev-date-input" name="date"
                                    type="{{ strlen(request('date'))==7 ? 'month' : 'date' }}"
                                    value="{{ request('date') }}"
                                    min="{{ strlen(request('date'))==7 ? date('Y-m') : date('Y-m-d') }}">
                            </div>
                            <button type="submit" class="evgf-btn"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!empty($events) && count($events) > 0)
<div class="ev-toolbar">
    <div class="container ev-toolbar-inner">
        <div class="ev-count"><strong id="ev-visible-count">{{ count($events) }}</strong> events found
            @if(request('city')) in <strong>{{ request('city') }}</strong>@endif
        </div>
        <div class="ev-sort-group">
            <span class="ev-sort-label">Sort:</span>
            <button class="ev-sort-btn active" onclick="evSort('date-asc',this)" ondblclick="evReset()"><i class="fas fa-calendar-alt me-1"></i>Soonest</button>
            <button class="ev-sort-btn" onclick="evSort('price-asc',this)" ondblclick="evReset()"><i class="fas fa-arrow-up me-1"></i>Price: Low</button>
            <button class="ev-sort-btn" onclick="evSort('price-desc',this)" ondblclick="evReset()"><i class="fas fa-arrow-down me-1"></i>Price: High</button>
        </div>
    </div>
</div>
@endif

<div class="container py-4">
    @php
        // Free-text search means the keyword can be typed in any case, so the
        // pill highlight has to compare case-insensitively, not by exact string.
        $activeKw = strtolower(trim(request('keyword', '')));
        // Each tab also matches its generic alias — typing "baseball" (not
        // just literal "MLB") should still light up the closest tab instead
        // of silently falling back to no highlight at all.
        $isTab = fn($vals) => in_array($activeKw, array_map('strtolower', (array) $vals), true) ? 'active' : '';
    @endphp
    <div class="nm-cat-tabs">
        <a href="{{ url('/sports') }}" class="nm-cat-tab {{ $activeKw === '' || $activeKw === 'sports' ? 'active' : '' }}"><i class="fas fa-trophy"></i> All Sports</a>
        <a href="{{ url('/sports?keyword=NFL') }}" class="nm-cat-tab {{ $isTab(['NFL', 'football']) }}"><i class="fas fa-football-ball"></i> NFL</a>
        <a href="{{ url('/sports?keyword=NBA') }}" class="nm-cat-tab {{ $isTab(['NBA', 'basketball']) }}"><i class="fas fa-basketball-ball"></i> NBA</a>
        <a href="{{ url('/sports?keyword=WNBA') }}" class="nm-cat-tab {{ $isTab('WNBA') }}"><i class="fas fa-basketball-ball"></i> WNBA</a>
        <a href="{{ url('/sports?keyword=MLB') }}" class="nm-cat-tab {{ $isTab(['MLB', 'baseball']) }}"><i class="fas fa-baseball-ball"></i> MLB</a>
        <a href="{{ url('/sports?keyword=NHL') }}" class="nm-cat-tab {{ $isTab(['NHL', 'hockey']) }}"><i class="fas fa-hockey-puck"></i> NHL</a>
        <a href="{{ url('/sports?keyword=MLS') }}" class="nm-cat-tab {{ $isTab(['MLS', 'soccer']) }}"><i class="fas fa-futbol"></i> Soccer</a>
        <a href="{{ url('/sports?keyword=NWSL') }}" class="nm-cat-tab {{ $isTab('NWSL') }}"><i class="fas fa-futbol"></i> NWSL</a>
        <a href="{{ url('/sports?keyword=Volleyball') }}" class="nm-cat-tab {{ $isTab('Volleyball') }}"><i class="fas fa-volleyball-ball"></i> Volleyball</a>
        <a href="{{ url('/sports?keyword=Boxing') }}" class="nm-cat-tab {{ $isTab('Boxing') }}"><i class="fas fa-fist-raised"></i> Boxing</a>
        <a href="{{ url('/sports?keyword=Golf') }}" class="nm-cat-tab {{ $isTab('Golf') }}"><i class="fas fa-golf-ball"></i> Golf</a>
        <a href="{{ url('/sports?keyword=Tennis') }}" class="nm-cat-tab {{ $isTab('Tennis') }}"><i class="fas fa-table-tennis"></i> Tennis</a>
        <a href="{{ url('/sports?keyword=Racing') }}" class="nm-cat-tab {{ $isTab('Racing') }}"><i class="fas fa-flag-checkered"></i> Racing</a>
        <a href="{{ url('/sports?keyword=Rodeo') }}" class="nm-cat-tab {{ $isTab('Rodeo') }}"><i class="fas fa-horse"></i> Rodeo</a>
        <a href="{{ url('/sports?keyword=College Football') }}" class="nm-cat-tab {{ $isTab('College Football') }}"><i class="fas fa-football-ball"></i> College Football</a>
        <a href="{{ url('/sports?keyword=College Basketball') }}" class="nm-cat-tab {{ $isTab('College Basketball') }}"><i class="fas fa-basketball-ball"></i> College Basketball</a>
    </div>

    <div class="nm-results-layout">
    <div class="nm-results-main">
    @if($error === 'no_key')
        <div class="alert alert-warning">TicketSqueeze API key not configured.</div>
    @elseif($error)
        <div class="alert alert-warning">{{ $error }}</div>
    @elseif(count($events) > 0)
        <div class="nm-events-grid" id="ev-grid">
            @foreach($events as $event)
            @php
                $venue     = $event['venue'] ?? [];
                $city      = ($venue['city'] ?? '') . (isset($venue['statecode']) ? ', ' . $venue['statecode'] : '');
                $venueName = $venue['name'] ?? '';
                $date      = isset($event['date']) ? \Carbon\Carbon::parse($event['date'])->format('D, M j Y') : 'TBA';
                $time      = isset($event['time']) ? \Carbon\Carbon::createFromFormat('H:i', substr($event['time'],0,5))->format('g:i A') : '';
                $lowPrice  = $event['tickets']['lowprice'] ?? null;
                $priceStr  = $lowPrice ? 'From $' . number_format($lowPrice, 0) : 'Check prices';
                $category  = $event['category']['name'] ?? ($event['category']['path'] ?? 'Sports');
                $ticketUrl = $event['url'] ?? '#';
                $source    = $event['source'] ?? 'ticketsqueeze';
                $dateTs    = isset($event['date']) ? \Carbon\Carbon::parse($event['date'])->timestamp : 9999999999;
                $priceVal  = $lowPrice ?? 999999;
                $catLow    = strtolower($category);
                $faIcon    = 'fa-trophy';
                if(str_contains($catLow,'basketball')) $faIcon='fa-basketball-ball';
                elseif(str_contains($catLow,'football')) $faIcon='fa-football-ball';
                elseif(str_contains($catLow,'baseball')) $faIcon='fa-baseball-ball';
                elseif(str_contains($catLow,'hockey')) $faIcon='fa-hockey-puck';
                elseif(str_contains($catLow,'soccer')) $faIcon='fa-futbol';
                elseif(str_contains($catLow,'ufc')||str_contains($catLow,'mma')||str_contains($catLow,'boxing')) $faIcon='fa-fist-raised';
                elseif(str_contains($catLow,'golf')) $faIcon='fa-golf-ball';
                elseif(str_contains($catLow,'tennis')) $faIcon='fa-table-tennis';
                $eventDt   = isset($event['date']) ? \Carbon\Carbon::parse($event['date']) : null;
                $isThisWeek = $eventDt && $eventDt->between(now(), now()->addDays(7));
                $isSellingFast = isset($event['tickets']['ticketcount']) && $event['tickets']['ticketcount'] > 0 && $event['tickets']['ticketcount'] < 15;
            @endphp
            <div class="nm-event-card" data-date="{{ $dateTs }}" data-price="{{ $priceVal }}" data-source="{{ $source }}">
                @if(!empty($event['image']))
                <img src="{{ $event['image'] }}" alt="{{ $event['name'] }}" loading="lazy" style="width:100%;height:180px;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="nm-event-img-placeholder" style="display:none"><i class="fas {{ $faIcon }}"></i></div>
                @else
                <div class="nm-event-img-placeholder"><i class="fas {{ $faIcon }}"></i></div>
                @endif
                @if($eventDt)
                <div class="nm-event-datebox">
                    <div class="mon">{{ $eventDt->format('M') }}</div>
                    <div class="day">{{ $eventDt->format('j') }}</div>
                    <div class="wd">{{ $eventDt->format('D') }}</div>
                </div>
                @endif
                <div class="nm-event-body">
                    <p class="nm-event-cat">
                        {{ $category }}
                        @if($source === 'ticketnetwork')
                        <span class="ev-source-badge ev-source-tn"><i class="fas fa-star" style="font-size:8px;"></i> Preferred</span>
                        @endif
                    </p>
                    <h4 class="nm-event-title">{{ $event['name'] }}</h4>
                    <div class="nm-event-meta">
                        @if($venueName)<span><i class="fas fa-map-marker-alt"></i> {{ $venueName }}{{ $city ? ', '.$city : '' }}</span>@endif
                        <span><i class="fas fa-calendar"></i> {{ $date }}{{ $time ? ' '.$time : '' }}</span>
                        @if($isThisWeek)<span class="nm-ev-badge week"><i class="fas fa-calendar-check"></i> This week</span>@endif
                        @if($isSellingFast)<span class="nm-ev-badge hot"><i class="fas fa-fire"></i> Selling fast</span>@endif
                    </div>
                </div>
                <div class="nm-event-action">
                    <div class="nm-event-price">{{ $priceStr }} <span>/ ticket</span></div>
                    <a href="{{ $ticketUrl }}" target="_blank" rel="noopener" class="nm-book-ticket">
                        <i class="fas fa-ticket-alt me-1"></i> Get Tickets
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div id="ev-no-results" style="display:none;text-align:center;padding:40px;color:#888;font-size:14px;">
            <i class="fas fa-filter" style="font-size:2rem;color:#c9a84c;display:block;margin-bottom:12px;"></i>
            No events match this sort. <a href="#" onclick="evReset();return false;" style="color:#c9a84c;">Reset</a>
        </div>
    @else
        <div class="alert alert-info text-center mt-4">
            <i class="fas fa-search fa-2x mb-3 d-block" style="color:#c9a84c;"></i>
            No events found. Try a different sport or city.
        </div>
    @endif
    </div>{{-- /nm-results-main --}}

    <aside class="nm-results-sidebar">
        @if(!empty($suggestedTeams))
            <div class="nm-sidebar-title">Popular Teams</div>
            <div class="nm-suggest-col">
                @foreach($suggestedTeams as $team)
                <a href="{{ url('/sports?keyword='.urlencode($team['name'])) }}" class="nm-suggest-chip">
                    <img src="{{ $team['image'] }}" alt="{{ $team['name'] }}" loading="lazy">
                    <span class="nm-suggest-info">
                        <strong>{{ $team['name'] }}</strong>
                        <small>{{ $team['category'] }} &bull; {{ $team['count'] }} event{{ $team['count']!=1?'s':'' }}</small>
                    </span>
                </a>
                @endforeach
            </div>
        @else
            <div class="nm-sidebar-hero">
                <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=600&q=80" alt="Live sports">
                <div class="nm-sidebar-hero-body">
                    <p>Search a city or pick a sport above to see real-time listings, prices, and availability for games near you.</p>
                </div>
            </div>
        @endif
    </aside>
    </div>{{-- /nm-results-layout --}}
</div>

@push('scripts')
<script>
var evSortMode = 'date-asc';

function evSort(mode, btn) {
    evSortMode = mode;
    document.querySelectorAll('.ev-sort-btn').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    evApply();
}

function evReset() {
    evSortMode = 'date-asc';
    var btns = document.querySelectorAll('.ev-sort-btn');
    btns.forEach(function(b){ b.classList.remove('active'); });
    btns[0].classList.add('active');
    evApply();
}

function evToggleDM(btn, inputId, mode) {
    var inp = document.getElementById(inputId);
    inp.value = '';
    inp.type  = mode;
    inp.min   = mode === 'month' ? new Date().toISOString().slice(0,7) : new Date().toISOString().slice(0,10);
    btn.closest('div').querySelectorAll('.ev-dm-btn').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
}

function evApply() {
    var grid = document.getElementById('ev-grid');
    if (!grid) return;
    var cards = Array.from(grid.querySelectorAll('.nm-event-card'));

    cards.sort(function(a, b) {
        var da = parseFloat(a.dataset.date) || 9999999999;
        var db = parseFloat(b.dataset.date) || 9999999999;
        var pa = parseFloat(a.dataset.price) || 999999;
        var pb = parseFloat(b.dataset.price) || 999999;
        if (evSortMode === 'date-asc')   return da - db;
        if (evSortMode === 'price-asc')  return pa - pb;
        if (evSortMode === 'price-desc') return pb - pa;
        return 0;
    });

    cards.forEach(function(c){ grid.appendChild(c); });
    document.getElementById('ev-visible-count').textContent = cards.length;
}
</script>
@endpush

</x-app-layout>

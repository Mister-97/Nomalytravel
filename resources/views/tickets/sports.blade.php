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
.nm-ticket-search .form-control, .nm-ticket-search select { height:46px; border:1.5px solid #dde2ec; border-radius:10px; font-size:14px; }
.nm-ticket-search label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#666; }
.nm-search-btn-gold { background:linear-gradient(135deg,#c9a84c,#e8c96a); color:#0a1628; border:none; height:46px; border-radius:10px; font-weight:800; font-size:15px; width:100%; }
.nm-events-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px; margin-top:30px; }
.nm-event-card { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,0.08); overflow:hidden; transition:transform .2s,box-shadow .2s; display:flex; flex-direction:column; }
.nm-event-card:hover { transform:translateY(-4px); box-shadow:0 10px 32px rgba(0,0,0,0.14); }
.nm-event-img { width:100%; height:180px; object-fit:cover; }
.nm-event-img-placeholder { width:100%; height:180px; background:linear-gradient(135deg,#0a1628,#1a3a6b); display:flex; align-items:center; justify-content:center; font-size:3rem; }
.nm-event-body { padding:16px; flex:1; display:flex; flex-direction:column; }
.nm-event-cat { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#c9a84c; margin-bottom:6px; }
.nm-event-title { font-size:16px; font-weight:800; color:#0a1628; margin-bottom:8px; line-height:1.3; }
.nm-event-meta { font-size:12px; color:#888; line-height:1.6; }
.nm-event-meta i { color:#c9a84c; width:16px; }
.nm-event-price { font-size:18px; font-weight:900; color:#0a1628; margin-top:10px; }
.nm-event-price span { font-size:11px; font-weight:400; color:#999; }
.nm-book-ticket { display:block; margin-top:12px; background:#0a1628; color:#c9a84c; border-radius:9px; padding:10px 0; text-align:center; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s; border:2px solid #c9a84c; }
.nm-book-ticket:hover { background:#c9a84c; color:#0a1628; }
.nm-cat-tabs { display:flex; gap:8px; flex-wrap:wrap; margin:20px 0; }
.nm-cat-tab { padding:8px 18px; border-radius:25px; border:1.5px solid #dde2ec; background:#fff; font-size:13px; font-weight:600; cursor:pointer; transition:all .15s; text-decoration:none; color:#555; }
.nm-cat-tab.active, .nm-cat-tab:hover { background:#0a1628; color:#c9a84c; border-color:#0a1628; }
.nm-no-key-box { background:linear-gradient(135deg,#0a1628,#1a3a6b); border-radius:16px; padding:40px; text-align:center; color:#fff; margin:30px 0; }
.nm-no-key-box i { font-size:3rem; color:#c9a84c; margin-bottom:16px; }
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
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>Team or Keyword</label>
                                <select name="keyword" class="form-control sport-type-select">
                                <option value="">All Sports</option>
                                <option value="NFL Football" {{ request('keyword')=='NFL Football'?'selected':'' }}>🏈 NFL Football</option>
                                <option value="NBA Basketball" {{ request('keyword')=='NBA Basketball'?'selected':'' }}>🏀 NBA Basketball</option>
                                <option value="MLB Baseball" {{ request('keyword')=='MLB Baseball'?'selected':'' }}>⚾ MLB Baseball</option>
                                <option value="NHL Hockey" {{ request('keyword')=='NHL Hockey'?'selected':'' }}>🏒 NHL Hockey</option>
                                <option value="MLS Soccer" {{ request('keyword')=='MLS Soccer'?'selected':'' }}>⚽ MLS Soccer</option>
                                <option value="College Football" {{ request('keyword')=='College Football'?'selected':'' }}>🏈 College Football</option>
                                <option value="College Basketball" {{ request('keyword')=='College Basketball'?'selected':'' }}>🏀 College Basketball</option>
                                <option value="UFC MMA" {{ request('keyword')=='UFC MMA'?'selected':'' }}>🥊 UFC / MMA</option>
                                <option value="Golf" {{ request('keyword')=='Golf'?'selected':'' }}>⛳ Golf</option>
                                <option value="Tennis" {{ request('keyword')=='Tennis'?'selected':'' }}>🎾 Tennis</option>
                                <option value="Boxing" {{ request('keyword')=='Boxing'?'selected':'' }}>🥊 Boxing</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" list="nm-city-list" placeholder="e.g. New York, Miami..." value="{{ request('city') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
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
    <div class="nm-cat-tabs">
        <a href="{{ url('/sports') }}" class="nm-cat-tab {{ !request('keyword') ? 'active' : '' }}">All Sports</a>
        <a href="{{ url('/sports?keyword=NFL') }}" class="nm-cat-tab {{ request('keyword')=='NFL' ? 'active' : '' }}">🏈 NFL</a>
        <a href="{{ url('/sports?keyword=NBA') }}" class="nm-cat-tab {{ request('keyword')=='NBA' ? 'active' : '' }}">🏀 NBA</a>
        <a href="{{ url('/sports?keyword=MLB') }}" class="nm-cat-tab {{ request('keyword')=='MLB' ? 'active' : '' }}">⚾ MLB</a>
        <a href="{{ url('/sports?keyword=NHL') }}" class="nm-cat-tab {{ request('keyword')=='NHL' ? 'active' : '' }}">🏒 NHL</a>
        <a href="{{ url('/sports?keyword=MLS+Soccer') }}" class="nm-cat-tab {{ request('keyword')=='MLS+Soccer' ? 'active' : '' }}">⚽ Soccer</a>
    </div>

    @if($error === 'no_key')
    <div class="nm-no-key-box">
        <i class="fas fa-ticket-alt"></i>
        <h3 style="color:#c9a84c;font-weight:900;">Live Sports Tickets Coming Soon</h3>
        <p style="color:rgba(255,255,255,0.75);max-width:500px;margin:10px auto 20px;">We're integrating with Ticketmaster to bring you live sports tickets. To activate, add your Ticketmaster API key to the .env file: <code style="background:rgba(255,255,255,0.1);padding:2px 8px;border-radius:4px;">TICKETMASTER_KEY=your_key_here</code></p>
        <p style="color:rgba(255,255,255,0.5);font-size:13px;">Get a free API key at <strong style="color:#c9a84c;">developer.ticketmaster.com</strong></p>
        <a href="{{ url('/contact') }}" class="nm-book-ticket d-inline-block mt-3" style="padding:12px 30px;width:auto;">Contact Us for Tickets</a>
    </div>

    <!-- Featured Sports Events (Static showcases while API key is being set up) -->
    <h3 style="font-weight:800;color:#0a1628;margin:30px 0 16px;">Featured Events</h3>
    <div class="nm-events-grid">
        @php
        $featured = [
            ['icon'=>'🏈','cat'=>'NFL','title'=>'Dallas Cowboys vs Philadelphia Eagles','venue'=>'AT&T Stadium','city'=>'Dallas, TX','date'=>'Upcoming 2026','price'=>'From $85'],
            ['icon'=>'🏀','cat'=>'NBA','title'=>'LA Lakers vs Boston Celtics','venue'=>'Crypto.com Arena','city'=>'Los Angeles, CA','date'=>'Upcoming 2026','price'=>'From $95'],
            ['icon'=>'⚾','cat'=>'MLB','title'=>'New York Yankees vs Boston Red Sox','venue'=>'Yankee Stadium','city'=>'New York, NY','date'=>'Upcoming 2026','price'=>'From $55'],
            ['icon'=>'🏒','cat'=>'NHL','title'=>'Chicago Blackhawks vs Detroit Red Wings','venue'=>'United Center','city'=>'Chicago, IL','date'=>'Upcoming 2026','price'=>'From $45'],
            ['icon'=>'⚽','cat'=>'MLS','title'=>'LA Galaxy vs LAFC','venue'=>'Dignity Health Sports Park','city'=>'Carson, CA','date'=>'Upcoming 2026','price'=>'From $35'],
            ['icon'=>'🏈','cat'=>'College','title'=>'Alabama vs Auburn — Iron Bowl','venue'=>'Bryant-Denny Stadium','city'=>'Tuscaloosa, AL','date'=>'Upcoming 2026','price'=>'From $75'],
        ];
        @endphp
        @foreach($featured as $ev)
        <div class="nm-event-card">
            <div class="nm-event-img-placeholder">{{ $ev['icon'] }}</div>
            <div class="nm-event-body">
                <p class="nm-event-cat">{{ $ev['cat'] }}</p>
                <h4 class="nm-event-title">{{ $ev['title'] }}</h4>
                <div class="nm-event-meta">
                    <div><i class="fas fa-map-marker-alt"></i> {{ $ev['venue'] }}, {{ $ev['city'] }}</div>
                    <div><i class="fas fa-calendar"></i> {{ $ev['date'] }}</div>
                </div>
                <div class="nm-event-price">{{ $ev['price'] }}</div>
                <a href="{{ url('/contact') }}" class="nm-book-ticket">Get Tickets</a>
            </div>
        </div>
        @endforeach
    </div>

    @elseif($error)
    <div class="alert alert-warning">{{ $error }}</div>

    @else
    @if(count($events) > 0)
    <p class="text-muted mb-3">
        <strong>{{ count($events) }}</strong> live sports events
        @if(request('city')) in <strong>{{ request('city') }}</strong>@endif
        @if(request('keyword')) &bull; <strong>{{ request('keyword') }}</strong>@endif
        @if(request('date')) &bull; {{ \Carbon\Carbon::parse(request('date'))->format('M j, Y') }}@endif
        &nbsp;<a href="{{ url('/sports') }}" class="text-muted" style="font-size:12px;">(clear filters)</a>
    </p>
    <div class="nm-events-grid">
        @foreach($events as $event)
        @php
        $imgUrl = $event['images'][0]['url'] ?? null;
        $venue = $event['_embedded']['venues'][0] ?? [];
        $venueName = $venue['name'] ?? '';
        $city = ($venue['city']['name'] ?? '') . (isset($venue['state']['stateCode']) ? ', ' . $venue['state']['stateCode'] : '');
        $date = isset($event['dates']['start']['localDate']) ? \Carbon\Carbon::parse($event['dates']['start']['localDate'])->format('D, M j Y') : 'TBA';
        $time = isset($event['dates']['start']['localTime']) ? \Carbon\Carbon::parse($event['dates']['start']['localTime'])->format('g:i A') : '';
        $minPrice = $event['priceRanges'][0]['min'] ?? null;
        $maxPrice = $event['priceRanges'][0]['max'] ?? null;
        $priceStr = $minPrice ? '$' . number_format($minPrice, 0) . ($maxPrice && $maxPrice != $minPrice ? ' – $' . number_format($maxPrice, 0) : '') : 'Check prices';
        $classification = $event['classifications'][0]['segment']['name'] ?? '';
        $subType = $event['classifications'][0]['genre']['name'] ?? $classification;
        $ticketUrl = $event['url'] ?? '#';
        @endphp
        <div class="nm-event-card">
            @if($imgUrl)
            <img class="nm-event-img" src="{{ $imgUrl }}" alt="{{ $event['name'] }}" loading="lazy">
            @else
            <div class="nm-event-img-placeholder">🏟</div>
            @endif
            <div class="nm-event-body">
                <p class="nm-event-cat">{{ $subType }}</p>
                <h4 class="nm-event-title">{{ $event['name'] }}</h4>
                <div class="nm-event-meta">
                    @if($venueName)<div><i class="fas fa-map-marker-alt"></i> {{ $venueName }}{{ $city ? ', ' . $city : '' }}</div>@endif
                    <div><i class="fas fa-calendar"></i> {{ $date }}{{ $time ? ' at ' . $time : '' }}</div>
                </div>
                <div class="nm-event-price">{{ $priceStr }} <span>/ ticket</span></div>
                <a href="{{ $ticketUrl }}" target="_blank" class="nm-book-ticket"><i class="fas fa-ticket-alt me-1"></i> Get Tickets</a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-info text-center mt-4">
        <i class="fas fa-search fa-2x mb-3 d-block" style="color:#c9a84c;"></i>
        No events found for your search. Try different keywords or city.
    </div>
    @endif
    @endif
</div>
</x-app-layout>

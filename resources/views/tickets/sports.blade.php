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
/* Category tabs */
.nm-events-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px; margin-top:24px; }
.nm-event-card { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,0.08); overflow:hidden; transition:transform .2s,box-shadow .2s; display:flex; flex-direction:column; }
.nm-event-card:hover { transform:translateY(-4px); box-shadow:0 10px 32px rgba(0,0,0,0.14); }
.nm-event-img-placeholder { width:100%; height:180px; background:linear-gradient(135deg,#0a1628,#1a3a6b); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.4); font-size:2.5rem; }
.nm-event-body { padding:16px; flex:1; display:flex; flex-direction:column; }
.nm-event-cat { font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#c9a84c; margin-bottom:6px; }
.nm-event-title { font-size:16px; font-weight:800; color:#0a1628; margin-bottom:8px; line-height:1.3; }
.nm-event-meta { font-size:12px; color:#888; line-height:1.6; }
.nm-event-meta i { color:#c9a84c; width:16px; }
.nm-event-price { font-size:18px; font-weight:900; color:#0a1628; margin-top:auto; padding-top:10px; }
.nm-event-price span { font-size:11px; font-weight:400; color:#999; }
.nm-book-ticket { display:block; margin-top:12px; background:#0a1628; color:#c9a84c; border-radius:9px; padding:10px 0; text-align:center; font-size:13px; font-weight:700; text-decoration:none; transition:all .2s; border:2px solid #c9a84c; }
.nm-book-ticket:hover { background:#c9a84c; color:#0a1628; }
.nm-cat-tabs { display:flex; gap:8px; flex-wrap:wrap; margin:20px 0 8px; }
.nm-cat-tab { padding:7px 16px; border-radius:25px; border:1.5px solid #dde2ec; background:#fff; font-size:13px; font-weight:600; cursor:pointer; transition:all .15s; text-decoration:none; color:#555; display:inline-flex; align-items:center; gap:5px; }
.nm-cat-tab.active, .nm-cat-tab:hover { background:#0a1628; color:#c9a84c; border-color:#0a1628; }
.ev-source-badge { display:inline-block; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:.5px; padding:2px 6px; border-radius:4px; margin-left:6px; vertical-align:middle; }
.ev-source-ts { background:#e8f0fe; color:#1a56db; }
.ev-source-tn { background:#fef9e7; color:#b7791f; }
@media(max-width:600px){ .ev-toolbar-inner { flex-direction:column; align-items:flex-start; } }
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
                                <label>Sport or Team</label>
                                <select name="keyword" class="form-control">
                                    <option value="sports">All Sports</option>
                                    <option value="NFL" {{ request('keyword')=='NFL'?'selected':'' }}>NFL Football</option>
                                    <option value="NBA" {{ request('keyword')=='NBA'?'selected':'' }}>NBA Basketball</option>
                                    <option value="MLB" {{ request('keyword')=='MLB'?'selected':'' }}>MLB Baseball</option>
                                    <option value="NHL" {{ request('keyword')=='NHL'?'selected':'' }}>NHL Hockey</option>
                                    <option value="MLS" {{ request('keyword')=='MLS'?'selected':'' }}>MLS Soccer</option>
                                    <option value="College Football" {{ request('keyword')=='College Football'?'selected':'' }}>College Football</option>
                                    <option value="College Basketball" {{ request('keyword')=='College Basketball'?'selected':'' }}>College Basketball</option>
                                    <option value="UFC" {{ request('keyword')=='UFC'?'selected':'' }}>UFC / MMA</option>
                                    <option value="Golf" {{ request('keyword')=='Golf'?'selected':'' }}>Golf</option>
                                    <option value="Tennis" {{ request('keyword')=='Tennis'?'selected':'' }}>Tennis</option>
                                    <option value="Boxing" {{ request('keyword')=='Boxing'?'selected':'' }}>Boxing</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>City</label>
                                <input type="text" name="city" class="form-control" placeholder="e.g. New York, Chicago..." value="{{ request('city') }}">
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
    <div class="nm-cat-tabs">
        <a href="{{ url('/sports') }}" class="nm-cat-tab {{ !request('keyword') || request('keyword')=='sports' ? 'active' : '' }}"><i class="fas fa-trophy"></i> All Sports</a>
        <a href="{{ url('/sports?keyword=NFL') }}" class="nm-cat-tab {{ request('keyword')=='NFL' ? 'active' : '' }}"><i class="fas fa-football-ball"></i> NFL</a>
        <a href="{{ url('/sports?keyword=NBA') }}" class="nm-cat-tab {{ request('keyword')=='NBA' ? 'active' : '' }}"><i class="fas fa-basketball-ball"></i> NBA</a>
        <a href="{{ url('/sports?keyword=MLB') }}" class="nm-cat-tab {{ request('keyword')=='MLB' ? 'active' : '' }}"><i class="fas fa-baseball-ball"></i> MLB</a>
        <a href="{{ url('/sports?keyword=NHL') }}" class="nm-cat-tab {{ request('keyword')=='NHL' ? 'active' : '' }}"><i class="fas fa-hockey-puck"></i> NHL</a>
        <a href="{{ url('/sports?keyword=MLS') }}" class="nm-cat-tab {{ request('keyword')=='MLS' ? 'active' : '' }}"><i class="fas fa-futbol"></i> Soccer</a>
        <a href="{{ url('/sports?keyword=UFC') }}" class="nm-cat-tab {{ request('keyword')=='UFC' ? 'active' : '' }}"><i class="fas fa-fist-raised"></i> UFC</a>
    </div>

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
            @endphp
            <div class="nm-event-card" data-date="{{ $dateTs }}" data-price="{{ $priceVal }}" data-source="{{ $source }}">
                @if(!empty($event['image']))
                <img src="{{ $event['image'] }}" alt="{{ $event['name'] }}" loading="lazy" style="width:100%;height:180px;object-fit:cover;" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <div class="nm-event-img-placeholder" style="display:none"><i class="fas {{ $faIcon }}"></i></div>
                @else
                <div class="nm-event-img-placeholder"><i class="fas {{ $faIcon }}"></i></div>
                @endif
                <div class="nm-event-body">
                    <p class="nm-event-cat">
                        {{ $category }}
                        @if($source === 'ticketnetwork')
                        <span class="ev-source-badge ev-source-tn">TN</span>
                        @endif
                    </p>
                    <h4 class="nm-event-title">{{ $event['name'] }}</h4>
                    <div class="nm-event-meta">
                        @if($venueName)<div><i class="fas fa-map-marker-alt"></i> {{ $venueName }}{{ $city ? ', '.$city : '' }}</div>@endif
                        <div><i class="fas fa-calendar"></i> {{ $date }}{{ $time ? ' at '.$time : '' }}</div>
                        @if(isset($event['tickets']['ticketcount']) && $event['tickets']['ticketcount'] > 0)
                        <div><i class="fas fa-ticket-alt"></i> {{ number_format($event['tickets']['ticketcount']) }} tickets</div>
                        @endif
                    </div>
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

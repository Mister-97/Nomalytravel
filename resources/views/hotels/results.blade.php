<x-app-layout>
@push('css')
<style>
.ht-results-header { background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%); padding:24px 0 0; }
.ht-results-header h2 { color:#C9A84C; font-weight:900; font-size:1.4rem; margin:0; }
.ht-results-header p { color:rgba(255,255,255,0.7); font-size:13px; margin:4px 0 0; }
.ht-back-btn { color:#C9A84C; text-decoration:none; font-size:13px; font-weight:600; }
.ht-back-btn:hover { color:#e8c96a; }
.ht-toolbar { background:#fff; border-bottom:1px solid #e8eaf0; padding:12px 0; position:sticky; top:0; z-index:99; box-shadow:0 2px 8px rgba(0,0,0,0.06); }
.ht-toolbar-inner { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; }
.ht-count { font-size:13px; color:#666; font-weight:500; }
.ht-count strong { color:#070D1A; }
.ht-sort-group, .ht-filter-group { display:flex; align-items:center; gap:6px; flex-wrap:wrap; }
.ht-sort-label, .ht-filter-label { font-size:12px; color:#999; margin-right:2px; white-space:nowrap; }
.ht-sort-btn, .ht-star-btn {
    border:1.5px solid #ddd; background:#fff; color:#444; border-radius:20px;
    padding:5px 14px; font-size:12px; font-weight:600; cursor:pointer;
    transition:all .15s; white-space:nowrap;
}
.ht-sort-btn:hover, .ht-star-btn:hover { border-color:#C9A84C; color:#C9A84C; }
.ht-sort-btn.active, .ht-star-btn.active { background:#070D1A; color:#C9A84C; border-color:#070D1A; }
.ht-star-btn.active { background:#C9A84C; color:#070D1A; border-color:#C9A84C; }
.ht-divider { width:1px; height:20px; background:#e0e0e0; margin:0 4px; }
.ht-results-body { background:#f7f8fc; padding:24px 0 60px; }
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
.ht-card-price { font-size:22px; font-weight:900; color:#070D1A; margin-bottom:4px; }
.ht-card-price span { font-size:11px; font-weight:400; color:#999; }
.ht-card-total { font-size:11px; color:#aaa; margin-bottom:10px; }
.ht-book-btn { display:block; margin-top:auto; background:#070D1A; color:#C9A84C; border-radius:9px; padding:9px; text-align:center; font-size:13px; font-weight:700; border:2px solid #C9A84C; cursor:pointer; text-decoration:none; transition:all .2s; }
.ht-book-btn:hover { background:#C9A84C; color:#070D1A; }
.ht-empty { text-align:center; padding:60px 20px; color:#888; }
.ht-empty i { font-size:3rem; color:#C9A84C; margin-bottom:16px; display:block; }
.ht-no-results { display:none; text-align:center; padding:40px; color:#888; font-size:14px; }
@media(max-width:600px){
    .ht-toolbar-inner { flex-direction:column; align-items:flex-start; }
}
</style>
@endpush

<div class="ht-results-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h2><i class="fas fa-hotel me-2"></i>{{ $search['city'] }}</h2>
                <p>{{ $search['check_in'] }} &rarr; {{ $search['check_out'] }} &bull; {{ $search['adults'] }} adult{{ $search['adults']>1?'s':'' }}</p>
            </div>
            <a href="{{ route('hotels.index') }}" class="ht-back-btn mt-1"><i class="fas fa-arrow-left me-1"></i> New Search</a>
        </div>
    </div>
</div>

@if(!empty($hotels))
@php
    $nights = max(1, \Carbon\Carbon::parse($search['check_in'])->diffInDays(\Carbon\Carbon::parse($search['check_out'])));
@endphp
<div class="ht-toolbar">
    <div class="container ht-toolbar-inner">
        <div class="ht-count"><strong id="ht-visible-count">{{ count($hotels) }}</strong> properties found</div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <div class="ht-sort-group">
                <span class="ht-sort-label">Sort:</span>
                <button class="ht-sort-btn active" onclick="htSort('price-asc',this)">Cheapest</button>
                <button class="ht-sort-btn" onclick="htSort('price-desc',this)">Most Expensive</button>
                <button class="ht-sort-btn" onclick="htSort('stars-desc',this)">Stars ↓</button>
                <button class="ht-sort-btn" onclick="htSort('stars-asc',this)">Stars ↑</button>
            </div>
            <div class="ht-divider d-none d-md-block"></div>
            <div class="ht-filter-group">
                <span class="ht-filter-label">Stars:</span>
                <button class="ht-star-btn active" onclick="htFilter(0,this)">All</button>
                <button class="ht-star-btn" onclick="htFilter(2,this)">2★+</button>
                <button class="ht-star-btn" onclick="htFilter(3,this)">3★+</button>
                <button class="ht-star-btn" onclick="htFilter(4,this)">4★+</button>
                <button class="ht-star-btn" onclick="htFilter(5,this)">5★</button>
            </div>
        </div>
    </div>
</div>

<div class="ht-results-body">
    <div class="container">
        <div class="ht-grid" id="ht-grid">
            @foreach($hotels as $hotel)
            @php
                $name      = $hotel['name'] ?? ($hotel['hotelName'] ?? 'Hotel');
                $hotelId   = $hotel['hotelId'] ?? ($hotel['id'] ?? '');
                $city      = $hotel['city'] ?? ($hotel['address']['city'] ?? '');
                $country   = $hotel['country'] ?? ($hotel['address']['country'] ?? '');
                $stars     = (int)($hotel['starRating'] ?? ($hotel['stars'] ?? 0));
                $img       = $hotel['thumbnail'] ?? ($hotel['image'] ?? null);
                $totalRate = $hotel['minRate'] ?? null;
                if (!$totalRate && !empty($hotel['roomTypes'])) {
                    $totalRate = collect($hotel['roomTypes'])->min('rates.0.retailRate.total.0.amount')
                              ?? collect($hotel['roomTypes'])->min('minRate');
                }
                $minRate = $totalRate ? round($totalRate / $nights, 2) : null;
                $source  = $hotel['source'] ?? 'liteapi';
            @endphp
            <div class="ht-card"
                 data-price="{{ $totalRate ?? 999999 }}"
                 data-stars="{{ $stars }}"
                 data-source="{{ $source }}">
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
                    <div class="ht-card-stars">@for($s=1;$s<=$stars;$s++)<i class="fas fa-star"></i>@endfor</div>
                    @endif
                    @if($totalRate)
                        @if($nights > 1)
                        <div class="ht-card-price">${{ number_format($totalRate, 0) }} <span>total</span></div>
                        <div class="ht-card-total">${{ number_format($minRate, 0) }}/night &bull; {{ $nights }} nights</div>
                        @else
                        <div class="ht-card-price">${{ number_format($minRate, 0) }} <span>/ night</span></div>
                        @endif
                    @endif
                    @if($source === 'duffel' && !empty($hotel['hotelId']))
                    <a href="{{ route('hotels.duffel.detail', $hotel['hotelId']) }}?check_in={{ $search['check_in'] }}&check_out={{ $search['check_out'] }}&adults={{ $search['adults'] }}" class="ht-book-btn">View Hotel &amp; Rooms &rarr;</a>
                    @else
                    <a href="{{ route('hotels.detail', $hotelId) }}?check_in={{ $search['check_in'] }}&check_out={{ $search['check_out'] }}&adults={{ $search['adults'] }}" class="ht-book-btn">View Hotel &amp; Rooms &rarr;</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="ht-no-results" id="ht-no-results">
            <i class="fas fa-filter" style="font-size:2rem;color:#C9A84C;display:block;margin-bottom:12px;"></i>
            No properties match this filter. <a href="#" onclick="htFilter(0,document.querySelector('.ht-star-btn'));return false;" style="color:#C9A84C;">Clear filter</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
var htMinStars = 0;
var htSortMode = 'price-asc';

function htSort(mode, btn) {
    htSortMode = mode;
    document.querySelectorAll('.ht-sort-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    htApply();
}

function htFilter(stars, btn) {
    htMinStars = stars;
    document.querySelectorAll('.ht-star-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    htApply();
}

function htApply() {
    var grid = document.getElementById('ht-grid');
    var cards = Array.from(grid.querySelectorAll('.ht-card'));

    // Filter
    var visible = cards.filter(function(c) {
        var s = parseInt(c.dataset.stars) || 0;
        var show = htMinStars === 5 ? s >= 5 : s >= htMinStars;
        c.style.display = show ? '' : 'none';
        return show;
    });

    // Sort visible cards
    visible.sort(function(a, b) {
        var pa = parseFloat(a.dataset.price) || 999999;
        var pb = parseFloat(b.dataset.price) || 999999;
        var sa = parseInt(a.dataset.stars) || 0;
        var sb = parseInt(b.dataset.stars) || 0;
        if (htSortMode === 'price-asc')  return pa - pb;
        if (htSortMode === 'price-desc') return pb - pa;
        if (htSortMode === 'stars-desc') return sb !== sa ? sb - sa : pa - pb;
        if (htSortMode === 'stars-asc')  return sa !== sb ? sa - sb : pa - pb;
        return 0;
    });

    // Re-append in sorted order (hidden ones stay hidden)
    visible.forEach(function(c) { grid.appendChild(c); });

    // Update count
    document.getElementById('ht-visible-count').textContent = visible.length;
    document.getElementById('ht-no-results').style.display = visible.length === 0 ? 'block' : 'none';
}
</script>
@endpush

@else
<div class="ht-results-body">
    <div class="container">
        <div class="ht-empty">
            <i class="fas fa-search"></i>
            <h4>No hotels found</h4>
            <p>Try a different city or date range.</p>
            <a href="{{ route('hotels.index') }}" class="btn btn-outline-secondary mt-2">Search Again</a>
        </div>
    </div>
</div>
@endif

</x-app-layout>

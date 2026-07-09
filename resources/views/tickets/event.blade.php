<x-app-layout>
@push('css')
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
:root { --navy:#070D1A; --gold:#C9A84C; --gold-lt:#e8c96a; }
.tge-header { background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%); padding:34px 0; }
.tge-cat { display:inline-block; background:rgba(201,168,76,.15); color:var(--gold); font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.2px; padding:5px 14px; border-radius:20px; margin-bottom:10px; border:1px solid rgba(201,168,76,.35); }
.tge-header h1 { color:#fff; font-weight:900; font-size:1.7rem; margin:0 0 8px; }
.tge-meta { color:#b9c4d8; font-size:13px; }
.tge-meta i { color:var(--gold); }
.tge-back { color:var(--gold); text-decoration:none; font-size:13px; font-weight:600; }
.tge-back:hover { color:var(--gold-lt); }
.tge-body { background:#f7f8fc; padding:36px 0 60px; min-height:60vh; }

.tge-listing { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.06); border:1.5px solid transparent; padding:16px 20px; margin-bottom:12px; display:flex; align-items:center; gap:16px; flex-wrap:wrap; transition:border-color .15s, box-shadow .15s; }
.tge-listing:hover { border-color:var(--gold); box-shadow:0 4px 16px rgba(201,168,76,.15); }
.tge-seat { flex:1 1 200px; min-width:180px; }
.tge-seat .sec { font-weight:800; color:var(--navy); font-size:15px; }
.tge-seat .rw { font-size:12px; color:#888; margin-top:2px; }
.tge-deliv { flex:0 0 auto; font-size:12px; color:#666; }
.tge-deliv i { color:var(--gold); margin-right:4px; }
.tge-price { flex:0 0 auto; text-align:right; }
.tge-price .amt { font-weight:900; color:var(--navy); font-size:18px; }
.tge-price .per { font-size:11px; color:#999; }
.tge-buy { flex:0 0 auto; display:flex; align-items:center; gap:10px; }
.tge-qty { border:1.5px solid #dde2ec; border-radius:9px; padding:9px 10px; font-size:13px; font-family:'DM Sans',sans-serif; font-weight:700; color:var(--navy); outline:none; background:#fff; }
.tge-qty:focus { border-color:var(--gold); }
.tge-btn { background:linear-gradient(135deg,var(--gold),var(--gold-lt)); color:var(--navy); border:none; border-radius:9px; padding:10px 22px; font-size:13px; font-weight:800; font-family:'DM Sans',sans-serif; cursor:pointer; transition:all .15s; white-space:nowrap; }
.tge-btn:hover { filter:brightness(1.07); transform:translateY(-1px); }
.tge-note { font-size:11px; color:#aaa; flex-basis:100%; margin:0; }
.tge-empty { background:#fff; border-radius:14px; box-shadow:0 3px 16px rgba(0,0,0,.08); padding:40px; text-align:center; color:#888; }
.tge-count { font-size:12px; color:#888; margin-bottom:16px; }
.tge-count b { color:var(--navy); }
@media (max-width: 640px) {
    .tge-listing { gap:10px; }
    .tge-buy { flex-basis:100%; justify-content:flex-end; }
}
</style>
@endpush

@php
    $venue = $event['venue'] ?? [];
    $when  = !empty($event['date']) ? date('D, M j, Y g:i A', strtotime($event['date'])) : 'TBA';
@endphp

<div class="tge-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <span class="tge-cat">{{ $event['category']['name'] ?? 'Event' }}</span>
                <h1>{{ $event['name'] }}</h1>
                <div class="tge-meta">
                    <span class="me-3"><i class="fas fa-map-marker-alt me-1"></i>{{ $venue['name'] ?? '' }}{{ !empty($venue['city']) ? ', '.$venue['city'] : '' }}</span>
                    <span><i class="fas fa-calendar me-1"></i>{{ $when }}</span>
                </div>
            </div>
            <a href="javascript:history.back()" class="tge-back"><i class="fas fa-arrow-left me-1"></i> Back</a>
        </div>
    </div>
</div>

<div class="tge-body">
    <div class="container" style="max-width:860px;">

        @if (session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        @if ($error)
            <div class="tge-empty">
                <i class="fas fa-ticket-alt mb-3" style="font-size:2.2rem;color:#ddd;display:block;"></i>
                {{ $error }}
            </div>
        @elseif (count($groups) === 0)
            <div class="tge-empty">
                <i class="fas fa-ticket-alt mb-3" style="font-size:2.2rem;color:#ddd;display:block;"></i>
                No tickets are currently listed for this event. Check back soon — inventory updates constantly.
            </div>
        @else
            <p class="tge-count"><b>{{ count($groups) }}</b> ticket listing{{ count($groups) === 1 ? '' : 's' }} available &middot; prices are per ticket</p>

            @foreach ($groups as $g)
            <div class="tge-listing">
                <div class="tge-seat">
                    <div class="sec">{{ $g['section'] ?: 'General Admission' }}</div>
                    <div class="rw">{{ $g['row'] ? 'Row '.$g['row'].' · ' : '' }}{{ $g['available'] }} available</div>
                </div>
                <div class="tge-deliv">
                    <i class="fas {{ in_array('E-Ticket', $g['delivery_methods']) ? 'fa-mobile-alt' : 'fa-truck' }}"></i>{{ implode(', ', $g['delivery_methods']) ?: 'E-Ticket' }}
                </div>
                <div class="tge-price">
                    <div class="amt">{{ $g['currency'] }} {{ number_format($g['price'], 2) }}</div>
                    <div class="per">per ticket</div>
                </div>
                <form method="POST" action="{{ route('tickets.checkout') }}" class="tge-buy">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event['id'] }}">
                    <input type="hidden" name="ticket_group_id" value="{{ $g['id'] }}">
                    <select name="quantity" class="tge-qty" aria-label="Quantity">
                        @foreach (collect($g['quantities'])->sort()->values() as $q)
                            <option value="{{ $q }}">{{ $q }} ticket{{ $q > 1 ? 's' : '' }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="tge-btn">Buy <i class="fas fa-arrow-right ms-1"></i></button>
                </form>
                @if ($g['notes'])<p class="tge-note"><i class="fas fa-info-circle me-1"></i>{{ $g['notes'] }}</p>@endif
            </div>
            @endforeach
        @endif

    </div>
</div>

</x-app-layout>

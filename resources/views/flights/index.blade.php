<x-app-layout>
@push('css')
<style>
.nm-fc {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    margin: 0 0 8px 0;
    padding: 12px 14px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    border-left: 4px solid #ccc;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    box-sizing: border-box;
}
.nm-fc:hover { background: #f9f9f9; box-shadow: 0 2px 8px rgba(0,0,0,0.10); }
.nm-fc.nonstop { border-left-color: #2e7d32; }
.nm-fc.with-stops { border-left-color: #bbb; }
/* Logo */
.nm-fc-logo { width: 22px; height: 22px; object-fit: contain; border-radius: 3px; flex-shrink: 0; }
/* Dep block */
.nm-fc-dep { flex-shrink: 0; text-align: left; min-width: 52px; }
/* Middle bar */
.nm-fc-mid { flex: 1; display: flex; flex-direction: column; align-items: center; padding: 0 6px; min-width: 80px; }
.nm-fc-mid-line { display: flex; align-items: center; width: 100%; }
.nm-fc-mid-seg { flex: 1; height: 1px; background: #ccc; }
.nm-fc-mid-dot { width: 5px; height: 5px; border-radius: 50%; background: #ccc; flex-shrink: 0; }
.nm-fc-mid-label { font-size: 10px; color: #888; margin-top: 2px; }
/* Arr block */
.nm-fc-arr { flex-shrink: 0; text-align: right; min-width: 52px; }
/* Time + airport shared styles */
.nm-fc-time { font-size: 15px; font-weight: 700; color: #1a1a1a; display: block; line-height: 1.2; }
.nm-fc-code { font-size: 10px; color: #999; display: block; }
/* Airline name */
.nm-fc-aln { font-size: 11px; color: #555; flex-shrink: 1; min-width: 0; max-width: none; }
/* Price + select */
.nm-fc-price-btn {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    background: #1a1a1a;
    color: #c9a84c;
    border: none;
    border-radius: 8px;
    padding: 6px 12px;
    cursor: pointer;
    text-align: right;
    min-width: 70px;
}
.nm-fc-price-btn:hover { background: #2a2a2a; }
.nm-fc-price-val { font-size: 15px; font-weight: 800; display: block; line-height: 1.2; }
.nm-fc-price-lbl { font-size: 9px; color: #c9a84c; opacity: 0.8; display: block; }

.fl-show-more-btn {
    display:block;width:100%;padding:10px;margin:4px 0 12px;
    background:#f5f7fa;border:1.5px dashed #ccc;border-radius:10px;
    color:#555;font-size:13px;font-weight:600;cursor:pointer;text-align:center;
    transition:background .15s;
}
.fl-show-more-btn:hover { background:#eef0f5; border-color:#bbb; color:#0a1628; }
@media (max-width: 480px) {
    .nm-fc { gap: 7px; padding: 10px 10px; }
    .nm-fc-aln { display:inline-flex; align-items:center; font-size:12px; color:#444; font-weight:500; }
    .nm-fc-mid { min-width: 60px; }
    .nm-fc-time { font-size: 14px; }
    .nm-fc-price-val { font-size: 14px; }
}
.nm-airline-filter{display:flex;flex-wrap:wrap;gap:6px;padding:10px 0 4px;border-top:1px solid #eee;margin-top:8px;}
.nm-af-pill{background:#f4f4f4;border:1.5px solid #ddd;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:600;color:#555;cursor:pointer;transition:all .15s;white-space:nowrap;}
.nm-af-pill:hover{border-color:#c9a84c;color:#c9a84c;}
.nm-af-pill.active{background:#0a1628;border-color:#0a1628;color:#c9a84c;}
.nm-af-count{font-size:10px;opacity:.7;margin-left:2px;}
.nm-al-chip{display:inline-flex;align-items:center;gap:6px;padding:6px 10px;border:1.5px solid #ddd;border-radius:20px;background:#fff;text-decoration:none;cursor:pointer;transition:all .15s;box-shadow:0 1px 3px rgba(0,0,0,.06);}
.nm-al-chip:hover{box-shadow:0 2px 8px rgba(0,0,0,.12);transform:translateY(-1px);}
</style>
@endpush

{{-- ═══════ HERO + SEARCH ═══════ --}}
<div class="fl-hero">
  <div class="container" style="position:relative;z-index:2">
    <div class="text-center mb-4">
      <p style="font-size:11px;letter-spacing:5px;text-transform:uppercase;color:#c9a84c;font-weight:800;margin-bottom:8px;">NOMALY TRAVEL</p>
      <h1 style="font-size:clamp(1.8rem,4vw,3rem);font-weight:900;color:#fff;margin-bottom:6px;line-height:1.1;">Search Flights</h1>
      <p style="color:rgba(255,255,255,0.72);font-size:1rem;margin:0;">Real-time prices from all major US airlines</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-xl-11">
        <div class="nm-gf-box">
          <div style="padding:4px 22px;background:#f7f8fc;border-bottom:1px solid #edf0f7;">
            <div class="fl-partners-inner">
              <small style="font-size:10px;color:#aaa;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">We Fly With:</small>
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/AA.svg" alt="American Airlines" title="American Airlines">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/F9.svg" alt="Frontier" title="Frontier">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/B6.svg" alt="JetBlue" title="JetBlue">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/AS.svg" alt="Alaska" title="Alaska Airlines">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/UA.svg" alt="United" title="United Airlines" style="opacity:.4;filter:grayscale(1)">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/DL.svg" alt="Delta" title="Delta Air Lines" style="opacity:.4;filter:grayscale(1)">
            </div>
          </div>
          <div class="nm-gf-panel">
            <div class="nm-trip-type">
              <label><input type="radio" name="fl_trip" value="oneway" checked> One way</label>
              <label><input type="radio" name="fl_trip" value="twoway"> Round trip</label>
            </div>
            <div class="row g-2 align-items-stretch">
              <div class="col-6 col-md-3">
                <div class="nm-gf-field nm-ac-wrap">
                  <label><i class="fas fa-plane-departure"></i>From</label>
                  <input type="text" id="fl-from" class="fl-ac-input" autocomplete="off" placeholder="e.g. Chicago, JFK…">
                  <input type="hidden" id="fl-from-code">
                  <div class="nm-ac-dropdown" id="fl-from-drop"></div>
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="nm-gf-field nm-ac-wrap">
                  <label><i class="fas fa-plane-arrival"></i>To</label>
                  <input type="text" id="fl-to" class="fl-ac-input" autocomplete="off" placeholder="e.g. Miami, LAX…">
                  <input type="hidden" id="fl-to-code">
                  <div class="nm-ac-dropdown" id="fl-to-drop"></div>
                </div>
              </div>
              <div class="col-6 col-md-2">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar"></i>Depart</label>
                  <input type="date" id="fl-depart" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-6 col-md-2" id="fl-ret-col" style="display:none">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar-check"></i>Return</label>
                  <input type="date" id="fl-return" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="nm-gf-field nm-pax-field" id="fl-pax-wrap">
                  <label><i class="fas fa-users"></i>Passengers</label>
                  <div class="nm-pax-summary" id="fl-pax-summary" onclick="flTogglePax()">1 Adult &#9660;</div>
                  <div class="nm-pax-drop" id="fl-pax-drop">
                    <div class="nm-pax-row">
                      <div><div class="nm-pax-lbl">Adults</div><div class="nm-pax-age">12+ years</div></div>
                      <div class="nm-stepper">
                        <button type="button" class="nm-step-btn" onclick="flPaxStep('fl-adults',-1,event)">&#8722;</button>
                        <input type="number" id="fl-adults" value="1" min="1" max="9" readonly>
                        <button type="button" class="nm-step-btn" onclick="flPaxStep('fl-adults',1,event)">+</button>
                      </div>
                    </div>
                    <div class="nm-pax-row">
                      <div><div class="nm-pax-lbl">Youth</div><div class="nm-pax-age">2&#8211;11 years</div></div>
                      <div class="nm-stepper">
                        <button type="button" class="nm-step-btn" onclick="flPaxStep('fl-youth',-1,event)">&#8722;</button>
                        <input type="number" id="fl-youth" value="0" min="0" max="8" readonly>
                        <button type="button" class="nm-step-btn" onclick="flPaxStep('fl-youth',1,event)">+</button>
                      </div>
                    </div>
                    <div class="nm-pax-row">
                      <div><div class="nm-pax-lbl">Infants</div><div class="nm-pax-age">Under 2 (lap)</div></div>
                      <div class="nm-stepper">
                        <button type="button" class="nm-step-btn" onclick="flPaxStep('fl-infants',-1,event)">&#8722;</button>
                        <input type="number" id="fl-infants" value="0" min="0" max="4" readonly>
                        <button type="button" class="nm-step-btn" onclick="flPaxStep('fl-infants',1,event)">+</button>
                      </div>
                    </div>
                    <button type="button" class="nm-pax-done" onclick="flClosePax()">Done &#10003;</button>
                  </div>
                </div>
              </div>
              <div class="col-4 col-md-1">
                <div class="nm-gf-field">
                  <label>Cabin</label>
                  <select id="fl-cabin">
                    <option value="economy">Economy</option>
                    <option value="premium_economy">Premium Economy</option>
                    <option value="business">Business</option>
                    <option value="first">First</option>
                  </select>
                </div>
              </div>
              <div class="col-4 col-md-auto d-flex align-items-stretch" style="min-width:140px">
                <button type="button" class="nm-gf-btn" id="fl-search-btn" onclick="flSearch()">
                  <i class="fas fa-search"></i> Search
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- ═══════ RESULTS ═══════ --}}
<div id="fl-results" style="display:none">
  <div class="container py-5">
    <div id="fl-results-inner"></div>
  </div>
</div>

{{-- ═══════ POPULAR ROUTES ═══════ --}}
<section class="nm-popular-routes" id="nm-pop-routes">
  <div class="container">
    <h3 class="nm-pop-title">Popular US Routes</h3>
    <p class="nm-pop-sub">Tap a route to instantly search flights</p>
    <div class="row g-3">
      <div class="col-6 col-md-4">
        <div class="nm-route-card" onclick="flPickRoute('JFK','MIA','New York','Miami')">
          <div class="nm-route-from">New York JFK &rarr; Miami MIA</div>
          <div class="nm-route-arrow">&#9992;</div>
          <div class="nm-route-cities">New York &rarr; Miami</div>
          <div class="nm-route-price">From $89</div>
          <div class="nm-route-from-badge">Non-stop available</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="nm-route-card" onclick="flPickRoute('LAX','LAS','Los Angeles','Las Vegas')">
          <div class="nm-route-from">Los Angeles LAX &rarr; Las Vegas LAS</div>
          <div class="nm-route-arrow">&#9992;</div>
          <div class="nm-route-cities">Los Angeles &rarr; Las Vegas</div>
          <div class="nm-route-price">From $49</div>
          <div class="nm-route-from-badge">Under 1 hour flight</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="nm-route-card" onclick="flPickRoute('ORD','MCO','Chicago','Orlando')">
          <div class="nm-route-from">Chicago ORD &rarr; Orlando MCO</div>
          <div class="nm-route-arrow">&#9992;</div>
          <div class="nm-route-cities">Chicago &rarr; Orlando</div>
          <div class="nm-route-price">From $79</div>
          <div class="nm-route-from-badge">Non-stop available</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="nm-route-card" onclick="flPickRoute('DFW','DEN','Dallas','Denver')">
          <div class="nm-route-from">Dallas DFW &rarr; Denver DEN</div>
          <div class="nm-route-arrow">&#9992;</div>
          <div class="nm-route-cities">Dallas &rarr; Denver</div>
          <div class="nm-route-price">From $69</div>
          <div class="nm-route-from-badge">Non-stop available</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="nm-route-card" onclick="flPickRoute('ATL','JFK','Atlanta','New York')">
          <div class="nm-route-from">Atlanta ATL &rarr; New York JFK</div>
          <div class="nm-route-arrow">&#9992;</div>
          <div class="nm-route-cities">Atlanta &rarr; New York</div>
          <div class="nm-route-price">From $99</div>
          <div class="nm-route-from-badge">Multiple airlines</div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="nm-route-card" onclick="flPickRoute('BOS','MIA','Boston','Miami')">
          <div class="nm-route-from">Boston BOS &rarr; Miami MIA</div>
          <div class="nm-route-arrow">&#9992;</div>
          <div class="nm-route-cities">Boston &rarr; Miami</div>
          <div class="nm-route-price">From $109</div>
          <div class="nm-route-from-badge">Great winter escape</div>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- ═══════ INLINE BOOKING (hidden, cloned per flight) ═══════ --}}
<div id="fl-booking-tpl" style="display:none">
  <div class="nm-inline-booking open">
    <div class="nm-inline-hdr">
      <h5><i class="fas fa-ticket-alt me-2"></i>Complete Your Booking</h5>
      <button class="nm-inline-close" onclick="flCloseBooking(this)">&times;</button>
    </div>
    <div class="nm-inline-body">
      <div class="nm-inline-summary">
        <div>
          <div class="nm-inline-route" data-bind="route"></div>
          <div class="nm-inline-details" data-bind="details"></div>
        </div>
        <div class="nm-inline-price" data-bind="price"></div>
      </div>

      {{-- Seat Map Section --}}
      <div class="nm-seat-section">
        <h6><i class="fas fa-chair me-1" style="color:#c9a84c;"></i>Pick Your Seat <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#999;">(optional)</span></h6>
        <div class="nm-seat-legend">
          <div class="nm-seat-legend-item"><div class="nm-seat-dot available"></div> Available</div>
          <div class="nm-seat-legend-item"><div class="nm-seat-dot taken"></div> Taken</div>
          <div class="nm-seat-legend-item"><div class="nm-seat-dot selected"></div> Selected</div>
        </div>
        <div class="nm-seat-map" data-bind="seatmap">
          <div class="nm-seat-loading"><i class="fas fa-circle-notch fa-spin me-2" style="color:#c9a84c;"></i>Loading seat map…</div>
        </div>
        <div class="nm-seat-selected-info" data-bind="seatinfo">
          <i class="fas fa-chair me-2"></i>Seat <strong data-bind="seatnum"></strong> selected
          <button type="button" style="background:none;border:none;color:#c9a84c;font-size:12px;margin-left:12px;cursor:pointer;" onclick="flClearSeat(this)">Change</button>
        </div>
        <button type="button" class="nm-seat-skip" onclick="flSkipSeat(this)">Skip seat selection →</button>
      </div>

      <div class="fl-book-form" style="display:none">
        <p style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;color:#0a1628;margin-bottom:12px;">Passenger Details</p>
        <div class="row g-2">
          <div class="col-6"><div class="nm-df"><label>First Name *</label><input type="text" class="bk-fn" placeholder="John" required></div></div>
          <div class="col-6"><div class="nm-df"><label>Last Name *</label><input type="text" class="bk-ln" placeholder="Smith" required></div></div>
        </div>
        <div class="nm-df"><label>Email *</label><input type="email" class="bk-em" placeholder="john@example.com" required></div>
        <div class="nm-df"><label>Phone</label><input type="tel" class="bk-ph" placeholder="+1 (555) 000-0000"></div>
        <p style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;color:#0a1628;margin:18px 0 12px;">Payment</p>
        <div class="nm-df"><label>Card Details *</label><div class="fl-card-el" style="padding:12px 14px;border:1.5px solid #e2e8f4;border-radius:10px;"></div><div class="fl-card-err" style="color:#e53935;font-size:13px;margin-top:6px;min-height:18px;"></div></div>
        <div class="fl-book-msg"></div>
        <button type="button" class="nm-pay-btn fl-pay-btn"><i class="fas fa-lock me-2"></i> Pay &amp; Confirm Booking</button>
        <p style="text-align:center;font-size:11px;color:#bbb;margin-top:10px;"><i class="fas fa-shield-alt"></i> Secured by Stripe · SSL Encrypted</p>
      </div>
    </div>
  </div>
</div>

@push('js')
<script>
/* ═══════════════════════════════════════════════════════
   NOMALY TRAVEL — Flights Page JS
═══════════════════════════════════════════════════════ */

// ── Passenger selector ──
function flTogglePax() {
    var d = document.getElementById('fl-pax-drop');
    if (d) d.classList.toggle('open');
}
function flClosePax() {
    var d = document.getElementById('fl-pax-drop');
    if (d) d.classList.remove('open');
}
function flPaxStep(id, delta, e) {
    if (e) { e.stopPropagation(); e.preventDefault(); }
    var el = document.getElementById(id);
    if (!el) return;
    var mn = parseInt(el.min)||0, mx = parseInt(el.max)||9;
    el.value = Math.min(mx, Math.max(mn, parseInt(el.value||0) + delta));
    // Adults must be >= 1
    var adEl = document.getElementById('fl-adults');
    if (adEl && parseInt(adEl.value) < 1) adEl.value = 1;
    // Infants cannot exceed adults
    var infEl = document.getElementById('fl-infants');
    if (infEl && adEl && parseInt(infEl.value) > parseInt(adEl.value)) infEl.value = adEl.value;
    flUpdatePaxSummary();
}
function flUpdatePaxSummary() {
    var ad  = parseInt((document.getElementById('fl-adults')  || {value:1}).value) || 1;
    var yt  = parseInt((document.getElementById('fl-youth')   || {value:0}).value) || 0;
    var inf = parseInt((document.getElementById('fl-infants') || {value:0}).value) || 0;
    var parts = [];
    parts.push(ad + (ad === 1 ? ' Adult' : ' Adults'));
    if (yt  > 0) parts.push(yt  + ' Youth');
    if (inf > 0) parts.push(inf + (inf === 1 ? ' Infant' : ' Infants'));
    var s = document.getElementById('fl-pax-summary');
    if (s) s.innerHTML = parts.join(', ') + ' &#9660;';
}
// Close on outside click
document.addEventListener('click', function(e) {
    var wrap = document.getElementById('fl-pax-wrap');
    var drop = document.getElementById('fl-pax-drop');
    if (drop && drop.classList.contains('open') && wrap && !wrap.contains(e.target)) {
        drop.classList.remove('open');
    }
});

// ── Popular route pre-fill ──
function flPickRoute(from, to, fromCity, toCity) {
    var fromEl = document.getElementById('fl-from');
    var toEl   = document.getElementById('fl-to');
    var fromCode = document.getElementById('fl-from-code');
    var toCode   = document.getElementById('fl-to-code');
    if (fromEl) fromEl.value = fromCity + ' ' + from;
    if (toEl)   toEl.value   = toCity   + ' ' + to;
    if (fromCode) fromCode.value = from;
    if (toCode)   toCode.value   = to;
    document.querySelector('.nm-gf-box').scrollIntoView({behavior:'smooth', block:'center'});
    setTimeout(function() {
        var dep = document.getElementById('fl-depart');
        if (dep && !dep.value) {
            var d = new Date(); d.setDate(d.getDate()+14);
            dep.value = d.toISOString().split('T')[0];
        }
    }, 300);
}

// ── Trip type toggle ──
document.querySelectorAll('input[name="fl_trip"]').forEach(function(r){
    r.addEventListener('change', function(){
        document.getElementById('fl-ret-col').style.display = this.value==='twoway' ? '' : 'none';
    });
});

// ── Escape HTML ──
function flEsc(s){ return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

// ── Airport Autocomplete (same logic as homepage) ──
var FL_FLAGS = {
    'United States':'🇺🇸','Canada':'🇨🇦','Mexico':'🇲🇽','United Kingdom':'🇬🇧',
    'France':'🇫🇷','Germany':'🇩🇪','Spain':'🇪🇸','Italy':'🇮🇹','Australia':'🇦🇺',
    'Japan':'🇯🇵','China':'🇨🇳','Singapore':'🇸🇬','United Arab Emirates':'🇦🇪',
    'India':'🇮🇳','Brazil':'🇧🇷','Dominican Republic':'🇩🇴','Jamaica':'🇯🇲'
};
function flGetFlag(c){ return FL_FLAGS[c]||'✈️'; }
function flIATA(raw){
    var v=(raw||'').trim().toUpperCase();
    if(/^[A-Z]{3}$/.test(v)) return v;
    var m=v.match(/\b([A-Z]{3})\b(?:\s*[\(\)][^)]*\)?\s*)*$/); if(m) return m[1];
    m=v.match(/\(([A-Z]{3})\)/); if(m) return m[1];
    return '';
}

function flSetupAC(inputId, codeId, dropId) {
    var inp=document.getElementById(inputId), cod=document.getElementById(codeId), drop=document.getElementById(dropId);
    if(!inp||!cod||!drop) return;
    var debounce, activeIdx=-1;
    function closeAC(){ drop.classList.remove('open'); activeIdx=-1; }
    function selectItem(code, label){ inp.value=label; cod.value=code; closeAC(); }
    function bindItems(){
        drop.querySelectorAll('.nm-ac-item[data-code]').forEach(function(el){
            el.addEventListener('mousedown',function(e){ e.preventDefault(); selectItem(this.dataset.code,this.dataset.label); });
            el.addEventListener('touchstart',function(e){ e.preventDefault(); selectItem(this.dataset.code,this.dataset.label); },{passive:false});
        });
    }
    function setActive(idx){
        var items=drop.querySelectorAll('.nm-ac-item[data-code]');
        items.forEach(function(el){el.classList.remove('active');});
        if(idx>=0&&idx<items.length){items[idx].classList.add('active');items[idx].scrollIntoView({block:'nearest'});}
        activeIdx=idx;
    }
    function fetchAndRender(q){
        drop.innerHTML='<div class="nm-ac-no-results"><i class="fas fa-circle-notch fa-spin" style="color:#c9a84c;margin-right:8px;"></i>Searching airports…</div>';
        drop.classList.add('open');
        fetch('/api/airports?q='+encodeURIComponent(q))
        .then(function(r){return r.json();})
        .then(function(data){
            if(!data||!data.length){
                drop.innerHTML='<div class="nm-ac-no-results">No airports found — type a city or IATA code</div>';
                drop.classList.add('open'); return;
            }
            var html=''; var ai=0;
            data.forEach(function(r){
                if(r.type==='city') return;
                var flag=flGetFlag(r.country);
                html+='<div class="nm-ac-item" data-code="'+r.code+'" data-label="'+(r.city||r.name).replace(/"/g,'&quot;')+' ('+r.code+')" data-idx="'+ai+'">'
                    +'<span class="nm-ac-icon nm-ac-icon-apt">'+flag+'</span>'
                    +'<span class="nm-ac-text"><div class="nm-ac-name">'+flEsc(r.city||r.name)+'</div>'
                    +'<div class="nm-ac-sub">'+flEsc(r.name)+(r.country?' &bull; '+flEsc(r.country):'')+'</div></span>'
                    +'<span class="nm-ac-code">'+r.code+'</span></div>';
                ai++;
            });
            if(!html) html='<div class="nm-ac-no-results">No results — try typing differently</div>';
            drop.innerHTML=html; drop.classList.add('open'); bindItems(); activeIdx=-1;
        })
        .catch(function(){
            drop.innerHTML='<div class="nm-ac-no-results">Could not load. Type an IATA code directly (e.g. ORD)</div>';
            drop.classList.add('open');
        });
    }
    inp.addEventListener('input',function(){
        clearTimeout(debounce); cod.value='';
        var q=this.value.trim(); if(q.length<1){closeAC();return;}
        debounce=setTimeout(function(){fetchAndRender(q);},220);
    });
    inp.addEventListener('keydown',function(e){
        if(!drop.classList.contains('open')) return;
        var items=drop.querySelectorAll('.nm-ac-item[data-code]');
        if(e.key==='ArrowDown'){e.preventDefault();setActive(Math.min(activeIdx+1,items.length-1));}
        else if(e.key==='ArrowUp'){e.preventDefault();setActive(Math.max(activeIdx-1,0));}
        else if(e.key==='Enter'){if(activeIdx>=0&&items[activeIdx]){e.preventDefault();selectItem(items[activeIdx].dataset.code,items[activeIdx].dataset.label);}}
        else if(e.key==='Escape'){closeAC();}
    });
    inp.addEventListener('blur',function(){
        setTimeout(function(){ if(!cod.value){var c=flIATA(inp.value);if(c)cod.value=c;} closeAC(); },160);
    });
    inp.addEventListener('focus',function(){
        var q=this.value.trim(); if(q.length>=1&&!cod.value) fetchAndRender(q);
    });
}
flSetupAC('fl-from','fl-from-code','fl-from-drop');
flSetupAC('fl-to','fl-to-code','fl-to-drop');

// ── Results helpers ──
function flShowResults(html, animate){
    var outer=document.getElementById('fl-results'), inner=document.getElementById('fl-results-inner');
    inner.classList.remove('nm-visible'); inner.innerHTML=html;
    outer.style.display='';
    requestAnimationFrame(function(){ requestAnimationFrame(function(){
        inner.classList.add('nm-visible');
        if(animate!==false){setTimeout(function(){var top=outer.getBoundingClientRect().top+window.pageYOffset-80;window.scrollTo({top:top,behavior:'smooth'});},120);}
    });});
}
function flLoading(msg){
    flShowResults('<div class="nm-loading"><div class="nm-spinner"></div><p>'+(msg||'Searching…')+'</p></div>',false);
    document.getElementById('fl-results').style.display='';
    document.getElementById('fl-results-inner').classList.add('nm-visible');
    document.getElementById('fl-results').scrollIntoView({behavior:'smooth',block:'start'});
}
function flError(msg){ flShowResults('<div class="nm-alert-err mt-2"><i class="fas fa-exclamation-circle me-2"></i>'+msg+'</div>'); }
function flNone(msg){ flShowResults('<div class="text-center py-5"><i class="fas fa-search fa-3x mb-3 d-block" style="color:#c9a84c;"></i><p style="color:#666;font-size:15px;font-weight:600;">'+msg+'</p></div>'); }

// ── Formatting ──
function flParseDur(iso){ if(!iso) return 0; var m=iso.match(/PT(?:(\d+)H)?(?:(\d+)M)?/); return m?(parseInt(m[1]||0)*60+parseInt(m[2]||0)):0; }
function flFmtTime(iso){ if(!iso) return ''; try{return new Date(iso).toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit',hour12:true});}catch(e){return '';} }
function flFmtDate(s){ try{var d=new Date(s+'T12:00:00');return d.toLocaleDateString('en-US',{weekday:'short',month:'short',day:'numeric'});}catch(e){return s;} }

var FL_US_PRIORITY={AA:1,F9:2,B6:4,AS:5,UA:6,DL:7,WN:8,G4:9,SY:10};
var FL_HAS_LOGO={AA:1,AS:1,B6:1,DL:1,F9:1,G4:1,HA:1,SY:1,UA:1,WN:1,BA:1,LH:1,AF:1,KL:1,IB:1,EK:1,QR:1,SQ:1,AC:1,QF:1,LA:1,AM:1};

function flSortPriority(a,b){
    var ia=(a.owner&&a.owner.iata_code)?a.owner.iata_code.toUpperCase():'';
    var ib=(b.owner&&b.owner.iata_code)?b.owner.iata_code.toUpperCase():'';
    var pa=FL_US_PRIORITY[ia]||99,pb=FL_US_PRIORITY[ib]||99;
    if(pa!==pb) return pa-pb;
    return parseFloat(a.total_amount||9999)-parseFloat(b.total_amount||9999);
}

// ── Main Search ──
var _flSearchTimer=null;
function flDebouncedSearch(d){clearTimeout(_flSearchTimer);_flSearchTimer=setTimeout(function(){flSearch(d);},350);}
function flSearch(overrideDate){
    var fromEl=document.getElementById('fl-from'), toEl=document.getElementById('fl-to');
    var fromCode=document.getElementById('fl-from-code'), toCode=document.getElementById('fl-to-code');
    if(fromEl&&fromCode){var c=flIATA(fromEl.value);if(c)fromCode.value=c;}
    if(toEl&&toCode){var c2=flIATA(toEl.value);if(c2)toCode.value=c2;}
    var from=(fromCode&&fromCode.value)||flIATA(fromEl?fromEl.value:'');
    var to=(toCode&&toCode.value)||flIATA(toEl?toEl.value:'');
    var depart=overrideDate||(document.getElementById('fl-depart')?document.getElementById('fl-depart').value:'');
    var ret=document.getElementById('fl-return')?document.getElementById('fl-return').value:'';
    var adults  = parseInt((document.getElementById('fl-adults')  || {value:'1'}).value)  || 1;
    var youth   = parseInt((document.getElementById('fl-youth')   || {value:'0'}).value)  || 0;
    var infants = parseInt((document.getElementById('fl-infants') || {value:'0'}).value)  || 0;
    var cabin=document.getElementById('fl-cabin')?document.getElementById('fl-cabin').value:'economy';
    var tripEl=document.querySelector('input[name="fl_trip"]:checked');
    var trip=tripEl?tripEl.value:'oneway';

    if(!from||!to){alert('Please enter airports in the From and To fields.');if(fromEl)fromEl.focus();return;}
    if(!depart){alert('Please select a departure date.');document.getElementById('fl-depart').focus();return;}

    // Button spinner
    var btn=document.getElementById('fl-search-btn');
    if(btn&&!overrideDate){btn.innerHTML='<i class="fas fa-circle-notch fa-spin"></i> Searching…';btn.disabled=true;setTimeout(function(){btn.innerHTML='<i class="fas fa-search"></i> Search';btn.disabled=false;},8000);}

    window._flCtx={from:from,to:to,depart:depart,adults:adults,youth:youth,infants:infants,cabin:cabin,trip:trip};
    flLoading('Searching all airlines: '+from+' → '+to+' …');

    var qs='slices[0][from]='+encodeURIComponent(from)
        +'&slices[0][to]='+encodeURIComponent(to)
        +'&slices[0][departure_date]='+encodeURIComponent(depart)
        +'&adults='+encodeURIComponent(adults)
        +'&cabin_class='+encodeURIComponent(cabin)
        +'&triptype='+encodeURIComponent(trip);
    qs+='&youth='+encodeURIComponent(youth)+'&infants='+encodeURIComponent(infants);
    if(trip==='twoway'&&ret) qs+='&return_date='+encodeURIComponent(ret);

    if(window._flAbortCtrl) window._flAbortCtrl.abort();
    window._flAbortCtrl = new AbortController();
    var signal = window._flAbortCtrl.signal;
    fetch('/api/home/flights?'+qs,{headers:{'X-Requested-With':'XMLHttpRequest'},signal:signal})
    .then(function(r){return r.json();})
    .then(function(data){
        if(btn){btn.innerHTML='<i class="fas fa-search"></i> Search';btn.disabled=false;}
        if(data&&data.error){flError(data.error);return;}
        var offers=Array.isArray(data)?data:(data.offers||data.data||[]);
        window._flOffers=offers;
        window._tpOffers=data.tp_offers||[];
        flRenderFlights(offers,from,to,depart);
        flRenderTPFlights(window._tpOffers,from,to,depart);
    })
    .catch(function(e){
        if(btn){btn.innerHTML='<i class="fas fa-search"></i> Search';btn.disabled=false;}
        if(e.name==='AbortError') return; flError('Search error: '+(e.message||'network error'));
    });
}

// ── Price Calendar ──
function flBuildPriceCalendar(from,to,depart){
    var base=new Date(depart+'T12:00:00'), pills='';
    for(var i=-3;i<=3;i++){
        var d=new Date(base); d.setDate(d.getDate()+i);
        var ds=d.toISOString().split('T')[0];
        var today=new Date(); today.setHours(0,0,0,0);
        if(d<today) continue;
        var dayName=d.toLocaleDateString('en-US',{weekday:'short'});
        var dateDisp=d.toLocaleDateString('en-US',{month:'short',day:'numeric'});
        var isSel=(ds===depart);
        pills+='<div class="nm-date-pill'+(isSel?' nm-dp-sel':'')+'" id="fldp-'+ds+'" onclick="flDebouncedSearch(\''+ds+'\')">'
            +'<div class="nm-dp-day">'+dayName+'</div>'
            +'<div class="nm-dp-dt">'+dateDisp+'</div>'
            +'<div class="nm-dp-price loading" id="fldpp-'+ds+'">•••</div></div>';
    }
    return '<div class="nm-price-cal"><h6><i class="fas fa-calendar-alt me-1" style="color:#c9a84c;"></i>Compare prices by date</h6><div class="nm-date-strip">'+pills+'</div></div>';
}

function flFetchNearbyPrices(from,to,depart){
    var base=new Date(depart+'T12:00:00'), today=new Date(); today.setHours(0,0,0,0);
    var dates=[];
    for(var i=-3;i<=3;i++){var d=new Date(base);d.setDate(d.getDate()+i);if(d>=today)dates.push(d.toISOString().split('T')[0]);}
    var adults=(window._flCtx&&window._flCtx.adults)||'1';
    var cabin=(window._flCtx&&window._flCtx.cabin)||'economy';
    dates.forEach(function(ds,idx){
        setTimeout(function(){
            var el=document.getElementById('fldpp-'+ds); if(!el) return;
            var qs='slices[0][from]='+encodeURIComponent(from)+'&slices[0][to]='+encodeURIComponent(to)+'&slices[0][departure_date]='+encodeURIComponent(ds)+'&adults='+adults+'&cabin_class='+cabin+'&triptype=oneway';
            fetch('/api/home/flights?'+qs,{headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(function(r){return r.json();})
            .then(function(data){
                if(!el) return;
                var offers=Array.isArray(data)?data:(data.offers||data.data||[]);
                if(!offers||!offers.length){el.textContent='N/A';el.classList.remove('loading');return;}
                var best=Math.min.apply(null,offers.map(function(o){return parseFloat(o.total_amount||999999);}));
                el.textContent='$'+Math.floor(best); el.classList.remove('loading');
            })
            .catch(function(){if(el){el.textContent='—';el.classList.remove('loading');}});
        },idx*1200);
    });
}

// ── Render Flights ──
function flRenderFlights(offers,from,to,depart){
    if(!offers||offers.length===0){
        flNone('No flights found for <strong>'+from+' → '+to+'</strong> on '+flFmtDate(depart));
        return;
    }
    var sorted=offers.slice().sort(function(a,b){return parseFloat(a.total_amount||9999)-parseFloat(b.total_amount||9999);});
    var airlineMap={};
    sorted.forEach(function(o){
        var name=(o.owner&&o.owner.name)||'Unknown';
        airlineMap[name]=(airlineMap[name]||0)+1;
    });
    var alCount=Object.keys(airlineMap).length;
    window._flActiveAirline=null;

    var html='<div class="nm-results-hdr">'
        +'<h4 class="nm-results-title"><span style="color:#c9a84c;">'+from+'</span>'
        +' <i class="fas fa-long-arrow-alt-right" style="color:#c9a84c;font-size:13px;margin:0 8px;"></i>'
        +'<span style="color:#c9a84c;">'+to+'</span></h4>'
        +'<div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">'
        +'<span style="font-size:13px;color:#888;"><strong style="color:#0a1628;">'+offers.length+'</strong> flights &bull; <strong style="color:#0a1628;">'+alCount+'</strong> airline'+(alCount!==1?'s':'')+' &bull; '+flFmtDate(depart)+'</span>'
        +'<div class="nm-sort-bar"><span>Sort:</span>'
        +'<button type="button" class="nm-sort-btn" onclick="flSortFlights(\'us\',this)">US first</button>'
        +'<button type="button" class="nm-sort-btn active" onclick="flSortFlights(\'price\',this)">Cheapest</button>'
        +'<button type="button" class="nm-sort-btn" onclick="flSortFlights(\'dur\',this)">Shortest</button>'
        +'<button type="button" class="nm-sort-btn" onclick="flSortFlights(\'stops\',this)">Nonstop first</button>'
        +'</div></div></div>';

    // Airline filter pills
    var pillsHtml='<div class="nm-airline-filter" id="nm-airline-filter"><button type="button" class="nm-af-pill active" onclick="flFilterAirline(null,this)">All</button>';
    Object.keys(airlineMap).sort().forEach(function(n){
        pillsHtml+='<button type="button" class="nm-af-pill" onclick="flFilterAirline('+JSON.stringify(n)+',this)">'+n+' <span class="nm-af-count">'+airlineMap[n]+'</span></button>';
    });
    pillsHtml+='</div>';
    html+=pillsHtml;

    html+=flBuildPriceCalendar(from,to,depart);
    html+='<div id="fl-list"></div>';
    if(!window._flCardData) window._flCardData={};
    flShowResults(html);
    var _grpList=document.getElementById('fl-list');
    if(_grpList) flRenderGrouped(sorted,_grpList);
    setTimeout(function(){flFetchNearbyPrices(from,to,depart);},600);
}

function flFilterAirline(name,btn){
    window._flActiveAirline=name;
    document.querySelectorAll('.nm-af-pill').forEach(function(b){b.classList.remove('active');});
    if(btn) btn.classList.add('active');
    var src=window._flOffers||[];
    var filtered=name?src.filter(function(o){return ((o.owner&&o.owner.name)||'Unknown')===name;}):src;
    var list=document.getElementById('fl-list');
    if(list){ flRenderGrouped(filtered,list); }
    if(!name&&window._tpOffers!==undefined&&window._flCtx) flRenderTPFlights(window._tpOffers,window._flCtx.from,window._flCtx.to,window._flCtx.depart);
}

function flFlightCard(offer){
            if(!offer||!offer.slices||!offer.slices[0])return'';
            const sl=offer.slices[0], segs=sl.segments||[], seg=segs[0]||{};
            const lastSeg=segs.length>1?segs[segs.length-1]:seg;
            const oc=seg.operating_carrier||{};
            const owner=offer.owner||{};
            const iata=((oc.iata_code||owner.iata_code||'')).toUpperCase();
            const airlineNames={'F9':'Frontier','AA':'American','UA':'United','DL':'Delta','WN':'Southwest','B6':'JetBlue','AS':'Alaska','G4':'Allegiant','SY':'Sun Country','HA':'Hawaiian','MX':'Breeze','VX':'Virgin America'};
            const ownerIata=(offer.owner&&offer.owner.iata_code)||'';
            const ownerName=(offer.owner&&offer.owner.name)||airlineNames[ownerIata]||ownerIata||'';
            const airlineName=oc.name||ownerName||airlineNames[iata]||iata||'Unknown';
            const depTime=flFmtTime(seg.departing_at);
            const arrTime=flFmtTime(lastSeg.arriving_at);
            let dur=0;
            if(sl.duration){const dm=sl.duration.match(/PT(?:(\d+)H)?(?:(\d+)M)?/);if(dm)dur=parseInt(dm[1]||0)*60+parseInt(dm[2]||0);}
            if(!dur&&seg.departing_at&&lastSeg.arriving_at)dur=Math.round((new Date(lastSeg.arriving_at)-new Date(seg.departing_at))/60000);
            const duration=dur?`${Math.floor(dur/60)}h ${dur%60}m`:'';
            const stops=segs.length>0?segs.length-1:0;
            const stopsLabel=stops===0?'Nonstop':`${stops} stop${stops>1?'s':''}`;
            const origin=(seg.origin||{}).iata_code||'';
            const destination=(lastSeg.destination||{}).iata_code||'';
            const amt=parseFloat(offer.total_amount||0);
            const cur=offer.total_currency||'USD';
            const price=cur==='USD'?`$${amt.toFixed(0)}`:`${amt.toFixed(0)} ${cur}`;
            const uid=offer.id||('unk'+Math.random().toString(36).slice(2));
            const logoHtml=iata?`<img class="nm-fc-logo" src="https://pics.avs.io/40/40/${iata}.png" onerror="this.style.display='none'" alt="${iata}">`:'';
            const midLabel=duration&&stopsLabel?`${duration} &middot; ${stopsLabel}`:(duration||stopsLabel||'');
            window._flCardData[uid]={offerId:uid,amt:amt,cur:cur,from:origin,to:destination,aln:airlineName,dep:depTime,arr:arrTime,stops:stops};
            return `<div class="nm-fc ${stops===0?'nonstop':'with-stops'}" data-uid="${uid}">
                ${logoHtml}
                <div class="nm-fc-dep">
                    <span class="nm-fc-time">${depTime}</span>
                    <span class="nm-fc-code">${origin}</span>
                </div>
                <div class="nm-fc-mid">
                    <div class="nm-fc-mid-line">
                        <span class="nm-fc-mid-seg"></span>
                        <span class="nm-fc-mid-dot"></span>
                        <span class="nm-fc-mid-seg"></span>
                    </div>
                    <span class="nm-fc-mid-label">${midLabel}</span>
                </div>
                <div class="nm-fc-arr">
                    <span class="nm-fc-time">${arrTime}</span>
                    <span class="nm-fc-code">${destination}</span>
                </div>
                <span class="nm-fc-aln">${flEsc(airlineName)}</span>
                <button class="nm-fc-price-btn" data-uid="${uid}" type="button">
                    <span class="nm-fc-price-val">${price}</span>
                    <span class="nm-fc-price-lbl">Select &#8594;</span>
                </button>
                <div class="fl-booking-container" id="bkc-${uid}" style="display:none;padding:10px 0 0;width:100%"></div>
            </div>`;
        }

var FL_PER_AIRLINE=5;

function flRenderGrouped(offers,list){
    var groups={},order=[];
    offers.forEach(function(o){
        var n=(o.owner&&o.owner.name)||'Unknown';
        if(!groups[n]){groups[n]=[];order.push(n);}
        groups[n].push(o);
    });
    var html='';
    order.forEach(function(name){
        var flights=groups[name];
        var show=flights.slice(0,FL_PER_AIRLINE);
        var rest=flights.slice(FL_PER_AIRLINE);
        html+='<div class="fl-airline-group">';
        show.forEach(function(o){html+=flFlightCard(o);});
        if(rest.length>0){
            var hiddenHtml='';
            rest.forEach(function(o){hiddenHtml+=flFlightCard(o);});
            html+='<div class="fl-more-flights" style="display:none;">'+hiddenHtml+'</div>';
            html+='<button type="button" class="fl-show-more-btn" onclick="flShowMore(this)">'
                +'<i class="fas fa-chevron-down me-1"></i>Show '+rest.length+' more '+flEsc(name)+' flights'
                +'</button>';
        }
        html+='</div>';
    });
    list.innerHTML=html;
}

function flShowMore(btn){
    var hidden=btn.previousElementSibling;
    hidden.style.display='';
    btn.style.display='none';
}

function flSortFlights(by,btn){
    document.querySelectorAll('.nm-sort-btn').forEach(function(b){b.classList.remove('active');});
    if(btn) btn.classList.add('active');
    var s=(window._flOffers||[]).slice();
    if(by==='us') s.sort(flSortPriority);
    else if(by==='price') s.sort(function(a,b){return parseFloat(a.total_amount)-parseFloat(b.total_amount);});
    else if(by==='dur') s.sort(function(a,b){return flParseDur((a.slices[0]||{}).duration||'')-flParseDur((b.slices[0]||{}).duration||'');});
    else if(by==='stops') s.sort(function(a,b){var sa=a.slices&&a.slices[0]&&a.slices[0].segments?a.slices[0].segments.length-1:9,sb=b.slices&&b.slices[0]&&b.slices[0].segments?b.slices[0].segments.length-1:9;return sa!==sb?sa-sb:parseFloat(a.total_amount)-parseFloat(b.total_amount);});
    var list=document.getElementById('fl-list');
    if(list){ flRenderGrouped(s,list); }
    if(window._tpOffers!==undefined&&window._flCtx) flRenderTPFlights(window._tpOffers,window._flCtx.from,window._flCtx.to,window._flCtx.depart);
}

// ── Click delegation for SELECT buttons ──
document.addEventListener('click', function(e){
    var btn=e.target.closest('.nm-fc-price-btn');
    if(!btn) return;
    var uid=btn.dataset.uid;
    var data=window._flCardData&&window._flCardData[uid];
    if(!data) return;
    flOpenBooking(uid, data);
});

// ── Stripe ──
var _flStripe=null, _flStripeCards={};

function _flInitStripe(cardEl, onReady){
    if(!_flStripe){
        if(typeof Stripe!=='undefined'){
            _flStripe=Stripe('{{ config('services.stripe.key') }}');
            var card=_flStripe.elements().create('card',{style:{base:{fontSize:'15px',color:'#0a1628','::placeholder':{color:'#bbb'},fontFamily:'inherit'}}});
            card.mount(cardEl);
            _flStripeCards[cardEl.id||Math.random()]=card;
            if(onReady) onReady(card);
        } else {
            var s=document.createElement('script'); s.src='https://js.stripe.com/v3/';
            s.onload=function(){
                _flStripe=Stripe('{{ config('services.stripe.key') }}');
                var card=_flStripe.elements().create('card',{style:{base:{fontSize:'15px',color:'#0a1628','::placeholder':{color:'#bbb'},fontFamily:'inherit'}}});
                card.mount(cardEl);
                _flStripeCards[cardEl.id||Math.random()]=card;
                if(onReady) onReady(card);
            };
            document.head.appendChild(s);
        }
    } else {
        var card=_flStripe.elements().create('card',{style:{base:{fontSize:'15px',color:'#0a1628','::placeholder':{color:'#bbb'},fontFamily:'inherit'}}});
        card.mount(cardEl);
        if(onReady) onReady(card);
    }
}

// ── Seat Map ──
function flLoadSeatMap(offerId, seatMapEl, seatInfoEl, onSeatPicked){
    seatMapEl.innerHTML='<div class="nm-seat-loading"><i class="fas fa-circle-notch fa-spin me-2" style="color:#c9a84c;"></i>Loading seat map…</div>';
    fetch('/api/seat-map/'+encodeURIComponent(offerId),{headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){return r.json();})
    .then(function(data){
        if(data.error||!data.cabins||!data.cabins.length){
            var sec=seatMapEl.closest('.nm-seat-section');
            if(sec) sec.style.display='none';
            var form=seatMapEl.closest('.nm-inline-body').querySelector('.fl-book-form');
            if(form){form.style.display='block';form.scrollIntoView({behavior:'smooth',block:'nearest'});}
            return;
        }
        flRenderSeatMap(data.cabins, seatMapEl, seatInfoEl, onSeatPicked);
    })
    .catch(function(){
        seatMapEl.innerHTML='<div class="nm-seat-loading" style="color:#aaa;"><i class="fas fa-info-circle me-2"></i>Seat map unavailable — you can still proceed</div>';
    });
}

function flRenderSeatMap(cabins, mapEl, infoEl, onSeatPicked){
    var selectedSeat=null;
    var html='';
    cabins.forEach(function(cabin){
        html+='<div class="nm-seat-cabin-lbl">'+(cabin.cabin_class_marketing_name||cabin.cabin_class||'Cabin')+'</div>';
        (cabin.rows||[]).forEach(function(row){
            html+='<div class="nm-seat-row"><span class="nm-seat-row-num">'+(row.designator||'')+'</span>';
            var seatIdx=0;
            (row.sections||[row]).forEach(function(section, si){
                if(si>0) html+='<div class="nm-seat-gap"></div>';
                var seats=section.elements||section.seats||[];
                seats.forEach(function(seat){
                    if(seat.type==='empty'||seat.type==='lavatory'||seat.type==='galley'){
                        html+='<div class="nm-seat-gap"></div>'; return;
                    }
                    var available=seat.available_services&&seat.available_services.length>0;
                    var taken=!available&&seat.type==='seat';
                    var cls=available?'available':(taken?'taken':'unavailable');
                    var des=seat.designator||'';
                    html+='<button type="button" class="nm-seat '+cls+'" data-designator="'+des+'" data-available="'+(available?'1':'0')+'" '+(available?'':'disabled')+' title="Seat '+des+(available?' — Available':' — Unavailable')+'">'+des+'</button>';
                    seatIdx++;
                });
            });
            html+='</div>';
        });
    });
    mapEl.innerHTML=html;
    // Bind seat clicks
    mapEl.querySelectorAll('.nm-seat.available').forEach(function(btn){
        btn.addEventListener('click',function(){
            mapEl.querySelectorAll('.nm-seat.selected').forEach(function(s){s.classList.remove('selected');});
            this.classList.add('selected');
            selectedSeat=this.dataset.designator;
            infoEl.style.display='block';
            var numEl=infoEl.querySelector('[data-bind="seatnum"]');
            if(numEl) numEl.textContent=selectedSeat;
            if(onSeatPicked) onSeatPicked(selectedSeat);
        });
    });
}

// ── Open Inline Booking ──
var _flOpenBookings={};

function flOpenBooking(uid, data){
    // Close any other open bookings
    document.querySelectorAll('.fl-booking-container').forEach(function(c){ c.style.display='none'; c.innerHTML=''; });

    var container=document.getElementById('bkc-'+uid);
    if(!container) return;
    container.style.display='block';

    // Clone template
    var tpl=document.getElementById('fl-booking-tpl');
    var clone=tpl.firstElementChild.cloneNode(true);
    container.innerHTML=''; container.appendChild(clone);

    // Populate summary
    var pStr=data.cur==='USD'?'$'+data.amt.toFixed(0):data.amt.toFixed(0)+' '+data.cur;
    var stpStr=data.stops===0?'Nonstop':data.stops+' stop'+(data.stops>1?'s':'');
    clone.querySelector('[data-bind="route"]').textContent=data.from+' → '+data.to;
    clone.querySelector('[data-bind="details"]').textContent=data.aln+' · '+data.dep+' – '+data.arr+' · '+stpStr;
    clone.querySelector('[data-bind="price"]').textContent=pStr;

    // Load seat map
    var seatMapEl=clone.querySelector('[data-bind="seatmap"]');
    var seatInfoEl=clone.querySelector('[data-bind="seatinfo"]');
    var selectedSeat=null;
    flLoadSeatMap(uid, seatMapEl, seatInfoEl, function(seat){ selectedSeat=seat; });

    // Skip seat button
    var skipBtn=clone.querySelector('.nm-seat-skip');
    skipBtn.addEventListener('click',function(){ flShowBookingForm(clone, data, uid, function(){ return selectedSeat; }); });

    // Seat info clear
    var clearBtn=clone.querySelector('[onclick="flClearSeat(this)"]');
    if(clearBtn) clearBtn.addEventListener('click',function(e){ e.preventDefault(); selectedSeat=null; seatMapEl.querySelectorAll('.nm-seat.selected').forEach(function(s){s.classList.remove('selected');}); seatInfoEl.style.display='none'; });

    // After seat selected, auto show form after 600ms
    var origOnSeatPicked=function(seat){ selectedSeat=seat; setTimeout(function(){ flShowBookingForm(clone,data,uid,function(){return selectedSeat;}); },600); };
    if(seatMapEl.querySelectorAll) {
        // Re-bind after render
        var observer=new MutationObserver(function(){
            seatMapEl.querySelectorAll('.nm-seat.available').forEach(function(btn){
                if(btn._flBound) return; btn._flBound=true;
                btn.addEventListener('click',function(){
                    seatMapEl.querySelectorAll('.nm-seat.selected').forEach(function(s){s.classList.remove('selected');});
                    this.classList.add('selected');
                    selectedSeat=this.dataset.designator;
                    seatInfoEl.style.display='block';
                    var numEl=seatInfoEl.querySelector('[data-bind="seatnum"]');
                    if(numEl) numEl.textContent=selectedSeat;
                    setTimeout(function(){flShowBookingForm(clone,data,uid,function(){return selectedSeat;});},600);
                });
            });
        });
        observer.observe(seatMapEl,{childList:true,subtree:true});
    }

    container.scrollIntoView({behavior:'smooth',block:'nearest'});
}

function flShowBookingForm(clone, data, uid, getSeat){
    var form=clone.querySelector('.fl-book-form');
    if(!form||form.style.display!=='none') return;
    form.style.display='block';
    form.scrollIntoView({behavior:'smooth',block:'nearest'});

    // Init Stripe card
    var cardEl=form.querySelector('.fl-card-el');
    var cardErrEl=form.querySelector('.fl-card-err');
    var payBtn=form.querySelector('.fl-pay-btn');
    var pStr=data.cur==='USD'?'$'+data.amt.toFixed(0):data.amt.toFixed(0)+' '+data.cur;
    payBtn.innerHTML='<i class="fas fa-lock me-2"></i> Pay '+pStr+' & Confirm';
    var _card=null;
    _flInitStripe(cardEl, function(card){ _card=card; card.on('change',function(e){ cardErrEl.textContent=e.error?e.error.message:''; }); });

    payBtn.addEventListener('click',function(){
        var fn=form.querySelector('.bk-fn').value.trim();
        var ln=form.querySelector('.bk-ln').value.trim();
        var em=form.querySelector('.bk-em').value.trim();
        var ph=form.querySelector('.bk-ph').value.trim();
        var msgEl=form.querySelector('.fl-book-msg');
        if(!fn||!ln||!em){msgEl.innerHTML='<div class="nm-alert-err mb-2">Please fill in all required fields.</div>';return;}
        payBtn.disabled=true; payBtn.innerHTML='<i class="fas fa-spinner fa-spin me-2"></i>Processing…';
        cardErrEl.textContent=''; msgEl.innerHTML='';
        var csrf=document.querySelector('meta[name="csrf-token"]')?document.querySelector('meta[name="csrf-token"]').content:'';
        fetch('/api/flights/payment-intent',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'X-Requested-With':'XMLHttpRequest'},
            body:JSON.stringify({offer_id:uid,amount:data.amt,currency:data.cur})
        })
        .then(function(r){return r.json();})
        .then(function(d){
            if(d.error){msgEl.innerHTML='<div class="nm-alert-err mb-2">'+d.error+'</div>';payBtn.disabled=false;payBtn.innerHTML='<i class="fas fa-lock me-2"></i>Retry';return Promise.reject('pi');}
            return _flStripe.confirmCardPayment(d.clientSecret,{payment_method:{card:_card,billing_details:{name:fn+' '+ln,email:em}}});
        })
        .then(function(res){
            if(!res||res===undefined) return;
            if(res.error){cardErrEl.textContent=res.error.message;payBtn.disabled=false;payBtn.innerHTML='<i class="fas fa-lock me-2"></i>Retry';return Promise.reject('card');}
            return fetch('/api/flights/book',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'X-Requested-With':'XMLHttpRequest'},
                body:JSON.stringify({offer_id:uid,payment_intent_id:res.paymentIntent.id,first_name:fn,last_name:ln,email:em,phone:ph,
                    from:data.from,to:data.to,depart_date:window._flCtx?window._flCtx.depart:'',price:data.amt,currency:data.cur,
                    adults:document.getElementById('fl-adults')?document.getElementById('fl-adults').value:1,
                    seat:getSeat?getSeat():null})});
        })
        .then(function(r){if(r&&typeof r.json==='function') return r.json();})
        .then(function(bk){
            if(!bk) return;
            if(bk.success){
                form.innerHTML='<div class="nm-alert-ok text-center" style="padding:30px;"><i class="fas fa-check-circle fa-3x d-block mb-3" style="color:#27ae60;"></i><h5 style="font-weight:900;color:#0a1628;">Booking Confirmed!</h5><p>Thank you, '+flEsc(fn)+'! Ref: <strong>'+(bk.reference||'#'+bk.booking_id)+'</strong></p><p style="font-size:13px;color:#666;">Confirmation sent to '+flEsc(em)+'</p></div>';
            } else {
                msgEl.innerHTML='<div class="nm-alert-err mb-2">'+(bk.error||'Booking failed.')+'</div>';
                payBtn.disabled=false;payBtn.innerHTML='<i class="fas fa-lock me-2"></i>Retry';
            }
        })
        .catch(function(err){if(err==='pi'||err==='card') return; msgEl.innerHTML='<div class="nm-alert-err mb-2">Payment error. Please try again.</div>';payBtn.disabled=false;payBtn.innerHTML='<i class="fas fa-lock me-2"></i>Retry';});
    });
}


// Travelpayouts: United, Delta, Southwest
function flRenderTPFlights(tpOffers,from,to,depart){
    var list=document.getElementById("fl-list");
    if(!list) return;
    var prev=document.getElementById("tp-section");
    if(prev) prev.remove();
    var knownAirlines={
        "UA":"United Airlines","DL":"Delta Air Lines","AA":"American Airlines",
        "WN":"Southwest Airlines","B6":"JetBlue","AS":"Alaska Airlines",
        "F9":"Frontier","G4":"Allegiant","NK":"Spirit","HA":"Hawaiian"
    };
    var highlight={"UA":1,"DL":1};

    var cards="";
    (tpOffers||[]).forEach(function(f){
        var code=(f.airline||"").toUpperCase();
        var name=knownAirlines[code]||code;
        var dep=f.departure_at?f.departure_at.substring(11,16):"--:--";
        var durMins=f.duration_to||f.duration||0;
        var dur=durMins?(Math.floor(durMins/60)+"h "+(durMins%60)+"m"):"";
        var stops=f.transfers===0?"Nonstop":f.transfers+" stop"+(f.transfers>1?"s":"");
        var price="$"+Math.round(f.price||0);
        var link=f.booking_link||"#";
        var destCode=f.destination_airport||f.destination||to;
        var isHL=highlight[code]?1:0;
        var borderColor=isHL?(code==="UA"?"#003580":"#c01933"):"#aaa";
        var btnBg=isHL?(code==="UA"?"#003580":"#c01933"):"#1a1a1a";
        cards+="<a href=\""+link+"\" target=\"_blank\" rel=\"noopener\" class=\"nm-fc "+(f.transfers===0?"nonstop":"with-stops")+"\" style=\"text-decoration:none;border-left-color:"+borderColor+";\">"
            +"<img class=\"nm-fc-logo\" src=\"https://pics.avs.io/40/40/"+code+".png\" onerror=\"this.style.display=&apos;none&apos;\" alt=\""+code+"\">"
            +"<div class=\"nm-fc-dep\"><span class=\"nm-fc-time\">"+dep+"</span><span class=\"nm-fc-code\">"+f.origin_airport+"</span></div>"
            +"<div class=\"nm-fc-mid\"><div class=\"nm-fc-mid-line\"><span class=\"nm-fc-mid-seg\"></span><span class=\"nm-fc-mid-dot\"></span><span class=\"nm-fc-mid-seg\"></span></div>"
            +"<span class=\"nm-fc-mid-label\">"+dur+(dur&&stops?" · ":"")+stops+"</span></div>"
            +"<div class=\"nm-fc-arr\"><span class=\"nm-fc-time\">--</span><span class=\"nm-fc-code\">"+destCode+"</span></div>"
            +"<span class=\"nm-fc-aln\">"+name+"</span>"
            +"<div class=\"nm-fc-price-btn\" style=\"background:"+btnBg+";\">"
            +"<span class=\"nm-fc-price-val\">"+price+"</span>"
            +"<span class=\"nm-fc-price-lbl\">Book →</span>"
            +"</div>"
            +"</a>";
    });

    // Check which airlines appeared in TP results; add direct-search cards for missing ones
    var tpCodes={};
    (tpOffers||[]).forEach(function(f){ tpCodes[(f.airline||"").toUpperCase()]=1; });

    function nmDirectCard(code,name,url,color){
        var short=name.replace(" Airlines","").replace(" Air Lines","").replace(" Airways","");
        return "<a href=\"" +url+ "\" target=\"_blank\" rel=\"noopener\" class=\"nm-al-chip\" style=\"border-color:"+color+";\">"
            +"<img src=\"https://pics.avs.io/32/32/"+code+".png\" onerror=\"this.style.display=&apos;none&apos;\" alt=\""+code+"\" style=\"width:24px;height:24px;object-fit:contain;flex-shrink:0;\">"
            +"<span style=\"font-size:12px;font-weight:700;color:#0a1628;\">"+short+"</span>"
            +"<span style=\"font-size:11px;font-weight:700;color:#fff;background:"+color+";padding:3px 8px;border-radius:10px;white-space:nowrap;\">Search →</span>"
            +"</a>";
    }

    // United — always show direct chip
    var uaUrl="https://www.united.com/en/us/book-flight/united-one-way-flight?from="+encodeURIComponent(from)+"&to="+encodeURIComponent(to)+"&departDate="+encodeURIComponent(depart)+"&paxCount=1&cabinType=economy";
    cards+=nmDirectCard("UA","United Airlines",uaUrl,"#003580");

    // Delta — always show direct chip
    var dlUrl="https://www.delta.com/us/en/flight-search/book-a-flight?tripType=ONE_WAY&departureDate="+encodeURIComponent(depart)+"&originAirportCode="+encodeURIComponent(from)+"&destinationAirportCode="+encodeURIComponent(to)+"&paxCount=1&cabinType=MAIN_CABIN";
    cards+=nmDirectCard("DL","Delta Air Lines",dlUrl,"#c01933");

    // Aviasales — shows ALL airlines including UA, DL with real prices
    var avsDate=depart.replace(/-/g,"");
    var avsUrl="https://www.aviasales.com/search/"+encodeURIComponent(from)+avsDate.substring(4,8)+encodeURIComponent(to)+"1?marker=441262";
    cards="<a href=\"" +avsUrl+ "\" target=\"_blank\" rel=\"noopener\" class=\"nm-al-chip\" style=\"border-color:#ff6d00;background:#fff8f4;\">"
        +"<img src=\"https://pics.avs.io/32/32/AS.png\" onerror=\"this.style.display=&apos;none&apos;\" style=\"width:20px;height:20px;\">"
        +"<span style=\"font-size:12px;font-weight:700;color:#ff6d00;\">All Airlines + United & Delta</span>"
        +"<span style=\"font-size:11px;font-weight:700;color:#fff;background:#ff6d00;padding:3px 10px;border-radius:10px;\">Compare All →</span>"
        +"</a>"+cards;
    // Southwest — always direct (not on GDS)
    var swUrl="https://www.southwest.com/air/booking/select.html?adultPassengersCount=1"
        +"&departureDate="+encodeURIComponent(depart)
        +"&destinationAirportCode="+encodeURIComponent(to)
        +"&fareType=USD&int=HOMEQBOMFT"
        +"&originationAirportCode="+encodeURIComponent(from)
        +"&passengerType=ADULT&returnDate=&tripType=oneway&departureTimeOfDay=ALL_DAY&reset=true&returnAirportCode=";
    cards+="<a href=\"" +swUrl+ "\" target=\"_blank\" rel=\"noopener\" class=\"nm-al-chip\" style=\"border-color:#304CB2;background:#f0f4ff;\">"
        +"<img src=\"https://pics.avs.io/32/32/WN.png\" onerror=\"this.style.display=&apos;none&apos;\" style=\"width:20px;height:20px;\">"
        +"<span style=\"font-size:12px;font-weight:700;color:#304CB2;\">Southwest</span>"
        +"<span style=\"font-size:11px;font-weight:700;color:#fff;background:#304CB2;padding:3px 10px;border-radius:10px;\">Search \xe2\x86\x92</span>"
        +"</a>";

    // JetBlue — always direct (not in Duffel NDC)
    var b6Url="https://www.jetblue.com/flights/"+encodeURIComponent(from)+"-"+encodeURIComponent(to)+"?departureDate="+encodeURIComponent(depart)+"&cabin=economy&adults=1";
    cards+=nmDirectCard("B6","JetBlue",b6Url,"#003876");

    // Alaska — always direct (not in Duffel NDC)
    var asUrl="https://www.alaskaair.com/booking/flights?A=1&C=0&D=0&O="+encodeURIComponent(from)+"&D2="+encodeURIComponent(to)+"&OD="+encodeURIComponent(depart)+"&OT=oneway&BC=Y&RT=false";
    cards+=nmDirectCard("AS","Alaska Airlines",asUrl,"#00467F");

    // Frontier — always direct (not in Duffel NDC)
    var f9Url="https://www.flyfrontier.com/book/plan-your-trip/?departureCity="+encodeURIComponent(from)+"&arrivalCity="+encodeURIComponent(to)+"&departureDate="+encodeURIComponent(depart)+"&numberOfAdults=1&trip=ONE_WAY";
    cards+=nmDirectCard("F9","Frontier Airlines",f9Url,"#00A651");

    var section=document.createElement("div");
    section.id="tp-section";
    section.style.cssText="margin-bottom:14px;";
    section.innerHTML="<div style=\"font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#999;margin-bottom:8px;\">Also search these airlines</div>"
        +"<div style=\"display:flex;flex-wrap:wrap;gap:8px;align-items:center;\">" + cards + "</div>";
    list.insertBefore(section, list.firstChild);
}

function flCloseBooking(el){
    var container=el.closest('.fl-booking-container');
    if(container){container.style.display='none';container.innerHTML='';}
}
function flClearSeat(el){/* handled by inline listener */}
function flSkipSeat(el){/* handled by inline listener */}

// ── Pre-populate from URL params ──
(function(){
    var params=new URLSearchParams(window.location.search);
    var from=params.get('from'), to=params.get('to'), dep=params.get('depart')||params.get('departure_date')||params.get('travelling_date');
    var adults=params.get('adults'), cabin=params.get('cabin_class')||params.get('cabin');
    if(from){
        document.getElementById('fl-from').value=from;
        document.getElementById('fl-from-code').value=from;
    }
    if(to){
        document.getElementById('fl-to').value=to;
        document.getElementById('fl-to-code').value=to;
    }
    if(dep) document.getElementById('fl-depart').value=dep;
    if(adults) document.getElementById('fl-adults').value=adults;
    if(cabin) document.getElementById('fl-cabin').value=cabin;
    if(from&&to&&dep) setTimeout(flSearch, 300);
})();
</script>
@endpush
</x-app-layout>

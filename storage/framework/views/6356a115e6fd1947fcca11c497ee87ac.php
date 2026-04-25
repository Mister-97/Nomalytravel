<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php $__env->startPush('css'); ?>
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
@media (max-width: 480px) {
    .nm-fc { gap: 7px; padding: 10px 10px; }
    .nm-fc-aln { display:inline-flex; align-items:center; font-size:12px; color:#444; font-weight:500; }
    .nm-fc-mid { min-width: 60px; }
    .nm-fc-time { font-size: 14px; }
    .nm-fc-price-val { font-size: 14px; }
}
</style>
<?php $__env->stopPush(); ?>


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
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/NK.svg" alt="Spirit" title="Spirit">
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
                  <input type="date" id="fl-depart" min="<?php echo e(date('Y-m-d')); ?>">
                </div>
              </div>
              <div class="col-6 col-md-2" id="fl-ret-col" style="display:none">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar-check"></i>Return</label>
                  <input type="date" id="fl-return" min="<?php echo e(date('Y-m-d')); ?>">
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


<div id="fl-results" style="display:none">
  <div class="container py-5">
    <div id="fl-results-inner"></div>
  </div>
</div>


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

<?php $__env->startPush('js'); ?>
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
        if(animate!==false) outer.scrollIntoView({behavior:'smooth',block:'start'});
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

var FL_US_PRIORITY={AA:1,F9:2,NK:3,B6:4,AS:5,UA:6,DL:7,WN:8,G4:9,SY:10};
var FL_HAS_LOGO={AA:1,AS:1,B6:1,DL:1,F9:1,G4:1,HA:1,NK:1,SY:1,UA:1,WN:1,BA:1,LH:1,AF:1,KL:1,IB:1,EK:1,QR:1,SQ:1,AC:1,QF:1,LA:1,AM:1};

function flSortPriority(a,b){
    var ia=(a.owner&&a.owner.iata_code)?a.owner.iata_code.toUpperCase():'';
    var ib=(b.owner&&b.owner.iata_code)?b.owner.iata_code.toUpperCase():'';
    var pa=FL_US_PRIORITY[ia]||99,pb=FL_US_PRIORITY[ib]||99;
    if(pa!==pb) return pa-pb;
    return parseFloat(a.total_amount||9999)-parseFloat(b.total_amount||9999);
}

// ── Main Search ──
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

    fetch('/api/home/flights?'+qs,{headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){return r.json();})
    .then(function(data){
        if(btn){btn.innerHTML='<i class="fas fa-search"></i> Search';btn.disabled=false;}
        if(data&&data.error){flError(data.error);return;}
        var offers=Array.isArray(data)?data:(data.offers||data.data||[]);
        window._flOffers=offers;
        flRenderFlights(offers,from,to,depart);
    })
    .catch(function(e){
        if(btn){btn.innerHTML='<i class="fas fa-search"></i> Search';btn.disabled=false;}
        flError('Search error: '+(e.message||'network error'));
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
        pills+='<div class="nm-date-pill'+(isSel?' nm-dp-sel':'')+'" id="fldp-'+ds+'" onclick="flSearch(\''+ds+'\')">'
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
    var airlines={};
    sorted.forEach(function(o){if(o.owner&&o.owner.name)airlines[o.owner.name]=1;});
    var alCount=Object.keys(airlines).length;

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

    html+=flBuildPriceCalendar(from,to,depart);
    html+='<div id="fl-list">';
    if(!window._flCardData) window._flCardData={};
    sorted.forEach(function(o){html+=flFlightCard(o);});
    html+='</div>';
    flShowResults(html);
    setTimeout(function(){flFetchNearbyPrices(from,to,depart);},600);
}

function flFlightCard(offer){
            if(!offer||!offer.slices||!offer.slices[0])return'';
            const sl=offer.slices[0], segs=sl.segments||[], seg=segs[0]||{};
            const lastSeg=segs.length>1?segs[segs.length-1]:seg;
            const oc=seg.operating_carrier||{};
            const owner=offer.owner||{};
            const iata=((oc.iata_code||owner.iata_code||'')).toUpperCase();
            const airlineNames={'F9':'Frontier','NK':'Spirit','AA':'American','UA':'United','DL':'Delta','WN':'Southwest','B6':'JetBlue','AS':'Alaska','G4':'Allegiant','SY':'Sun Country','HA':'Hawaiian','MX':'Breeze','VX':'Virgin America'};
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
function flSortFlights(by,btn){
    document.querySelectorAll('.nm-sort-btn').forEach(function(b){b.classList.remove('active');});
    if(btn) btn.classList.add('active');
    var s=(window._flOffers||[]).slice();
    if(by==='us') s.sort(flSortPriority);
    else if(by==='price') s.sort(function(a,b){return parseFloat(a.total_amount)-parseFloat(b.total_amount);});
    else if(by==='dur') s.sort(function(a,b){return flParseDur((a.slices[0]||{}).duration||'')-flParseDur((b.slices[0]||{}).duration||'');});
    else if(by==='stops') s.sort(function(a,b){var sa=a.slices&&a.slices[0]&&a.slices[0].segments?a.slices[0].segments.length-1:9,sb=b.slices&&b.slices[0]&&b.slices[0].segments?b.slices[0].segments.length-1:9;return sa!==sb?sa-sb:parseFloat(a.total_amount)-parseFloat(b.total_amount);});
    var list=document.getElementById('fl-list');
    if(list){list.innerHTML='';s.forEach(function(o){list.innerHTML+=flFlightCard(o);});}
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
            _flStripe=Stripe('<?php echo e(env("STRIPE_KEY")); ?>');
            var card=_flStripe.elements().create('card',{style:{base:{fontSize:'15px',color:'#0a1628','::placeholder':{color:'#bbb'},fontFamily:'inherit'}}});
            card.mount(cardEl);
            _flStripeCards[cardEl.id||Math.random()]=card;
            if(onReady) onReady(card);
        } else {
            var s=document.createElement('script'); s.src='https://js.stripe.com/v3/';
            s.onload=function(){
                _flStripe=Stripe('<?php echo e(env("STRIPE_KEY")); ?>');
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
            seatMapEl.innerHTML='<div class="nm-seat-loading" style="color:#c9a84c;"><i class="fas fa-info-circle me-2"></i>Seat map not available for this flight</div>';
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
<?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/flights/index.blade.php ENDPATH**/ ?>
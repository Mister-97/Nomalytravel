<x-app-layout>
@push('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* ══════════════════════════════════════════════════════════
   NOMALY TRAVEL — Luxury Redesign
   Deep Navy · Gold · Cormorant Garamond · DM Sans
══════════════════════════════════════════════════════════ */
:root {
  --navy:      #070D1A;
  --navy2:     #0E1D36;
  --navy3:     #1a3a6b;
  --gold:      #C9A84C;
  --gold-lt:   #E8C96A;
  --gold-dk:   #A07830;
  --white:     #ffffff;
  --text-muted:#94a3b8;
  --border:    #e8edf5;
  --radius-lg: 20px;
  --radius-md: 14px;
  --radius-sm: 10px;
  --shadow-xl: 0 24px 80px rgba(0,0,0,0.5);
  --shadow-md: 0 8px 32px rgba(0,0,0,0.12);
}

/* ── Page body font ────────────────────────────────── */
body { font-family: 'DM Sans', sans-serif; }

/* ── Page load animation ───────────────────────────── */
@keyframes nm-page-in {
  from { opacity:0; }
  to   { opacity:1; }
}
@keyframes nm-slide-up {
  from { opacity:0; transform:translateY(40px); }
  to   { opacity:1; transform:translateY(0); }
}
@keyframes nm-fade-in {
  from { opacity:0; transform:translateY(10px); }
  to   { opacity:1; transform:translateY(0); }
}
@keyframes nm-spin { to { transform:rotate(360deg); } }
@keyframes nm-blink { 0%,100%{opacity:1}50%{opacity:.3} }
@keyframes nm-glow-pulse {
  0%,100% { opacity:.4; transform:scale(1); }
  50%      { opacity:.7; transform:scale(1.06); }
}

body { animation: nm-page-in .5s ease both; }

/* ══════════════════════════════════════════════════════
   HERO
══════════════════════════════════════════════════════ */
.nm-hero {
  background: var(--navy);
  padding: 90px 0 70px;
  position: relative;
  overflow: visible;
  min-height: 520px;
  display: flex;
  align-items: center;
}

/* Background video overlay */
.nm-hero::before {
  content: '';
  position: absolute; inset: 0;
  background: rgba(10,22,40,0.75);
  z-index: 1;
}
.nm-hero-video {
  position: absolute; inset: 0;
  width: 100%; height: 100%;
  object-fit: cover;
  z-index: 0;
  pointer-events: none;
}

/* Gold radial glow — top right */
.nm-hero::after {
  content: '';
  position: absolute;
  top: -120px; right: -180px;
  width: 600px; height: 600px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(201,168,76,0.18) 0%, transparent 70%);
  animation: nm-glow-pulse 6s ease-in-out infinite;
  pointer-events: none;
}

/* Second glow — bottom left */
.nm-hero-glow2 {
  position: absolute;
  bottom: -100px; left: -150px;
  width: 500px; height: 500px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(26,58,107,0.5) 0%, transparent 70%);
  animation: nm-glow-pulse 8s ease-in-out infinite reverse;
  pointer-events: none;
}

/* Thin gold top border accent */
.nm-hero-accent {
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, transparent, var(--gold), transparent);
}

.nm-hero-inner {
  position: relative; z-index: 2;
  width: 100%;
  animation: nm-slide-up .7s ease both;
}

/* Eyebrow label */
.nm-hero-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  font-family: 'DM Sans', sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 18px;
}
.nm-hero-eyebrow::before,
.nm-hero-eyebrow::after {
  content: '';
  flex: 0 0 30px;
  height: 1px;
  background: var(--gold);
  opacity: .5;
}

/* Main headline */
.nm-hero-headline {
  font-family: 'Cormorant Garamond', Georgia, serif;
  font-size: clamp(3rem, 7vw, 5.5rem);
  font-weight: 600;
  line-height: 1.05;
  color: var(--white);
  margin: 0 0 16px;
  letter-spacing: -.5px;
}
.nm-hero-headline em {
  font-style: italic;
  color: var(--gold);
}

/* Sub headline */
.nm-hero-sub {
  font-family: 'DM Sans', sans-serif;
  font-size: 1.05rem;
  font-weight: 300;
  color: rgba(255,255,255,.6);
  letter-spacing: .3px;
  margin: 0;
}

/* Search box container */
.nm-search-wrap {
  animation: nm-slide-up .8s .15s ease both;
}

/* ══════════════════════════════════════════════════════
   SEARCH BOX
══════════════════════════════════════════════════════ */
.nm-gf-box {
  background: var(--white);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-xl);
  overflow: visible;
  position: relative;
  z-index: 100;
  border: 1px solid rgba(255,255,255,.08);
}

/* ── Tabs ─────────────────────────────────────────── */
.nm-gf-tabs {
  display: flex;
  overflow-x: auto;
  scrollbar-width: none;
  border-radius: var(--radius-lg) var(--radius-lg) 0 0;
  overflow: hidden;
}
.nm-gf-tabs::-webkit-scrollbar { display: none; }
.nm-gf-tab:focus { outline: none; }
.nm-gf-tab:focus-visible { outline: none; }

.nm-gf-tab {
  flex-shrink: 0;
  padding: 16px 22px;
  font-family: 'DM Sans', sans-serif;
  font-size: 13px;
  font-weight: 600;
  color: #888;
  background: none;
  border: none;
  border-bottom: 3px solid transparent;
  cursor: pointer;
  transition: all .2s;
  letter-spacing: .2px;
  white-space: nowrap;
  display: flex;
  align-items: center;
  gap: 7px;
}
.nm-gf-tab i { font-size: 12px; }
.nm-gf-tab:hover { color: var(--navy); background: #fafbfd; }
.nm-gf-tab.active {
  color: var(--navy);
  border-bottom-color: var(--gold);
  background: var(--white);
  font-weight: 700;
}

/* ── Panel ─────────────────────────────────────────── */
.nm-gf-panel { padding: 26px 28px 30px; border-top: 1.5px solid var(--border); }

/* ── Trip type pills ───────────────────────────────── */
.nm-trip-type {
  display: flex;
  gap: 8px;
  margin-bottom: 18px;
}
.nm-trip-type label {
  font-family: 'DM Sans', sans-serif;
  font-size: 12px;
  font-weight: 600;
  color: #666;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 5px 14px;
  border-radius: 20px;
  border: 1.5px solid var(--border);
  transition: all .18s;
  user-select: none;
}
.nm-trip-type label:has(input:checked) {
  background: var(--navy);
  color: var(--gold);
  border-color: var(--navy);
}
.nm-trip-type input[type="radio"] { display: none; }

/* ── Field boxes ───────────────────────────────────── */
.nm-gf-field {
  border: 1.5px solid var(--border);
  border-radius: var(--radius-sm);
  padding: 12px 16px;
  background: var(--white);
  transition: border-color .2s, box-shadow .2s;
  height: 100%;
  min-height: 66px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  cursor: text;
}
.nm-gf-field:hover { border-color: #c8d4e8; }
.nm-gf-field:focus-within {
  border-color: var(--gold);
  box-shadow: 0 0 0 3px rgba(201,168,76,.12);
}
.nm-gf-field label {
  display: block;
  font-family: 'DM Sans', sans-serif;
  font-size: 9px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: var(--text-muted);
  margin-bottom: 4px;
}
.nm-gf-field label i { color: var(--gold); margin-right: 4px; font-size: 9px; }
.nm-gf-field input,
.nm-gf-field select {
  width: 100%;
  border: none;
  outline: none;
  font-family: 'DM Sans', sans-serif;
  font-size: 15px;
  font-weight: 600;
  color: var(--navy);
  background: transparent;
  padding: 0;
  -webkit-appearance: none;
  appearance: none;
}
.nm-gf-field select {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23C9A84C' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 4px center;
  padding-right: 20px;
  cursor: pointer;
}
.nm-gf-field input::placeholder { color: #bcc5d3; font-weight: 400; font-size: 14px; }

/* ── Search button ─────────────────────────────────── */
.nm-gf-btn {
  background: linear-gradient(135deg, var(--gold) 0%, var(--gold-lt) 100%);
  color: var(--navy);
  border: none;
  border-radius: var(--radius-sm);
  padding: 0 28px;
  font-family: 'DM Sans', sans-serif;
  font-size: 15px;
  font-weight: 700;
  letter-spacing: .3px;
  cursor: pointer;
  transition: all .22s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  white-space: nowrap;
  height: 66px;
  width: 100%;
  position: relative;
  overflow: hidden;
}
.nm-gf-btn::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,.2) 0%, transparent 60%);
  opacity: 0;
  transition: opacity .22s;
}
.nm-gf-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 28px rgba(201,168,76,.45);
}
.nm-gf-btn:hover::before { opacity: 1; }
.nm-gf-btn:active { transform: translateY(0); }

/* ── Autocomplete dropdown ─────────────────────────── */
.nm-ac-wrap { position: relative; }
.nm-ac-dropdown {
  display: none;
  position: absolute;
  top: calc(100% + 6px);
  left: -16px; right: -16px;
  background: var(--white);
  border-radius: var(--radius-md);
  border: 1.5px solid var(--border);
  box-shadow: 0 12px 40px rgba(10,22,40,.16);
  z-index: 9999;
  max-height: 320px;
  overflow-y: auto;
}
.nm-ac-dropdown.open { display: block; }
.nm-ac-item {
  padding: 11px 16px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 10px;
  border-bottom: 1px solid #f3f5f9;
  transition: background .1s;
}
.nm-ac-item:last-child { border-bottom: none; }
.nm-ac-item:hover, .nm-ac-item.active { background: #f7f9fe; }
.nm-ac-icon {
  width: 30px; height: 30px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0; font-size: 14px;
}
.nm-ac-icon-city { background: #e8f0fe; color: #1a56db; }
.nm-ac-icon-apt  { background: #fef9e7; color: var(--gold); }
.nm-ac-text { flex: 1; min-width: 0; }
.nm-ac-name {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px; font-weight: 600;
  color: var(--navy);
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.nm-ac-sub {
  font-size: 11px; color: #999;
  white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.nm-ac-code {
  font-size: 12px; font-weight: 800;
  color: var(--gold); background: var(--navy);
  border-radius: 5px; padding: 2px 8px; flex-shrink: 0;
  font-family: 'DM Sans', sans-serif;
}
.nm-ac-no-results { padding: 16px; text-align: center; color: #999; font-size: 13px; }

/* ══════════════════════════════════════════════════════
   RESULTS AREA
══════════════════════════════════════════════════════ */
#nm-results { background: #f1f4f9; min-height: 220px; }
#nm-results-inner {
  opacity: 0; transform: translateY(24px);
  transition: opacity .45s ease, transform .45s ease;
}
#nm-results-inner.nm-visible { opacity: 1; transform: translateY(0); }

/* Gold loading bar */
.nm-loading { text-align: center; padding: 70px 20px; }
.nm-spinner {
  width: 48px; height: 48px;
  border: 3px solid #e2e8f4;
  border-top-color: var(--gold);
  border-radius: 50%;
  animation: nm-spin .75s linear infinite;
  margin: 0 auto 20px;
}
.nm-loading p {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px; font-weight: 500;
  color: #667;
  letter-spacing: .2px;
}

/* Results header */
.nm-results-hdr {
  display: flex; justify-content: space-between; align-items: center;
  margin-bottom: 22px; flex-wrap: wrap; gap: 12px;
}
.nm-results-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 24px; font-weight: 600;
  color: var(--navy); margin: 0;
  letter-spacing: -.3px;
}

/* Price calendar strip */
.nm-price-cal {
  background: var(--white); border-radius: var(--radius-md);
  padding: 18px 22px; margin-bottom: 20px;
  box-shadow: var(--shadow-md);
}
.nm-price-cal h6 {
  font-family: 'DM Sans', sans-serif;
  font-size: 10px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 1px;
  color: #999; margin-bottom: 14px;
}
.nm-date-strip { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px; scrollbar-width: none; }
.nm-date-strip::-webkit-scrollbar { display: none; }
.nm-date-pill {
  flex-shrink: 0; min-width: 86px;
  background: #f7f8fc; border: 1.5px solid var(--border);
  border-radius: var(--radius-sm); padding: 10px 12px;
  text-align: center; cursor: pointer; transition: all .15s;
}
.nm-date-pill:hover { border-color: var(--navy); background: var(--white); }
.nm-date-pill.nm-dp-sel { background: var(--gold); border-color: var(--gold); }
.nm-date-pill.nm-dp-cheap { border-color: #27ae60; }
.nm-dp-day { font-size: 10px; color: #999; margin-bottom: 2px; font-family:'DM Sans',sans-serif; }
.nm-date-pill.nm-dp-sel .nm-dp-day { color: rgba(10,22,40,.6); }
.nm-dp-dt { font-size: 12px; font-weight: 700; color: var(--navy); font-family:'DM Sans',sans-serif; }
.nm-date-pill.nm-dp-sel .nm-dp-dt { color: var(--navy); }
.nm-dp-price { font-size: 12px; font-weight: 700; color: #27ae60; margin-top: 3px; font-family:'DM Sans',sans-serif; }
.nm-date-pill.nm-dp-sel .nm-dp-price { color: var(--navy); }
.nm-dp-price.loading { color: #bbb; animation: nm-blink 1.2s ease infinite; }

/* ── Sort bar ─────────────────────────────────────── */
.nm-sort-bar { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
.nm-sort-bar span { font-size: 12px; color: #999; font-family:'DM Sans',sans-serif; }
.nm-sort-btn {
  background: var(--white); border: 1.5px solid var(--border);
  border-radius: 20px; padding: 5px 14px;
  font-family: 'DM Sans', sans-serif;
  font-size: 12px; font-weight: 600; cursor: pointer; color: #666;
  transition: all .15s;
}
.nm-sort-btn.active, .nm-sort-btn:hover {
  background: var(--navy); color: var(--gold); border-color: var(--navy);
}

/* ── Airport filter pills ───────────────────────────────────────── */
.nm-apt-bar { display:flex; align-items:center; gap:6px; flex-wrap:wrap; margin-bottom:16px; width:100%; }
.nm-apt-bar span { font-size:12px; color:#999; font-family:'DM Sans',sans-serif; }
.nm-apt-pill {
  background: var(--white); border: 1.5px solid var(--border);
  border-radius: 20px; padding: 5px 14px;
  font-family: 'DM Sans', sans-serif;
  font-size: 12px; font-weight: 600; cursor: pointer; color: #666;
  transition: all .15s; display:flex; align-items:center; gap:5px;
}
.nm-apt-pill .nm-apt-count {
  background: #eef0f5; border-radius: 10px; padding: 1px 7px;
  font-size: 11px; font-weight: 700; color: #666;
}
.nm-apt-pill.active, .nm-apt-pill:hover {
  background: #0e1d36; color: var(--gold); border-color: #0e1d36;
}
.nm-apt-pill.active .nm-apt-count { background:rgba(201,168,76,.2); color:var(--gold); }

/* ── Flight cards ───────────────────────────────────────────────── */
.nm-fc { background:#ffffff; border:1.5px solid #d0d0d0; border-radius:16px; margin:0 0 8px 0; padding:12px 14px; box-shadow:0 3px 12px rgba(0,0,0,0.09); cursor:pointer; animation:nm-fade-in .3s ease both; }
.nm-fc:hover { background:#f8f9fa; }
.nm-fc-body { display:flex; align-items:center; gap:10px; padding:8px 12px; }
.nm-fc-airline { display:flex; align-items:center; flex-shrink:0; width:36px; }
.nm-fc-logo { height:20px; width:auto; max-width:36px; object-fit:contain; display:block; }
.nm-fc-aname { font-size:10px; font-weight:700; color:var(--navy); max-width:36px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.nm-fc-iata-badge { display:none; }
.nm-fc-times { text-align:center; flex-shrink:0; min-width:52px; }
.nm-fc-time { display:block; font-size:14px; font-weight:700; color:var(--navy); line-height:1.1; }
.nm-fc-code { font-size:10px; color:#aaa; display:block; }
.nm-fc-mid { flex:1; text-align:center; padding:0 6px; }
.nm-fc-dur { font-size:10px; color:#999; margin-bottom:2px; }
.nm-fc-line { display:flex; align-items:center; }
.nm-fc-dot { width:5px; height:5px; border-radius:50%; background:var(--navy); flex-shrink:0; }
.nm-fc-track { flex:1; height:1px; background:#dde2ec; margin:0 4px; }
.nm-fc-stops { font-size:10px; font-weight:700; color:#999; margin-top:2px; }
.nm-fc-stops.nonstop { color:#27ae60; }
.nm-fc-price-col { text-align:right; flex-shrink:0; min-width:72px; }
.nm-fc-price { font-size:15px; font-weight:800; color:var(--navy); font-family:"DM Sans",sans-serif; }
.nm-fc-per { display:none; }
.nm-fc-select { display:inline-block; width:auto; margin-top:3px; background:none; color:var(--gold); border:none; padding:0; font-size:11px; font-weight:700; cursor:pointer; }
.nm-fc-select:hover { color:#8a6d00; text-decoration:underline; }
.nm-fl-cards { border:1px solid #e0e4eb; border-radius:8px; overflow:hidden; }
/* ── Hotel / Event cards ──────────────────────────── */
.nm-hc, .nm-ec {
  background: var(--white); border-radius: var(--radius-md);
  box-shadow: var(--shadow-md); overflow: hidden;
  transition: transform .18s;
  display: flex; flex-direction: column;
}
.nm-hc:hover, .nm-ec:hover { transform: translateY(-3px); }
.nm-hc-img, .nm-ec-img { width: 100%; height: 160px; object-fit: cover; display: block; flex-shrink: 0; }
.nm-hc-ph, .nm-ec-ph {
  width: 100%; height: 160px;
  background: linear-gradient(135deg, var(--navy), var(--navy3));
  display: flex; align-items: center; justify-content: center; font-size: 2.8rem;
  flex-shrink: 0;
}
.nm-hc-body, .nm-ec-body { padding: 16px 18px; display: flex; flex-direction: column; flex: 1; }
.nm-hc-name, .nm-ec-title {
  font-family: 'DM Sans', sans-serif;
  font-size: 15px; font-weight: 700; color: var(--navy); margin-bottom: 6px; line-height: 1.35;
}
.nm-hc-stars { color: var(--gold); font-size: 12px; margin-bottom: 5px; }
.nm-hc-meta, .nm-ec-meta { font-size: 12px; color: #999; line-height: 1.65; }
.nm-hc-meta i, .nm-ec-meta i { color: var(--gold); width: 14px; }
.nm-hf-btn, .nm-hsf-btn {
  border:1.5px solid #ddd; background:#fff; color:#444; border-radius:20px;
  padding:4px 12px; font-size:11px; font-weight:600; cursor:pointer; transition:all .15s;
}
.nm-hf-btn:hover, .nm-hsf-btn:hover { border-color:#C9A84C; color:#C9A84C; }
.nm-hf-btn.active { background:#070D1A; color:#C9A84C; border-color:#070D1A; }
.nm-hsf-btn.active { background:#C9A84C; color:#070D1A; border-color:#C9A84C; }
.nm-hc-price, .nm-ec-price {
  font-family: 'DM Sans', sans-serif;
  font-size: 14px; font-weight: 700; color: var(--navy); margin-top: auto; padding-top: 10px; letter-spacing: -.2px;
}
.nm-hc-price span, .nm-ec-price span { font-weight: 400; color: #888; font-size: 12px; }
.nm-ec-cat { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--gold); margin-bottom: 4px; }
.nm-hc-btn, .nm-ec-btn {
  display: block; margin-top: 12px;
  background: var(--navy); color: var(--gold);
  border: 2px solid var(--gold); border-radius: 9px;
  padding: 9px 0; text-align: center;
  font-family: 'DM Sans', sans-serif;
  font-size: 13px; font-weight: 700;
  text-decoration: none; transition: all .2s;
}
.nm-hc-btn:hover, .nm-ec-btn:hover { background: var(--gold); color: var(--navy); }
.nm-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(272px, 1fr)); gap: 18px; }

/* ── Alert boxes ──────────────────────────────────── */
.nm-alert { border-radius: var(--radius-sm); padding: 14px 18px; font-size: 14px; font-weight: 600; font-family:'DM Sans',sans-serif; }
.nm-alert-err { background: #fde8e8; color: #c0392b; border: 1px solid #f5c6c6; }
.nm-alert-info { background: #e8f4fd; color: #2471a3; border: 1px solid #b3d7f2; }
.nm-alert-ok  { background: #e8fde8; color: #1a7a2a; border: 1px solid #b3f2c6; }

/* ── Cars placeholder ─────────────────────────────── */
.nm-cars-ph { text-align: center; padding: 40px 20px; }
.nm-cars-ph i { font-size: 3rem; color: var(--gold); display: block; margin-bottom: 14px; }

/* ── Booking drawer ───────────────────────────────── */
.nm-overlay {
  position: fixed; inset: 0;
  background: rgba(0,0,0,.6);
  z-index: 1040; opacity: 0; pointer-events: none;
  transition: opacity .3s;
  backdrop-filter: blur(4px);
}
.nm-overlay.open { opacity: 1; pointer-events: all; }
.nm-drawer {
  position: fixed; right: -500px; top: 0;
  width: 100%; max-width: 460px; height: 100vh;
  background: var(--white); z-index: 1050;
  overflow-y: auto;
  box-shadow: -8px 0 50px rgba(0,0,0,.3);
  transition: right .3s cubic-bezier(.4,0,.2,1);
}
.nm-drawer.open { right: 0; }
.nm-drw-hdr {
  background: linear-gradient(135deg, var(--navy), var(--navy3));
  color: var(--white); padding: 22px 26px;
}
.nm-drw-hdr h5 { margin: 0; font-family:'DM Sans',sans-serif; font-weight: 700; font-size: 17px; }
.nm-drw-close { background: none; border: none; color: var(--white); font-size: 24px; cursor: pointer; line-height: 1; }
.nm-drw-body { padding: 24px 26px; }
.nm-drw-summary { background: #f7f8fc; border-radius: var(--radius-sm); padding: 14px 16px; margin-bottom: 22px; }
.nm-drw-route { font-family:'DM Sans',sans-serif; font-size: 18px; font-weight: 800; color: var(--navy); }
.nm-drw-details { font-size: 12px; color: #999; margin-top: 3px; }
.nm-drw-price { font-family:'Cormorant Garamond',serif; font-size: 26px; font-weight: 600; color: var(--gold); }
.nm-df { margin-bottom: 14px; }
.nm-df label { display: block; font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #aaa; margin-bottom: 5px; font-family:'DM Sans',sans-serif; }
.nm-df input { width: 100%; padding: 12px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-family:'DM Sans',sans-serif; font-size: 14px; font-weight: 600; color: var(--navy); }
.nm-df input:focus { outline: none; border-color: var(--gold); }
#nm-card-el { padding: 13px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); }
#nm-card-err { color: #e53935; font-size: 13px; margin-top: 6px; min-height: 18px; }
.nm-pay-btn {
  width: 100%; padding: 17px;
  background: linear-gradient(135deg, var(--gold), var(--gold-lt));
  color: var(--navy); border: none; border-radius: var(--radius-sm);
  font-family: 'DM Sans', sans-serif;
  font-size: 16px; font-weight: 700;
  cursor: pointer; margin-top: 12px; transition: all .2s;
}
.nm-pay-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(201,168,76,.4); }
.nm-pay-btn:disabled { opacity: .55; cursor: not-allowed; transform: none; box-shadow: none; }

/* ── We Fly With ───────────────────────────────── */
.airline-logos {
  display: flex; flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 24px 32px; padding: 4px 12px;
}
.airline-logos::-webkit-scrollbar { display: none; }
.airline-logos img {
  height: 32px; width: auto; max-width: 110px; flex-shrink: 0;
  object-fit: contain;
  filter: grayscale(20%); opacity: .85;
  transition: opacity .2s, filter .2s; display: block;
}
.airline-logos img:hover { opacity: 1; filter: none; }

/* ══════════════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════════════ */
@media (max-width: 767px) {
  .nm-hero { padding: 60px 0 50px; min-height: auto; }
  .nm-hero-headline { font-size: clamp(2.4rem, 9vw, 3.2rem); }
  .nm-fc-body { padding:6px 10px; gap:8px; }
  .nm-fc-airline { width:36px; }
  .nm-fc-price-col { min-width:64px; text-align:right; }
  .nm-fc-times { min-width:46px; }
  .nm-fc-mid { flex:1; padding:0 4px; }
  .nm-drawer { max-width: 100%; }
  .nm-gf-panel { padding: 18px; }
  .nm-results-hdr { flex-direction: column; align-items: flex-start; }
  .nm-trip-type { flex-wrap: wrap; }
}
@media (max-width: 480px) {
  .nm-gf-box { border-radius: 16px; }
  .nm-fc-price { font-size:14px; }
}
@media (max-width: 600px) {
  .nm-tab-cars { font-size: 10px; }
  .nm-gf-tabs { display: flex; }
  .nm-gf-tab {
    flex: 1;
    padding: 14px 4px;
    font-size: 11px;
    gap: 4px;
    justify-content: center;
    flex-direction: row;
  }
  .nm-gf-tab i { font-size: 11px; }
}

/* ── Adults Stepper ── */
.nm-stepper{display:flex;align-items:center;justify-content:center;gap:4px;width:100%;}
.nm-step-btn{width:30px;height:30px;border:1.5px solid #c9a84c;background:#fff;color:#c9a84c;font-size:18px;line-height:1;cursor:pointer;border-radius:6px;flex-shrink:0;padding:0;}
.nm-step-btn:hover{background:#c9a84c;color:#fff;}
.nm-stepper input[type=number]{width:38px;text-align:center;border:1.5px solid #dce0ea;border-radius:6px;height:30px;font-size:15px;font-weight:700;-moz-appearance:textfield;background:#fff;}
.nm-stepper input[type=number]::-webkit-inner-spin-button,.nm-stepper input[type=number]::-webkit-outer-spin-button{-webkit-appearance:none;}

.nm-al-chip{display:inline-flex;align-items:center;gap:5px;padding:5px 12px 5px 8px;border:1px solid #e0e0e0;border-radius:8px;background:#fff;text-decoration:none;cursor:pointer;transition:all .15s;color:#0a1628;font-size:12px;font-weight:600;}
.nm-al-chip:hover{border-color:#c9a84c;background:#fffdf5;color:#0a1628;}
.nm-show-more-btn{display:block;width:100%;padding:10px;margin:4px 0 12px;background:#f5f7fa;border:1.5px dashed #ccc;border-radius:10px;color:#555;font-size:13px;font-weight:600;cursor:pointer;text-align:center;transition:background .15s;}
.nm-show-more-btn:hover{background:#eef0f5;border-color:#aaa;color:#0a1628;}

#nm-type-word { display: inline-block; }
#nm-cursor { display:inline-block; color:var(--gold); animation:nm-blink 1s step-end infinite; }
@keyframes nm-blink { 0%,100%{opacity:1} 50%{opacity:0} }
.nm-aiop { display:block; font-size:0.75rem; font-weight:600; letter-spacing:.22em; text-transform:uppercase; color:var(--gold); margin-top:10px; opacity:.9; }
</style>
@endpush

{{-- ═══════════════════════════════════════════════════
     HERO + SEARCH BOX
═══════════════════════════════════════════════════ --}}
<div class="nm-hero">
  <video class="nm-hero-video" autoplay muted loop playsinline>
    <source src="/videos/herovid.mp4" type="video/mp4">
  </video>
  <div class="nm-hero-accent"></div>
  <div class="nm-hero-glow2"></div>
  <div class="container nm-hero-inner">

    <div class="text-center mb-5">
      <div class="nm-hero-eyebrow">Premium Travel</div>
      <h1 class="nm-hero-headline">
        <span id="nm-type-word">Your Journey.</span><br><em>Your Way.</em>
      </h1>
      <p class="nm-hero-sub">Flights · Hotels · Sports · Concerts</p><p style="font-family:'DM Sans',sans-serif;font-size:0.72rem;font-weight:700;letter-spacing:.25em;text-transform:uppercase;color:#c9a84c;margin:8px 0 0;opacity:1;">All In One Place</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-xl-11">
        <div class="nm-search-wrap" id="nm-search">
        <div class="nm-gf-box">

          {{-- TABS --}}
          <div class="nm-gf-tabs">
            <button class="nm-gf-tab active" data-tab="flights" onclick="nmTab('flights')">
              <i class="fas fa-plane"></i> Flights
            </button>
            <button class="nm-gf-tab" data-tab="hotels" onclick="nmTab('hotels')">
              <i class="fas fa-hotel"></i> Hotels
            </button>
            <button class="nm-gf-tab" data-tab="sports" onclick="nmTab('sports')">
              <i class="fas fa-football-ball"></i> Sports
            </button>
            <button class="nm-gf-tab" data-tab="concerts" onclick="nmTab('concerts')">
              <i class="fas fa-music"></i> Concerts
            </button>
            <button class="nm-gf-tab" data-tab="cars" onclick="nmTab('cars')">
              <i class="fas fa-car"></i> Cars
            </button>
          </div>

          {{-- ── FLIGHTS ── --}}
          <div id="panel-flights" class="nm-gf-panel">
            <div style="margin:-4px -4px 10px;padding:5px 12px;background:#f7f8fc;border-bottom:1px solid #edf0f7;border-radius:6px 6px 0 0;display:flex;align-items:center;gap:18px;overflow-x:auto;flex-wrap:nowrap;-webkit-overflow-scrolling:touch;scrollbar-width:none;">
              <small style="font-size:9px;color:#aaa;font-weight:700;text-transform:uppercase;letter-spacing:.5px;white-space:nowrap;flex-shrink:0;">We Fly With:</small>
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/AA.svg" alt="American Airlines" title="American Airlines" style="height:32px;max-width:90px;object-fit:contain;opacity:.8;flex-shrink:0;">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/F9.svg" alt="Frontier" title="Frontier" style="height:32px;max-width:90px;object-fit:contain;opacity:.8;flex-shrink:0;">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/B6.svg" alt="JetBlue" title="JetBlue" style="height:32px;max-width:90px;object-fit:contain;opacity:.8;flex-shrink:0;">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/AS.svg" alt="Alaska" title="Alaska Airlines" style="height:32px;max-width:90px;object-fit:contain;opacity:.8;flex-shrink:0;">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/UA.svg" alt="United" title="United Airlines" style="height:32px;max-width:90px;object-fit:contain;opacity:.9;flex-shrink:0;">
              <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/DL.svg" alt="Delta" title="Delta Air Lines" style="height:32px;max-width:90px;object-fit:contain;opacity:.9;flex-shrink:0;">
            </div>
            <div class="nm-trip-type">
              <label><input type="radio" name="nm_trip" value="oneway" checked> One way</label>
              <label><input type="radio" name="nm_trip" value="twoway"> Round trip</label>
            </div>
            <div class="row g-2 align-items-stretch">
              <div class="col-12 col-md-3">
                <div class="nm-gf-field nm-ac-wrap">
                  <label><i class="fas fa-plane-departure"></i>From</label>
                  <input type="text" id="nm-from" class="nm-search-input" autocomplete="off" placeholder="City or airport…">
                  <input type="hidden" id="nm-from-code">
                  <div class="nm-ac-dropdown" id="nm-from-drop"></div>
                </div>
              </div>
              <div class="col-12 col-md-3">
                <div class="nm-gf-field nm-ac-wrap">
                  <label><i class="fas fa-plane-arrival"></i>To</label>
                  <input type="text" id="nm-to" class="nm-search-input" autocomplete="off" placeholder="City or airport…">
                  <input type="hidden" id="nm-to-code">
                  <div class="nm-ac-dropdown" id="nm-to-drop"></div>
                </div>
              </div>
              <div class="col-6 col-md-2">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar"></i>Depart</label>
                  <input type="date" id="nm-depart" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-6 col-md-2" id="nm-ret-col" style="display:none">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar-check"></i>Return</label>
                  <input type="date" id="nm-return" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-6 col-md-2">
                <div class="nm-gf-field" style="align-items:center;text-align:center;">
                  <label>Adults</label>
                  <div class="nm-stepper">
                    <button type="button" class="nm-step-btn" onclick="nmStep('nm-adults',-1)">&#8722;</button>
                    <input type="number" id="nm-adults" value="1" min="1" max="9" readonly>
                    <button type="button" class="nm-step-btn" onclick="nmStep('nm-adults',1)">+</button>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-2">
                <div class="nm-gf-field" style="align-items:center;text-align:center;">
                  <label>Children <small style="font-size:10px;color:var(--text-muted)">(under 12)</small></label>
                  <div class="nm-stepper">
                    <button type="button" class="nm-step-btn" onclick="nmStep('nm-youth',-1)">&#8722;</button>
                    <input type="number" id="nm-youth" value="0" min="0" max="9" readonly>
                    <button type="button" class="nm-step-btn" onclick="nmStep('nm-youth',1)">+</button>
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-2">
                <div class="nm-gf-field">
                  <label>Cabin Class</label>
                  <select id="nm-cabin">
                    <option value="economy">Economy</option>
                    <option value="premium_economy">Premium Economy</option>
                    <option value="business">Business Class</option>
                    <option value="first">First Class</option>
                  </select>
                </div>
              </div>
              <div class="col-12 col-md-auto d-flex align-items-stretch" style="min-width:150px">
                <button type="button" class="nm-gf-btn" id="nm-search-btn" onclick="nmSearchFlights()">
                  <i class="fas fa-search"></i> Search Flights
                </button>
              </div>
            </div>
          </div>

          {{-- ── HOTELS ── --}}
          <div id="panel-hotels" class="nm-gf-panel d-none">
            <div class="row g-2">
              <div class="col-12">
                <div class="nm-gf-field">
                  <label><i class="fas fa-map-marker-alt"></i>Destination</label>
                  <input type="text" name="city" id="nm-h-dest" autocomplete="off" placeholder="City, resort, hotel…">
                </div>
              </div>
              <div class="col-6">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar"></i>Check-in</label>
                  <input type="date" name="check_in" id="nm-h-in" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar-check"></i>Check-out</label>
                  <input type="date" name="check_out" id="nm-h-out" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="nm-gf-field">
                  <label><i class="fas fa-user"></i>Adults</label>
                  <select name="adults" id="nm-h-adults">
                    @for($i=1;$i<=9;$i++)<option value="{{ $i }}" @if($i==2) selected @endif>{{ $i }}</option>@endfor
                  </select>
                </div>
              </div>
              <div class="col-6">
                <div class="nm-gf-field">
                  <label><i class="fas fa-door-open"></i>Rooms</label>
                  <select name="rooms" id="nm-h-rooms">
                    @for($i=1;$i<=5;$i++)<option value="{{ $i }}">{{ $i }}</option>@endfor
                  </select>
                </div>
              </div>
              <div class="col-12 d-flex align-items-stretch">
                <button type="button" class="nm-gf-btn" id="nm-h-search-btn" onclick="nmSearchHotels()">
                  <i class="fas fa-search"></i> Search Hotels
                </button>
              </div>
            </div>
          </div>

          {{-- ── SPORTS ── --}}
          <div id="panel-sports" class="nm-gf-panel d-none">
            <div class="row g-2 align-items-stretch">
              <div class="col-12 col-md-3">
                <div class="nm-gf-field">
                  <label><i class="fas fa-map-marker-alt"></i>City</label>
                  <input type="text" id="nm-sp-city" list="nm-city-list" autocomplete="off" placeholder="e.g. New York, Miami">
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="nm-gf-field">
                  <label>Sport</label>
                  <select id="nm-sp-kw">
                    <option value="">All Sports</option>
                    <option value="NFL Football">🏈 NFL Football</option>
                    <option value="NBA Basketball">🏀 NBA Basketball</option>
                    <option value="MLB Baseball">⚾ MLB Baseball</option>
                    <option value="NHL Hockey">🏒 NHL Hockey</option>
                    <option value="MLS Soccer">⚽ MLS Soccer</option>
                    <option value="UFC MMA">🥊 UFC / MMA</option>
                    <option value="College Football">🏈 College Football</option>
                    <option value="College Basketball">🏀 College Basketball</option>
                    <option value="Golf">⛳ Golf</option>
                    <option value="Tennis">🎾 Tennis</option>
                    <option value="Boxing">🥊 Boxing</option>
                  </select>
                </div>
              </div>
              <div class="col-6 col-md-2">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar"></i>Date</label>
                  <input type="date" id="nm-sp-date" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-12 col-md-auto d-flex align-items-stretch" style="min-width:160px">
                <button type="button" class="nm-gf-btn" onclick="nmSearchSports()">
                  <i class="fas fa-search"></i> Find Events
                </button>
              </div>
            </div>
          </div>

          {{-- ── CONCERTS ── --}}
          <div id="panel-concerts" class="nm-gf-panel d-none">
            <div class="row g-2 align-items-stretch">
              <div class="col-12 col-md-3">
                <div class="nm-gf-field">
                  <label><i class="fas fa-map-marker-alt"></i>City</label>
                  <input type="text" id="nm-co-city" list="nm-city-list" autocomplete="off" placeholder="e.g. New York, Atlanta">
                </div>
              </div>
              <div class="col-6 col-md-3">
                <div class="nm-gf-field">
                  <label>Artist / Genre</label>
                  <input type="text" id="nm-co-kw" autocomplete="off" placeholder="e.g. Taylor Swift, Hip-Hop">
                </div>
              </div>
              <div class="col-6 col-md-2">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar"></i>Date</label>
                  <input type="date" id="nm-co-date" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-12 col-md-auto d-flex align-items-stretch" style="min-width:160px">
                <button type="button" class="nm-gf-btn" onclick="nmSearchConcerts()">
                  <i class="fas fa-search"></i> Find Events
                </button>
              </div>
            </div>
          </div>

          {{-- ── CARS ── --}}
          <div id="panel-cars" class="nm-gf-panel d-none">
            <div class="row g-2">
              <div class="col-12">
                <div class="nm-gf-field">
                  <label><i class="fas fa-map-marker-alt"></i>Pick-up Location</label>
                  <input type="text" id="nm-car-pickup" autocomplete="off" placeholder="City or airport…">
                </div>
              </div>
              <div class="col-6">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar"></i>Pick-up Date</label>
                  <input type="date" id="nm-car-from" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="nm-gf-field">
                  <label><i class="fas fa-calendar-check"></i>Return Date</label>
                  <input type="date" id="nm-car-to" min="{{ date('Y-m-d') }}">
                </div>
              </div>
              <div class="col-6">
                <div class="nm-gf-field">
                  <label><i class="fas fa-user"></i>Driver Age</label>
                  <select id="nm-car-age">
                    <option value="30" selected>25–65</option>
                    <option value="21">21–24</option>
                    <option value="70">66–99</option>
                  </select>
                </div>
              </div>
              <div class="col-12 d-flex align-items-stretch">
                <button type="button" class="nm-gf-btn" onclick="nmSearchCars(this)">
                  <i class="fas fa-search"></i> Search Cars
                </button>
              </div>
            </div>
          </div>

        </div>{{-- /nm-gf-box --}}
        </div>{{-- /nm-search-wrap --}}
      </div>
    </div>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════
     WE FLY WITH SECTION
═══════════════════════════════════════════════════ --}}
<section style="background:#fff; border-top:1px solid #edf0f7; border-bottom:1px solid #edf0f7; padding:28px 0;">
  <div class="container">
    <p style="text-align:center; font-family:'DM Sans',sans-serif; font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:3px; color:#bbb; margin-bottom:22px;">We Fly With</p>
    <div class="airline-logos">
      <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/AA.svg" alt="American Airlines" title="American Airlines">
      <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/F9.svg" alt="Frontier Airlines" title="Frontier Airlines">
      <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/B6.svg" alt="JetBlue" title="JetBlue">
      <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/AS.svg" alt="Alaska Airlines" title="Alaska Airlines">
      <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/UA.svg" alt="United Airlines" title="United Airlines (Coming Soon)" style="opacity:.85;">
      <img src="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/DL.svg" alt="Delta Air Lines" title="Delta Air Lines (Coming Soon)" style="opacity:.85;">
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════
     RESULTS SECTION
═══════════════════════════════════════════════════ --}}
<div id="nm-results" style="display:none">
  <div class="container py-5">
<div class="nm-results-inner" id="nm-results-html"></div>

  </div>
</div>

{{-- ═══════════════════════════════════════════════════
     BOOKING DRAWER
═══════════════════════════════════════════════════ --}}
<div id="nm-overlay" class="nm-overlay" onclick="nmCloseDrawer()"></div>
<div id="nm-drawer" class="nm-drawer">
  <div class="nm-drw-hdr">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <h5><i class="fas fa-ticket-alt me-2" style="color:var(--gold);"></i>Complete Booking</h5>
      <button class="nm-drw-close" onclick="nmCloseDrawer()">&times;</button>
    </div>
    <div id="nm-drw-sub" style="font-size:13px;opacity:.65;margin-top:6px;font-family:'DM Sans',sans-serif;"></div>
  </div>
  <div class="nm-drw-body">
    <div id="nm-drw-summary" class="nm-drw-summary"></div>
    <form id="nm-book-form" onsubmit="nmSubmitBooking(event)">
      <input type="hidden" id="bk-offer"><input type="hidden" id="bk-amt">
      <input type="hidden" id="bk-cur"><input type="hidden" id="bk-from">
      <input type="hidden" id="bk-to"><input type="hidden" id="bk-date">
      <p style="font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#aaa;margin-bottom:14px;">Passenger Details</p>
      <div class="row g-2">
        <div class="col-6"><div class="nm-df"><label>First Name *</label><input type="text" id="bk-fn" placeholder="John" required></div></div>
        <div class="col-6"><div class="nm-df"><label>Last Name *</label><input type="text" id="bk-ln" placeholder="Smith" required></div></div>
      </div>
      <div class="nm-df"><label>Email *</label><input type="email" id="bk-em" placeholder="john@example.com" required></div>
      <div class="nm-df"><label>Phone</label><input type="tel" id="bk-ph" placeholder="+1 (555) 000-0000"></div>
      <p style="font-family:'DM Sans',sans-serif;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#aaa;margin:20px 0 14px;">Payment</p>
      <div class="nm-df">
        <label>Card Details *</label>
        <div id="nm-card-el"></div>
        <div id="nm-card-err"></div>
      </div>
      <div id="nm-book-msg"></div>
      <button type="submit" class="nm-pay-btn" id="nm-pay-btn">
        <i class="fas fa-lock me-2"></i> Pay &amp; Confirm Booking
      </button>
      <p style="text-align:center;font-family:'DM Sans',sans-serif;font-size:11px;color:#ccc;margin-top:12px;">
        <i class="fas fa-shield-alt"></i> Secured by Stripe · SSL Encrypted
      </p>
    </form>
  </div>
</div>

</div>

{{-- ═══════════════════════════════════════════════════
     BOOKING DRAWER
═══════════════════════════════════════════════════ --}}
<div id="nm-overlay" class="nm-overlay" onclick="nmCloseDrawer()"></div>
<div id="nm-drawer" class="nm-drawer">
  <div class="nm-drw-hdr">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <h5>Complete Booking</h5>
      <button class="nm-drw-close" onclick="nmCloseDrawer()">&times;</button>
    </div>
    <div id="nm-drw-sub" style="font-size:13px;opacity:.75;margin-top:6px;"></div>
  </div>
  <div class="nm-drw-body">
    <div id="nm-drw-summary" class="nm-drw-summary"></div>

    <form id="nm-book-form" onsubmit="nmSubmitBooking(event)">
      <input type="hidden" id="bk-offer"><input type="hidden" id="bk-amt">
      <input type="hidden" id="bk-cur"><input type="hidden" id="bk-from">
      <input type="hidden" id="bk-to"><input type="hidden" id="bk-date">

      <p style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;color:#0a1628;margin-bottom:12px;">Passenger Details</p>
      <div class="row g-2">
        <div class="col-6"><div class="nm-df"><label>First Name *</label><input type="text" id="bk-fn" placeholder="John" required></div></div>
        <div class="col-6"><div class="nm-df"><label>Last Name *</label><input type="text" id="bk-ln" placeholder="Smith" required></div></div>
      </div>
      <div class="nm-df"><label>Email *</label><input type="email" id="bk-em" placeholder="john@example.com" required></div>
      <div class="nm-df"><label>Phone</label><input type="tel" id="bk-ph" placeholder="+1 (555) 000-0000"></div>

      <p style="font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;color:#0a1628;margin:18px 0 12px;">Payment</p>
      <div class="nm-df">
        <label>Card Details *</label>
        <div id="nm-card-el"></div>
        <div id="nm-card-err"></div>
      </div>

      <div id="nm-book-msg"></div>
      <button type="submit" class="nm-pay-btn" id="nm-pay-btn">
        <i class="fas fa-lock me-2"></i> Pay &amp; Confirm Booking
      </button>
      <p style="text-align:center;font-size:11px;color:#bbb;margin-top:10px;">
        <i class="fas fa-shield-alt"></i> Secured by Stripe · SSL Encrypted
      </p>
    </form>
  </div>
</div>

{{-- Airport data removed — live Duffel Places API used instead --}}
<script>
window.NM_AIRPORTS_STUB = [
  /* ── USA ── */
  {c:'JFK',n:'New York JFK',city:'New York',country:'US',type:'large'},
  {c:'EWR',n:'New York Newark',city:'New York',country:'US',type:'large'},
  {c:'LGA',n:'New York LaGuardia',city:'New York',country:'US',type:'large'},
  {c:'LAX',n:'Los Angeles',city:'Los Angeles',country:'US',type:'large'},
  {c:'ORD',n:"Chicago O'Hare",city:'Chicago',country:'US',type:'large'},
  {c:'MDW',n:'Chicago Midway',city:'Chicago',country:'US',type:'medium'},
  {c:'ATL',n:'Atlanta Hartsfield',city:'Atlanta',country:'US',type:'large'},
  {c:'DFW',n:'Dallas Fort Worth',city:'Dallas',country:'US',type:'large'},
  {c:'DAL',n:'Dallas Love Field',city:'Dallas',country:'US',type:'medium'},
  {c:'MIA',n:'Miami International',city:'Miami',country:'US',type:'large'},
  {c:'FLL',n:'Fort Lauderdale',city:'Fort Lauderdale',country:'US',type:'large'},
  {c:'SFO',n:'San Francisco',city:'San Francisco',country:'US',type:'large'},
  {c:'SEA',n:'Seattle-Tacoma',city:'Seattle',country:'US',type:'large'},
  {c:'BOS',n:'Boston Logan',city:'Boston',country:'US',type:'large'},
  {c:'DEN',n:'Denver International',city:'Denver',country:'US',type:'large'},
  {c:'LAS',n:'Las Vegas McCarran',city:'Las Vegas',country:'US',type:'large'},
  {c:'IAH',n:'Houston Bush',city:'Houston',country:'US',type:'large'},
  {c:'HOU',n:'Houston Hobby',city:'Houston',country:'US',type:'medium'},
  {c:'PHX',n:'Phoenix Sky Harbor',city:'Phoenix',country:'US',type:'large'},
  {c:'MCO',n:'Orlando International',city:'Orlando',country:'US',type:'large'},
  {c:'MSP',n:'Minneapolis-St Paul',city:'Minneapolis',country:'US',type:'large'},
  {c:'DTW',n:'Detroit Metropolitan',city:'Detroit',country:'US',type:'large'},
  {c:'PHL',n:'Philadelphia Intl',city:'Philadelphia',country:'US',type:'large'},
  {c:'IAD',n:'Washington Dulles',city:'Washington DC',country:'US',type:'large'},
  {c:'DCA',n:'Washington Reagan',city:'Washington DC',country:'US',type:'large'},
  {c:'BWI',n:'Baltimore Washington',city:'Baltimore',country:'US',type:'large'},
  {c:'CLT',n:'Charlotte Douglas',city:'Charlotte',country:'US',type:'large'},
  {c:'SLC',n:'Salt Lake City',city:'Salt Lake City',country:'US',type:'large'},
  {c:'SAN',n:'San Diego International',city:'San Diego',country:'US',type:'large'},
  {c:'PDX',n:'Portland International',city:'Portland',country:'US',type:'large'},
  {c:'AUS',n:'Austin-Bergstrom',city:'Austin',country:'US',type:'large'},
  {c:'BNA',n:'Nashville International',city:'Nashville',country:'US',type:'large'},
  {c:'RDU',n:'Raleigh-Durham',city:'Raleigh',country:'US',type:'large'},
  {c:'TPA',n:'Tampa International',city:'Tampa',country:'US',type:'large'},
  {c:'STL',n:'St. Louis Lambert',city:'St. Louis',country:'US',type:'large'},
  {c:'MCI',n:'Kansas City Intl',city:'Kansas City',country:'US',type:'large'},
  {c:'MSY',n:'New Orleans Louis Armstrong',city:'New Orleans',country:'US',type:'large'},
  {c:'SMF',n:'Sacramento International',city:'Sacramento',country:'US',type:'large'},
  {c:'SJC',n:'San Jose International',city:'San Jose',country:'US',type:'large'},
  {c:'OAK',n:'Oakland International',city:'Oakland',country:'US',type:'medium'},
  {c:'HNL',n:'Honolulu International',city:'Honolulu',country:'US',type:'large'},
  {c:'OGG',n:'Maui Kahului',city:'Maui',country:'US',type:'medium'},
  {c:'KOA',n:'Kona International',city:'Kona',country:'US',type:'medium'},
  {c:'ANC',n:'Anchorage Ted Stevens',city:'Anchorage',country:'US',type:'large'},
  {c:'FAI',n:'Fairbanks International',city:'Fairbanks',country:'US',type:'medium'},
  {c:'ABQ',n:'Albuquerque Sunport',city:'Albuquerque',country:'US',type:'medium'},
  {c:'BUF',n:'Buffalo Niagara',city:'Buffalo',country:'US',type:'medium'},
  {c:'CLE',n:'Cleveland Hopkins',city:'Cleveland',country:'US',type:'large'},
  {c:'CMH',n:'Columbus International',city:'Columbus',country:'US',type:'large'},
  {c:'CVG',n:'Cincinnati/N Kentucky',city:'Cincinnati',country:'US',type:'large'},
  {c:'IND',n:'Indianapolis International',city:'Indianapolis',country:'US',type:'large'},
  {c:'MKE',n:'Milwaukee Mitchell',city:'Milwaukee',country:'US',type:'large'},
  {c:'ORF',n:'Norfolk International',city:'Norfolk',country:'US',type:'medium'},
  {c:'RIC',n:'Richmond International',city:'Richmond',country:'US',type:'medium'},
  {c:'SDF',n:'Louisville Muhammad Ali',city:'Louisville',country:'US',type:'medium'},
  {c:'OKC',n:'Oklahoma City Will Rogers',city:'Oklahoma City',country:'US',type:'medium'},
  {c:'TUL',n:'Tulsa International',city:'Tulsa',country:'US',type:'medium'},
  {c:'MEM',n:'Memphis International',city:'Memphis',country:'US',type:'large'},
  {c:'BHM',n:'Birmingham-Shuttlesworth',city:'Birmingham',country:'US',type:'medium'},
  {c:'JAX',n:'Jacksonville International',city:'Jacksonville',country:'US',type:'large'},
  {c:'SAV',n:'Savannah/Hilton Head',city:'Savannah',country:'US',type:'medium'},
  {c:'CHS',n:'Charleston International',city:'Charleston',country:'US',type:'medium'},
  {c:'GSP',n:'Greenville-Spartanburg',city:'Greenville',country:'US',type:'medium'},
  {c:'PBI',n:'Palm Beach International',city:'West Palm Beach',country:'US',type:'large'},
  {c:'RSW',n:'Fort Myers Southwest Florida',city:'Fort Myers',country:'US',type:'large'},
  {c:'SRQ',n:'Sarasota-Bradenton',city:'Sarasota',country:'US',type:'medium'},
  {c:'ELP',n:'El Paso International',city:'El Paso',country:'US',type:'medium'},
  {c:'SAT',n:'San Antonio International',city:'San Antonio',country:'US',type:'large'},
  {c:'GRR',n:'Grand Rapids Gerald R Ford',city:'Grand Rapids',country:'US',type:'medium'},
  {c:'OMA',n:'Omaha Eppley',city:'Omaha',country:'US',type:'medium'},
  {c:'DSM',n:'Des Moines International',city:'Des Moines',country:'US',type:'medium'},
  {c:'MSN',n:'Madison Dane County',city:'Madison',country:'US',type:'medium'},
  {c:'BOI',n:'Boise Airport',city:'Boise',country:'US',type:'medium'},
  {c:'BZN',n:'Bozeman Yellowstone',city:'Bozeman',country:'US',type:'medium'},
  {c:'JAC',n:'Jackson Hole',city:'Jackson',country:'US',type:'medium'},
  {c:'GEG',n:'Spokane International',city:'Spokane',country:'US',type:'medium'},
  {c:'MHT',n:'Manchester-Boston Regional',city:'Manchester',country:'US',type:'medium'},
  {c:'PVD',n:'Providence T.F. Green',city:'Providence',country:'US',type:'medium'},
  {c:'ALB',n:'Albany International',city:'Albany',country:'US',type:'medium'},
  {c:'SYR',n:'Syracuse Hancock',city:'Syracuse',country:'US',type:'medium'},
  /* ── Caribbean ── */
  {c:'CUN',n:'Cancun International',city:'Cancun',country:'MX',type:'large'},
  {c:'PUJ',n:'Punta Cana International',city:'Punta Cana',country:'DO',type:'large'},
  {c:'MBJ',n:'Montego Bay Sangster',city:'Montego Bay',country:'JM',type:'large'},
  {c:'KIN',n:'Kingston Norman Manley',city:'Kingston',country:'JM',type:'medium'},
  {c:'NAS',n:'Nassau Lynden Pindling',city:'Nassau',country:'BS',type:'large'},
  {c:'FPO',n:'Freeport Grand Bahama',city:'Freeport',country:'BS',type:'medium'},
  {c:'AUA',n:'Aruba Queen Beatrix',city:'Oranjestad',country:'AW',type:'large'},
  {c:'CUR',n:'Curacao Hato',city:'Willemstad',country:'CW',type:'medium'},
  {c:'SJU',n:'San Juan Luis Munoz Marin',city:'San Juan',country:'PR',type:'large'},
  {c:'STT',n:'St. Thomas Cyril E. King',city:'Charlotte Amalie',country:'VI',type:'medium'},
  {c:'STX',n:'St. Croix Henry E Rohlsen',city:'St. Croix',country:'VI',type:'medium'},
  {c:'BDA',n:'Bermuda L.F. Wade Intl',city:'Bermuda',country:'BM',type:'medium'},
  {c:'BGI',n:'Bridgetown Barbados Grantley Adams',city:'Bridgetown',country:'BB',type:'medium'},
  {c:'GCM',n:'Grand Cayman Owen Roberts',city:'George Town',country:'KY',type:'medium'},
  {c:'POS',n:'Port of Spain Piarco',city:'Port of Spain',country:'TT',type:'medium'},
  /* ── Mexico ── */
  {c:'MEX',n:'Mexico City Benito Juarez',city:'Mexico City',country:'MX',type:'large'},
  {c:'SJD',n:'Los Cabos International',city:'Cabo San Lucas',country:'MX',type:'large'},
  {c:'GDL',n:'Guadalajara Miguel Hidalgo',city:'Guadalajara',country:'MX',type:'large'},
  {c:'MTY',n:'Monterrey General Mariano Escobedo',city:'Monterrey',country:'MX',type:'large'},
  {c:'MZT',n:'Mazatlan Rafael Buelna',city:'Mazatlan',country:'MX',type:'medium'},
  {c:'PVR',n:'Puerto Vallarta Gustavo Diaz Ordaz',city:'Puerto Vallarta',country:'MX',type:'large'},
  {c:'ZIH',n:'Ixtapa-Zihuatanejo',city:'Zihuatanejo',country:'MX',type:'medium'},
  {c:'HUX',n:'Huatulco Bahias',city:'Huatulco',country:'MX',type:'medium'},
  {c:'MID',n:'Merida Manuel Crescencio Rejon',city:'Merida',country:'MX',type:'medium'},
  /* ── Canada ── */
  {c:'YYZ',n:'Toronto Pearson',city:'Toronto',country:'CA',type:'large'},
  {c:'YVR',n:'Vancouver International',city:'Vancouver',country:'CA',type:'large'},
  {c:'YUL',n:'Montreal Trudeau',city:'Montreal',country:'CA',type:'large'},
  {c:'YYC',n:'Calgary International',city:'Calgary',country:'CA',type:'large'},
  {c:'YEG',n:'Edmonton International',city:'Edmonton',country:'CA',type:'large'},
  {c:'YOW',n:'Ottawa Macdonald-Cartier',city:'Ottawa',country:'CA',type:'large'},
  {c:'YHZ',n:'Halifax Stanfield',city:'Halifax',country:'CA',type:'medium'},
  {c:'YWG',n:'Winnipeg Richardson',city:'Winnipeg',country:'CA',type:'medium'},
  {c:'YXE',n:'Saskatoon John G. Diefenbaker',city:'Saskatoon',country:'CA',type:'medium'},
  /* ── Europe ── */
  {c:'LHR',n:'London Heathrow',city:'London',country:'GB',type:'large'},
  {c:'LGW',n:'London Gatwick',city:'London',country:'GB',type:'large'},
  {c:'STN',n:'London Stansted',city:'London',country:'GB',type:'large'},
  {c:'CDG',n:'Paris Charles de Gaulle',city:'Paris',country:'FR',type:'large'},
  {c:'ORY',n:'Paris Orly',city:'Paris',country:'FR',type:'large'},
  {c:'AMS',n:'Amsterdam Schiphol',city:'Amsterdam',country:'NL',type:'large'},
  {c:'FRA',n:'Frankfurt International',city:'Frankfurt',country:'DE',type:'large'},
  {c:'MUC',n:'Munich International',city:'Munich',country:'DE',type:'large'},
  {c:'FCO',n:'Rome Fiumicino',city:'Rome',country:'IT',type:'large'},
  {c:'MXP',n:'Milan Malpensa',city:'Milan',country:'IT',type:'large'},
  {c:'BCN',n:'Barcelona El Prat',city:'Barcelona',country:'ES',type:'large'},
  {c:'MAD',n:'Madrid Barajas',city:'Madrid',country:'ES',type:'large'},
  {c:'LIS',n:'Lisbon Humberto Delgado',city:'Lisbon',country:'PT',type:'large'},
  {c:'ZRH',n:'Zurich Airport',city:'Zurich',country:'CH',type:'large'},
  {c:'GVA',n:'Geneva International',city:'Geneva',country:'CH',type:'large'},
  {c:'VIE',n:'Vienna International',city:'Vienna',country:'AT',type:'large'},
  {c:'BRU',n:'Brussels International',city:'Brussels',country:'BE',type:'large'},
  {c:'CPH',n:'Copenhagen Kastrup',city:'Copenhagen',country:'DK',type:'large'},
  {c:'OSL',n:'Oslo Gardermoen',city:'Oslo',country:'NO',type:'large'},
  {c:'ARN',n:'Stockholm Arlanda',city:'Stockholm',country:'SE',type:'large'},
  {c:'HEL',n:'Helsinki Vantaa',city:'Helsinki',country:'FI',type:'large'},
  {c:'WAW',n:'Warsaw Chopin',city:'Warsaw',country:'PL',type:'large'},
  {c:'PRG',n:'Prague Vaclav Havel',city:'Prague',country:'CZ',type:'large'},
  {c:'BUD',n:'Budapest Ferenc Liszt',city:'Budapest',country:'HU',type:'large'},
  {c:'ATH',n:'Athens Eleftherios Venizelos',city:'Athens',country:'GR',type:'large'},
  {c:'SKG',n:'Thessaloniki Macedonia',city:'Thessaloniki',country:'GR',type:'medium'},
  {c:'DBV',n:'Dubrovnik Airport',city:'Dubrovnik',country:'HR',type:'medium'},
  {c:'IST',n:'Istanbul Airport',city:'Istanbul',country:'TR',type:'large'},
  {c:'SAW',n:'Istanbul Sabiha Gokcen',city:'Istanbul',country:'TR',type:'large'},
  {c:'DUB',n:'Dublin Airport',city:'Dublin',country:'IE',type:'large'},
  {c:'EDI',n:'Edinburgh Airport',city:'Edinburgh',country:'GB',type:'large'},
  {c:'MAN',n:'Manchester Airport',city:'Manchester',country:'GB',type:'large'},
  {c:'BHX',n:'Birmingham Airport',city:'Birmingham',country:'GB',type:'large'},
  /* ── Middle East ── */
  {c:'DXB',n:'Dubai International',city:'Dubai',country:'AE',type:'large'},
  {c:'AUH',n:'Abu Dhabi International',city:'Abu Dhabi',country:'AE',type:'large'},
  {c:'DOH',n:'Doha Hamad International',city:'Doha',country:'QA',type:'large'},
  {c:'RUH',n:'Riyadh King Khalid',city:'Riyadh',country:'SA',type:'large'},
  {c:'JED',n:'Jeddah King Abdulaziz',city:'Jeddah',country:'SA',type:'large'},
  {c:'KWI',n:'Kuwait International',city:'Kuwait City',country:'KW',type:'large'},
  {c:'BAH',n:'Bahrain International',city:'Manama',country:'BH',type:'large'},
  {c:'AMM',n:'Amman Queen Alia',city:'Amman',country:'JO',type:'large'},
  {c:'TLV',n:'Tel Aviv Ben Gurion',city:'Tel Aviv',country:'IL',type:'large'},
  {c:'CAI',n:'Cairo International',city:'Cairo',country:'EG',type:'large'},
  /* ── Asia Pacific ── */
  {c:'NRT',n:'Tokyo Narita',city:'Tokyo',country:'JP',type:'large'},
  {c:'HND',n:'Tokyo Haneda',city:'Tokyo',country:'JP',type:'large'},
  {c:'KIX',n:'Osaka Kansai',city:'Osaka',country:'JP',type:'large'},
  {c:'ICN',n:'Seoul Incheon',city:'Seoul',country:'KR',type:'large'},
  {c:'PEK',n:'Beijing Capital',city:'Beijing',country:'CN',type:'large'},
  {c:'PKX',n:'Beijing Daxing',city:'Beijing',country:'CN',type:'large'},
  {c:'PVG',n:'Shanghai Pudong',city:'Shanghai',country:'CN',type:'large'},
  {c:'SHA',n:'Shanghai Hongqiao',city:'Shanghai',country:'CN',type:'large'},
  {c:'HKG',n:'Hong Kong International',city:'Hong Kong',country:'HK',type:'large'},
  {c:'SIN',n:'Singapore Changi',city:'Singapore',country:'SG',type:'large'},
  {c:'BKK',n:'Bangkok Suvarnabhumi',city:'Bangkok',country:'TH',type:'large'},
  {c:'DMK',n:'Bangkok Don Mueang',city:'Bangkok',country:'TH',type:'large'},
  {c:'KUL',n:'Kuala Lumpur International',city:'Kuala Lumpur',country:'MY',type:'large'},
  {c:'CGK',n:'Jakarta Soekarno-Hatta',city:'Jakarta',country:'ID',type:'large'},
  {c:'SYD',n:'Sydney Kingsford Smith',city:'Sydney',country:'AU',type:'large'},
  {c:'MEL',n:'Melbourne International',city:'Melbourne',country:'AU',type:'large'},
  {c:'BNE',n:'Brisbane International',city:'Brisbane',country:'AU',type:'large'},
  {c:'PER',n:'Perth Airport',city:'Perth',country:'AU',type:'large'},
  {c:'AKL',n:'Auckland International',city:'Auckland',country:'NZ',type:'large'},
  {c:'CHC',n:'Christchurch International',city:'Christchurch',country:'NZ',type:'medium'},
  {c:'DEL',n:'Delhi Indira Gandhi',city:'Delhi',country:'IN',type:'large'},
  {c:'BOM',n:'Mumbai Chhatrapati Shivaji',city:'Mumbai',country:'IN',type:'large'},
  {c:'BLR',n:'Bangalore Kempegowda',city:'Bangalore',country:'IN',type:'large'},
  {c:'MAA',n:'Chennai International',city:'Chennai',country:'IN',type:'large'},
  {c:'HYD',n:'Hyderabad Rajiv Gandhi',city:'Hyderabad',country:'IN',type:'large'},
  {c:'MNL',n:'Manila Ninoy Aquino',city:'Manila',country:'PH',type:'large'},
  {c:'CEB',n:'Cebu Mactan',city:'Cebu',country:'PH',type:'medium'},
  {c:'SGN',n:'Ho Chi Minh City Tan Son Nhat',city:'Ho Chi Minh City',country:'VN',type:'large'},
  {c:'HAN',n:'Hanoi Noi Bai',city:'Hanoi',country:'VN',type:'large'},
  /* ── Latin America ── */
  {c:'BOG',n:'Bogota El Dorado',city:'Bogota',country:'CO',type:'large'},
  {c:'MDE',n:'Medellin Jose Maria Cordova',city:'Medellin',country:'CO',type:'large'},
  {c:'LIM',n:'Lima Jorge Chavez',city:'Lima',country:'PE',type:'large'},
  {c:'SCL',n:'Santiago Arturo Merino Benitez',city:'Santiago',country:'CL',type:'large'},
  {c:'EZE',n:'Buenos Aires Ezeiza',city:'Buenos Aires',country:'AR',type:'large'},
  {c:'AEP',n:'Buenos Aires Aeroparque',city:'Buenos Aires',country:'AR',type:'medium'},
  {c:'GRU',n:'Sao Paulo Guarulhos',city:'Sao Paulo',country:'BR',type:'large'},
  {c:'CGH',n:'Sao Paulo Congonhas',city:'Sao Paulo',country:'BR',type:'medium'},
  {c:'GIG',n:'Rio de Janeiro Galeao',city:'Rio de Janeiro',country:'BR',type:'large'},
  {c:'BSB',n:'Brasilia International',city:'Brasilia',country:'BR',type:'large'},
  {c:'UIO',n:'Quito Mariscal Sucre',city:'Quito',country:'EC',type:'large'},
  {c:'GYE',n:'Guayaquil Jose Joaquin de Olmedo',city:'Guayaquil',country:'EC',type:'large'},
  {c:'ASU',n:'Asuncion Silvio Pettirossi',city:'Asuncion',country:'PY',type:'medium'},
  {c:'MVD',n:'Montevideo Carrasco',city:'Montevideo',country:'UY',type:'medium'},
  {c:'PTY',n:'Panama City Tocumen',city:'Panama City',country:'PA',type:'large'},
  {c:'SJO',n:'San Jose Juan Santamaria',city:'San Jose',country:'CR',type:'large'},
  {c:'SAL',n:'San Salvador Monsenor Romero',city:'San Salvador',country:'SV',type:'medium'},
  {c:'GUA',n:'Guatemala City La Aurora',city:'Guatemala City',country:'GT',type:'medium'},
  {c:'TGU',n:'Tegucigalpa Toncontin',city:'Tegucigalpa',country:'HN',type:'medium'},
  {c:'MGA',n:'Managua Augusto Sandino',city:'Managua',country:'NI',type:'medium'},
  /* ── Africa ── */
  {c:'JNB',n:'Johannesburg OR Tambo',city:'Johannesburg',country:'ZA',type:'large'},
  {c:'CPT',n:'Cape Town International',city:'Cape Town',country:'ZA',type:'large'},
  {c:'NBO',n:'Nairobi Jomo Kenyatta',city:'Nairobi',country:'KE',type:'large'},
  {c:'ADD',n:'Addis Ababa Bole',city:'Addis Ababa',country:'ET',type:'large'},
  {c:'LOS',n:'Lagos Murtala Muhammed',city:'Lagos',country:'NG',type:'large'},
  {c:'ACC',n:'Accra Kotoka',city:'Accra',country:'GH',type:'large'},
  {c:'CMN',n:'Casablanca Mohammed V',city:'Casablanca',country:'MA',type:'large'},
  {c:'RAK',n:'Marrakech Menara',city:'Marrakech',country:'MA',type:'medium'},
  {c:'TUN',n:'Tunis Carthage',city:'Tunis',country:'TN',type:'medium'},
  {c:'ALG',n:'Algiers Houari Boumediene',city:'Algiers',country:'DZ',type:'large'},
];
</script>

<datalist id="nm-city-list">
  <option value="New York"><option value="Los Angeles"><option value="Chicago"><option value="Miami">
  <option value="Las Vegas"><option value="Dallas"><option value="Houston"><option value="Atlanta">
  <option value="San Francisco"><option value="Seattle"><option value="Boston"><option value="Denver">
  <option value="Phoenix"><option value="Orlando"><option value="Nashville"><option value="Austin">
  <option value="Washington DC"><option value="Philadelphia"><option value="Charlotte"><option value="Portland">
  <option value="Minneapolis"><option value="Detroit"><option value="Tampa"><option value="New Orleans">
  <option value="Kansas City"><option value="Baltimore"><option value="San Diego"><option value="Honolulu">
  <option value="London"><option value="Paris"><option value="Dubai"><option value="Toronto">
  <option value="Cancun"><option value="Barcelona"><option value="Amsterdam">
</datalist>

@push('js')
<script>
// ── Adults stepper ──
function nmStep(id, delta) {
    var el = document.getElementById(id);
    if (!el) return;
    var minVal = parseInt(el.getAttribute('min') ?? '1', 10);
    var maxVal = parseInt(el.getAttribute('max') ?? '9', 10);
    var v = parseInt(el.value || minVal) + delta;
    el.value = Math.min(maxVal, Math.max(minVal, v));
}

/* ═══════════════════════════════════════════════════════
   NOMALY TRAVEL — Google Flights Style Homepage v2
   Fixes: placeholder clash with layout nmSearch,
          type=button, smooth animation, price calendar
═══════════════════════════════════════════════════════ */

// ── Tab switching ──────────────────────────────────
function nmTab(t) {
    document.querySelectorAll('.nm-gf-tab').forEach(function(b){b.classList.remove('active');});
    document.querySelectorAll('.nm-gf-panel').forEach(function(p){p.classList.add('d-none');});
    document.querySelector('[data-tab="'+t+'"]').classList.add('active');
    document.getElementById('panel-'+t).classList.remove('d-none');
    document.getElementById('nm-results').style.display = 'none';
}

// ── Trip type ──────────────────────────────────────
document.querySelectorAll('input[name="nm_trip"]').forEach(function(r){
    r.addEventListener('change', function(){
        document.getElementById('nm-ret-col').style.display = this.value==='twoway' ? '' : 'none';
    });
});

// Enter key triggers search in flight inputs
['nm-from','nm-to','nm-depart','nm-return'].forEach(function(id){
    var el = document.getElementById(id);
    if (el) el.addEventListener('keydown', function(e){ if(e.key==='Enter'){e.preventDefault();nmSearchFlights();} });
});

// ── IATA extraction ────────────────────────────────
// Tries to pull a 3-letter IATA code from the end of user input
// e.g. "Chicago ORD" -> "ORD", "JFK" -> "JFK", "New York JFK (New York)" -> "JFK"
function nmIATA(raw) {
    var v = (raw||'').trim().toUpperCase();
    // Direct 3-letter code typed alone
    if (/^[A-Z]{3}$/.test(v)) return v;
    // Code at end: "Chicago ORD" or "Chicago ORD O Hare" -> last 3-letter word
    var m = v.match(/\b([A-Z]{3})\b(?:\s*[\(\)][^)]*\)?\s*)*$/);
    if (m) return m[1];
    // Code in parentheses: "Chicago (ORD)"
    m = v.match(/\(([A-Z]{3})\)/);
    if (m) return m[1];
    return '';
}

// ════════════════════════════════════════════════════════
// AIRPORT AUTOCOMPLETE — live Duffel Places API (3,500+ airports)
// ════════════════════════════════════════════════════════
var NM_FLAGS = {
    'United States':'🇺🇸','Canada':'🇨🇦','Mexico':'🇲🇽','United Kingdom':'🇬🇧',
    'France':'🇫🇷','Germany':'🇩🇪','Spain':'🇪🇸','Italy':'🇮🇹','Netherlands':'🇳🇱',
    'Australia':'🇦🇺','Japan':'🇯🇵','China':'🇨🇳','Singapore':'🇸🇬',
    'United Arab Emirates':'🇦🇪','India':'🇮🇳','Brazil':'🇧🇷','Argentina':'🇦🇷',
    'Colombia':'🇨🇴','Dominican Republic':'🇩🇴','Jamaica':'🇯🇲','Bahamas':'🇧🇸',
    'Aruba':'🇦🇼','Puerto Rico':'🇵🇷','Hong Kong':'🇭🇰','South Korea':'🇰🇷',
    'Thailand':'🇹🇭','Turkey':'🇹🇷','Qatar':'🇶🇦','Saudi Arabia':'🇸🇦',
    'South Africa':'🇿🇦','Kenya':'🇰🇪','Nigeria':'🇳🇬','Morocco':'🇲🇦',
    'Egypt':'🇪🇬','Portugal':'🇵🇹','Switzerland':'🇨🇭','Austria':'🇦🇹',
    'Belgium':'🇧🇪','Denmark':'🇩🇰','Sweden':'🇸🇪','Norway':'🇳🇴',
    'Finland':'🇫🇮','Poland':'🇵🇱','Greece':'🇬🇷','Czech Republic':'🇨🇿',
    'Hungary':'🇭🇺','Philippines':'🇵🇭','Vietnam':'🇻🇳','Malaysia':'🇲🇾',
    'Indonesia':'🇮🇩','New Zealand':'🇳🇿','Israel':'🇮🇱','Jordan':'🇯🇴',
    'Kuwait':'🇰🇼','Peru':'🇵🇪','Chile':'🇨🇱','Panama':'🇵🇦',
    'Costa Rica':'🇨🇷','Ecuador':'🇪🇨','Uruguay':'🇺🇾','Croatia':'🇭🇷',
    'Ireland':'🇮🇪','Ethiopia':'🇪🇹','Ghana':'🇬🇭','Tunisia':'🇹🇳'
};

function nmGetFlag(country) {
    return NM_FLAGS[country] || '✈️';
}

function nmACRender(dropEl, items) {
    if (!items || !items.length) {
        dropEl.innerHTML = '<div class="nm-ac-no-results"><i class="fas fa-plane" style="color:#c9a84c;margin-right:8px;"></i>No airports found — try a city name or code</div>';
        dropEl.classList.add('open');
        return;
    }

    // Group items into city buckets preserving order
    var groups = [];
    items.forEach(function(r) {
        if (r.type === 'city') {
            groups.push({ city: r, airports: [] });
        } else {
            if (groups.length) {
                groups[groups.length - 1].airports.push(r);
            } else {
                groups.push({ city: null, airports: [r] });
            }
        }
    });

    var html = '';
    var aptIdx = 0;

    groups.forEach(function(g) {
        if (g.city) {
            // Non-clickable city header label
            html += '<div class="nm-ac-item nm-ac-item-city" style="pointer-events:none;opacity:0.7;padding:7px 16px 4px;">'
                 + '<span class="nm-ac-icon nm-ac-icon-city"><i class="fas fa-map-marker-alt"></i></span>'
                 + '<span class="nm-ac-text"><div class="nm-ac-name" style="font-size:12px;font-weight:900;text-transform:uppercase;letter-spacing:.5px;">'
                 + nmEsc(g.city.name) + (g.city.country ? ' &mdash; ' + nmEsc(g.city.country) : '')
                 + '</div></span></div>';

            // Only include airports that actually belong to this city (prevents
            // unrelated airports like CNX/Chiang Mai from slipping into Chicago's group)
            var cityName = (g.city.name || '').toLowerCase();
            var matchedApts = g.airports.filter(function(a) {
                return (a.city || '').toLowerCase() === cityName;
            }).slice(0, 2); // cap at 2 per city — max 4 parallel API calls (2×2)

            // "All Airports" row only when 2+ verified airports exist
            if (matchedApts.length > 1) {
                var allCodes = matchedApts.map(function(a){ return a.code; }).join(',');
                var codeList = matchedApts.map(function(a){ return a.code; }).join(', ');
                var allLabel = g.city.name + ' — All Airports (' + codeList + ')';
                html += '<div class="nm-ac-item nm-ac-item-all" data-code="' + allCodes + '" data-label="' + allLabel.replace(/"/g,'&quot;') + '" data-idx="' + aptIdx + '" style="background:linear-gradient(90deg,rgba(201,168,76,.08),transparent);border-left:3px solid var(--gold);">'
                     + '<span class="nm-ac-icon nm-ac-icon-apt" style="font-size:16px;">✈️</span>'
                     + '<span class="nm-ac-text">'
                     + '<div class="nm-ac-name" style="font-weight:700;">All Airports &mdash; ' + nmEsc(g.city.name) + '</div>'
                     + '<div class="nm-ac-sub">' + nmEsc(codeList) + '</div>'
                     + '</span>'
                     + '<span class="nm-ac-code" style="font-size:10px;letter-spacing:.5px;">ALL</span>'
                     + '</div>';
                aptIdx++;
            }
        }

        g.airports.forEach(function(r) {
            var flag = nmGetFlag(r.country);
            html += '<div class="nm-ac-item" data-code="' + r.code + '" data-label="' + r.city.replace(/"/g,'&quot;') + ' (' + r.code + ')" data-idx="' + aptIdx + '">'
                 + '<span class="nm-ac-icon nm-ac-icon-apt">' + flag + '</span>'
                 + '<span class="nm-ac-text">'
                 + '<div class="nm-ac-name">' + nmEsc(r.city || r.name) + '</div>'
                 + '<div class="nm-ac-sub">' + nmEsc(r.name) + (r.country ? ' &bull; ' + nmEsc(r.country) : '') + '</div>'
                 + '</span>'
                 + '<span class="nm-ac-code">' + r.code + '</span>'
                 + '</div>';
            aptIdx++;
        });
    });

    dropEl.innerHTML = html;
    dropEl.classList.add('open');
}

function nmEsc(s) {
    return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function nmSetupAC(inputId, codeId, dropId) {
    var inp  = document.getElementById(inputId);
    var cod  = document.getElementById(codeId);
    var drop = document.getElementById(dropId);
    if (!inp || !cod || !drop) return;

    var debounce, activeIdx = -1;

    function closeAC() { drop.classList.remove('open'); activeIdx = -1; }

    function selectItem(code, label) {
        inp.value = label;
        cod.value = code;
        closeAC();
        inp.dispatchEvent(new Event('nm-selected'));
    }

    function bindItems() {
        drop.querySelectorAll('.nm-ac-item[data-code]').forEach(function(el) {
            el.addEventListener('mousedown', function(e) {
                e.preventDefault();
                selectItem(this.dataset.code, this.dataset.label);
            });
            el.addEventListener('touchstart', function(e) {
                e.preventDefault();
                selectItem(this.dataset.code, this.dataset.label);
            }, {passive: false});
        });
    }

    function setActive(idx) {
        var items = drop.querySelectorAll('.nm-ac-item[data-code]');
        items.forEach(function(el){ el.classList.remove('active'); });
        if (idx >= 0 && idx < items.length) {
            items[idx].classList.add('active');
            items[idx].scrollIntoView({block:'nearest'});
        }
        activeIdx = idx;
    }

    function fetchAndRender(q) {
        // Show spinner immediately
        drop.innerHTML = '<div class="nm-ac-no-results"><i class="fas fa-circle-notch fa-spin" style="color:#c9a84c;margin-right:8px;"></i>Searching airports&hellip;</div>';
        drop.classList.add('open');

        fetch('/api/airports?q=' + encodeURIComponent(q))
        .then(function(r) { return r.json(); })
        .then(function(data) {
            nmACRender(drop, data);
            bindItems();
            activeIdx = -1;
        })
        .catch(function() {
            drop.innerHTML = '<div class="nm-ac-no-results">Could not load suggestions. Type an IATA code directly (e.g. ORD).</div>';
            drop.classList.add('open');
        });
    }

    inp.addEventListener('input', function() {
        clearTimeout(debounce);
        cod.value = '';
        var q = this.value.trim();
        if (q.length < 1) { closeAC(); return; }

        // Debounce: 220ms — feels instant, avoids hammering API on every keystroke
        debounce = setTimeout(function() { fetchAndRender(q); }, 220);
    });

    inp.addEventListener('keydown', function(e) {
        if (!drop.classList.contains('open')) return;
        var items = drop.querySelectorAll('.nm-ac-item[data-code]');
        if (e.key === 'ArrowDown') {
            e.preventDefault(); setActive(Math.min(activeIdx + 1, items.length - 1));
        } else if (e.key === 'ArrowUp') {
            e.preventDefault(); setActive(Math.max(activeIdx - 1, 0));
        } else if (e.key === 'Enter') {
            if (activeIdx >= 0 && items[activeIdx]) {
                e.preventDefault();
                selectItem(items[activeIdx].dataset.code, items[activeIdx].dataset.label);
            }
        } else if (e.key === 'Escape') {
            closeAC();
        }
    });

    inp.addEventListener('blur', function() {
        setTimeout(function() {
            if (!cod.value) {
                var c = nmIATA(inp.value);
                if (c) cod.value = c;
            }
            closeAC();
        }, 160);
    });

    inp.addEventListener('focus', function() {
        var q = this.value.trim();
        if (q.length >= 1 && !cod.value) fetchAndRender(q);
    });
}

nmSetupAC('nm-from', 'nm-from-code', 'nm-from-drop');
nmSetupAC('nm-to',   'nm-to-code',   'nm-to-drop');

// ── Results helpers ────────────────────────────────
function nmShowResults(html, animate) {
    var outer = document.getElementById('nm-results');
    var inner = document.getElementById("nm-results-html") || document.querySelector('.nm-results-inner')

    inner.classList.remove('nm-visible');
    inner.innerHTML = html;
    outer.style.display = '';
    // Trigger animation frame
    requestAnimationFrame(function(){
        requestAnimationFrame(function(){
            inner.classList.add('nm-visible');
            if (animate !== false) {
                outer.scrollIntoView({behavior:'smooth', block:'start'});
            }
        });
    });
}
function nmLoading(msg) {
    nmShowResults('<div class="nm-loading"><div class="nm-spinner"></div><p>'+(msg||'Searching...')+'</p></div>', false);
    document.getElementById('nm-results').style.display = '';
    // Immediate show without animation for loading state
document.querySelector('.nm-results-inner').classList.add('nm-visible');
}

function nmError(msg) {
    nmShowResults('<div class="nm-alert nm-alert-err mt-2"><i class="fas fa-exclamation-circle me-2"></i>'+msg+'</div>');
}
function nmNone(msg) {
    nmShowResults('<div class="text-center py-5"><i class="fas fa-search fa-3x mb-3 d-block" style="color:#c9a84c;"></i><p style="color:#666;font-size:15px;font-weight:600;">'+msg+'</p></div>');
}

// ════════════════════════════════════════════════════
// FLIGHTS
// ════════════════════════════════════════════════════
function nmSearchFlights(overrideDate) {
    // Show spinner on button immediately
    var searchBtn = document.getElementById('nm-search-btn');
    if (searchBtn && !overrideDate) {
        searchBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Searching...';
        searchBtn.disabled = true;
        setTimeout(function(){ searchBtn.innerHTML='<i class="fas fa-search"></i> Search'; searchBtn.disabled=false; }, 8000);
    }
    // Re-extract IATA on every search (handles late datalist selection)
    var fromEl = document.getElementById('nm-from');
    var toEl   = document.getElementById('nm-to');
    var fromCode = document.getElementById('nm-from-code');
    var toCode   = document.getElementById('nm-to-code');

    if (fromEl && fromCode) {
        var c = nmIATA(fromEl.value); if (c) fromCode.value = c;
    }
    if (toEl && toCode) {
        var c2 = nmIATA(toEl.value); if (c2) toCode.value = c2;
    }

    var from   = (fromCode && fromCode.value) || nmIATA(fromEl ? fromEl.value : '');
    var to     = (toCode && toCode.value)     || nmIATA(toEl ? toEl.value : '');
    var fromLabel = (fromEl && fromEl.value) || from;
    var toLabel   = (toEl   && toEl.value)   || to;
    var depart = overrideDate || (document.getElementById('nm-depart') ? document.getElementById('nm-depart').value : '');
    var ret    = document.getElementById('nm-return') ? document.getElementById('nm-return').value : '';
    var adults = document.getElementById('nm-adults') ? document.getElementById('nm-adults').value : '1';
    var youth  = document.getElementById('nm-youth')  ? document.getElementById('nm-youth').value  : '0';
    var cabin  = document.getElementById('nm-cabin')  ? document.getElementById('nm-cabin').value  : 'economy';
    var tripEl = document.querySelector('input[name="nm_trip"]:checked');
    var trip   = tripEl ? tripEl.value : 'oneway';

    if (!from || !to) {
        var msg = 'Please enter airports in the From and To fields.\n\n'
            + 'Type a city name or airport code:\n'
            + '  "Chicago" → select "Chicago ORD" from the list\n'
            + '  "JFK" → accepted directly\n'
            + '  "New York JFK" → accepted';
        alert(msg);
        if (fromEl) fromEl.focus();
        return;
    }
    if (!depart) {
        alert('Please select a departure date.');
        var dep = document.getElementById('nm-depart');
        if (dep) dep.focus();
        return;
    }

    window._nmCtx = {from:from, to:to, fromLabel:fromLabel, toLabel:toLabel, depart:depart, adults:adults, youth:youth, cabin:cabin, trip:trip};
    nmLoading('Searching all airlines: ' + nmEsc(fromLabel) + ' &rarr; ' + nmEsc(toLabel) + ' &hellip;');

    // Split into individual codes (multi-airport support: "ORD,MDW")
    var fromCodes = from.split(',').map(function(c){ return c.trim(); }).filter(Boolean);
    var toCodes   = to.split(',').map(function(c){ return c.trim(); }).filter(Boolean);

    // Build all from/to pairs and fetch in parallel
    var searches = [];
    fromCodes.forEach(function(f) {
        toCodes.forEach(function(t) {
            searches.push({from: f, to: t});
        });
    });

    var paxSuffix = '&adults='+encodeURIComponent(adults)
        + (parseInt(youth)>0 ? '&youth='+encodeURIComponent(youth) : '')
        + '&cabin_class='+encodeURIComponent(cabin)
        + '&triptype='+encodeURIComponent(trip);
    if (trip==='twoway' && ret) paxSuffix += '&return_date='+encodeURIComponent(ret);

    Promise.all(searches.map(function(s) {
        var qs = 'slices[0][from]='+encodeURIComponent(s.from)
               + '&slices[0][to]='+encodeURIComponent(s.to)
               + '&slices[0][departure_date]='+encodeURIComponent(depart)
               + paxSuffix;
        return fetch('/api/home/flights?'+qs, {headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(function(r){ return r.json(); })
            .then(function(data){
                if (data && data.error) return [];
                return Array.isArray(data) ? data : (data.offers || data.data || []);
            })
            .catch(function(){ return []; });
    }))
    .then(function(allArrays){
        var offers = [].concat.apply([], allArrays);
        window._nmOffers = offers;
        nmRenderFlights(offers, fromLabel, toLabel, depart);
    })
    .catch(function(e){
        nmError('No flights available. Try a new destination or different dates.');
    });
}

function nmParseDur(iso) {
    if (!iso) return 0;
    var m = iso.match(/PT(?:(\d+)H)?(?:(\d+)M)?/);
    return m ? (parseInt(m[1]||0)*60+parseInt(m[2]||0)) : 0;
}
function nmFmtTime(iso) {
    if (!iso) return '';
    try { return new Date(iso).toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit',hour12:true}); }
    catch(e){ return ''; }
}
function nmFmtDate(dateStr) {
    try {
        var d = new Date(dateStr+'T12:00:00');
        return d.toLocaleDateString('en-US',{weekday:'short',month:'short',day:'numeric'});
    } catch(e){ return dateStr; }
}

// US airline priority — shown first before international carriers
var NM_US_PRIORITY = {AA:1, F9:2, NK:3, B6:4, AS:5, UA:6, DL:7, WN:8, G4:9, SY:10};

function nmSortPriority(a, b) {
    var ia = (a.owner && a.owner.iata_code) ? a.owner.iata_code.toUpperCase() : '';
    var ib = (b.owner && b.owner.iata_code) ? b.owner.iata_code.toUpperCase() : '';
    var pa = NM_US_PRIORITY[ia] || 99;
    var pb = NM_US_PRIORITY[ib] || 99;
    if (pa !== pb) return pa - pb;
    return parseFloat(a.total_amount||9999) - parseFloat(b.total_amount||9999);
}

function nmGetDepCode(offer) {
    try { return offer.slices[0].segments[0].origin.iata_code || ''; } catch(e){ return ''; }
}

function nmRenderFlights(offers, from, to, depart) {
    if (!offers || offers.length === 0) {
        nmNone('No flights available for <strong>'+from+' &rarr; '+to+'</strong> on '+nmFmtDate(depart)+'. Try a new destination or different dates.');
        return;
    }
    // Default sort: cheapest first
    var sorted = offers.slice().sort(function(a,b){ return parseFloat(a.total_amount||9999)-parseFloat(b.total_amount||9999); });
    window._nmAllOffers = sorted;
    window._nmActiveApt = 'all';

    // Count unique departure airports
    var aptCounts = {};
    sorted.forEach(function(o) {
        var code = nmGetDepCode(o);
        if (code) aptCounts[code] = (aptCounts[code] || 0) + 1;
    });
    var aptCodes = Object.keys(aptCounts);

    // Count unique airlines
    var airlines = {};
    sorted.forEach(function(o){ if(o.owner&&o.owner.name) airlines[o.owner.name]=1; });
    var alCount = Object.keys(airlines).length;

    var html = '<div class="nm-results-hdr">'
        + '<h4 class="nm-results-title">'
        + '<span style="color:#c9a84c;">' + from + '</span>'
        + ' <i class="fas fa-long-arrow-alt-right" style="color:#c9a84c;font-size:13px;margin:0 8px;"></i>'
        + '<span style="color:#c9a84c;">' + to + '</span>'
        + '</h4>'
        + '<div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">'
        + '<span style="font-size:13px;color:#888;">'
        + '<strong style="color:#0a1628;">' + offers.length + '</strong> flights &bull; '
        + '<strong style="color:#0a1628;">' + alCount + '</strong> airline' + (alCount!==1?'s':'')
        + ' &bull; ' + nmFmtDate(depart)
        + '</span>'
        + '<div class="nm-sort-bar"><span>Sort:</span>'
        + '<button type="button" class="nm-sort-btn" onclick="nmSortFlights(\'us\',this)">US airlines first</button>'
        + '<button type="button" class="nm-sort-btn active" onclick="nmSortFlights(\'price\',this)">Cheapest</button>'
        + '<button type="button" class="nm-sort-btn" onclick="nmSortFlights(\'dur\',this)">Shortest</button>'
        + '<button type="button" class="nm-sort-btn" onclick="nmSortFlights(\'stops\',this)">Nonstop first</button>'
        + '</div></div>';

    html += '</div>'; // close nm-results-hdr

    // Airport filter pills — between header and price calendar
    var searchedCodes = window._nmCtx && window._nmCtx.from
        ? window._nmCtx.from.split(',').map(function(c){ return c.trim(); }).filter(Boolean)
        : [];
    var showPills = aptCodes.length > 1 || searchedCodes.length > 1;
    if (showPills) {
        var pillCodes = searchedCodes.length > 1 ? searchedCodes : aptCodes;
        html += '<div class="nm-apt-bar"><span>Airport:</span>'
            + '<button type="button" class="nm-apt-pill active" onclick="nmFilterAirport(\'all\',this)">'
            + 'All <span class="nm-apt-count">' + sorted.length + '</span></button>';
        pillCodes.forEach(function(code) {
            var count = aptCounts[code] || 0;
            var disabled = count === 0 ? ' style="opacity:.45;cursor:default;"' : '';
            html += '<button type="button" class="nm-apt-pill" onclick="nmFilterAirport(\'' + code + '\',this)"' + disabled + '>'
                + code + ' <span class="nm-apt-count">' + count + '</span></button>';
        });
        html += '</div>';
    }

    // Price calendar strip
    html += nmBuildPriceCalendar(from, to, depart);

    html += '<div id="nm-fl-list"></div>';

    nmShowResults(html);
    var _l = document.getElementById('nm-fl-list');
    if (_l) nmRenderGrouped(sorted, _l);
    nmRenderTPFlights(from, to, depart);

    // Fetch nearby date prices after render
    setTimeout(function(){ nmFetchNearbyPrices(from, to, depart); }, 600);
}

function nmFilterAirport(code, btn) {
    window._nmActiveApt = code;
    // Update pill active state
    document.querySelectorAll('.nm-apt-pill').forEach(function(el){ el.classList.remove('active'); });
    if (btn) btn.classList.add('active');

    var all = window._nmAllOffers || window._nmOffers || [];
    var filtered = code === 'all' ? all : all.filter(function(o){ return nmGetDepCode(o) === code; });

    var list = document.getElementById('nm-fl-list');
    if (list) nmRenderGrouped(filtered, list);
}

// ── Price calendar ─────────────────────────────────
function nmBuildPriceCalendar(from, to, depart) {
    var base = new Date(depart + 'T12:00:00');
    var pills = '';
    for (var i = -3; i <= 3; i++) {
        var d = new Date(base); d.setDate(d.getDate() + i);
        var ds = d.toISOString().split('T')[0];
        var today = new Date(); today.setHours(0,0,0,0);
        if (d < today) continue;
        var dayName = d.toLocaleDateString('en-US',{weekday:'short'});
        var dateDisp = d.toLocaleDateString('en-US',{month:'short',day:'numeric'});
        var isSelected = (ds === depart);
        pills += '<div class="nm-date-pill'+(isSelected?' nm-dp-sel':'')+'" '
            + 'id="dp-'+ds+'" onclick="nmSearchFlights(\''+ds+'\')">'
            + '<div class="nm-dp-day">'+dayName+'</div>'
            + '<div class="nm-dp-dt">'+dateDisp+'</div>'
            + '<div class="nm-dp-price loading" id="dpp-'+ds+'">'
            + (isSelected ? '&bull;&bull;&bull;' : '&bull;&bull;&bull;')
            + '</div></div>';
    }
    return '<div class="nm-price-cal">'
        + '<h6><i class="fas fa-calendar-alt me-1" style="color:#c9a84c;"></i>Compare prices by date</h6>'
        + '<div class="nm-date-strip">' + pills + '</div>'
        + '</div>';
}

function nmFetchNearbyPrices(from, to, depart) {
    var base = new Date(depart + 'T12:00:00');
    var today = new Date(); today.setHours(0,0,0,0);
    var dates = [];
    for (var i = -3; i <= 3; i++) {
        var d = new Date(base); d.setDate(d.getDate() + i);
        if (d < today) continue;
        dates.push(d.toISOString().split('T')[0]);
    }
    var adults = (window._nmCtx && window._nmCtx.adults) || '1';
    var cabin  = (window._nmCtx && window._nmCtx.cabin)  || 'economy';

    // Fetch each date with a stagger to avoid hammering the API
    dates.forEach(function(ds, idx) {
        setTimeout(function(){
            var el = document.getElementById('dpp-'+ds);
            if (!el) return;
            var qs = 'slices[0][from]='+encodeURIComponent(from)
                   + '&slices[0][to]='+encodeURIComponent(to)
                   + '&slices[0][departure_date]='+encodeURIComponent(ds)
                   + '&adults='+adults
                   + '&cabin_class='+cabin
                   + '&triptype=oneway';
            fetch('/api/home/flights?'+qs, {headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(function(r){return r.json();})
            .then(function(data){
                if (!el) return;
                var offers = Array.isArray(data) ? data : (data.offers||data.data||[]);
                if (!offers || !offers.length) {
                    el.textContent = 'N/A';
                    el.classList.remove('loading');
                    return;
                }
                var best = Math.min.apply(null, offers.map(function(o){return parseFloat(o.total_amount||999999);}));
                el.textContent = '$'+Math.floor(best);
                el.classList.remove('loading');
                // Highlight cheapest date
                var pills = document.querySelectorAll('.nm-date-pill:not(.nm-dp-sel)');
                var cheapestPill = null, cheapestAmt = Infinity;
                pills.forEach(function(p){
                    var priceEl = p.querySelector('.nm-dp-price');
                    if (priceEl && !priceEl.classList.contains('loading')) {
                        var amt = parseFloat(priceEl.textContent.replace('$',''));
                        if (!isNaN(amt) && amt < cheapestAmt) { cheapestAmt = amt; cheapestPill = p; }
                    }
                });
                document.querySelectorAll('.nm-date-pill').forEach(function(p){p.classList.remove('nm-dp-cheap');});
                if (cheapestPill) cheapestPill.classList.add('nm-dp-cheap');
            })
            .catch(function(){
                if (el) { el.textContent = '—'; el.classList.remove('loading'); }
            });
        }, idx * 1200); // 1.2s stagger between requests
    });
}

// Airlines that have real logos on Duffel CDN
var NM_HAS_LOGO = {AA:1,AS:1,B6:1,DL:1,F9:1,G4:1,HA:1,MX:1,NK:1,SY:1,UA:1,WN:1,
    BA:1,VS:1,LH:1,AF:1,KL:1,IB:1,AZ:1,TK:1,EK:1,QR:1,EY:1,SQ:1,CX:1,
    AC:1,WS:1,LX:1,OS:1,AY:1,SK:1,FI:1,EI:1,TP:1,LO:1,AT:1,MS:1,
    QF:1,NZ:1,LA:1,AM:1,CM:1,AV:1,AD:1,G3:1,JJ:1};

function nmFlightCard(offer) {
    if (!offer || !offer.slices || !offer.slices[0]) return "";
    var sl=offer.slices[0], segs=sl.segments||[], seg=segs[0]||{};
    var lastSeg=segs.length>1?segs[segs.length-1]:seg;
    var al=offer.owner||{}, iata=(al.iata_code||"").toUpperCase(), aln=al.name||iata||"Airline";
    var dep=nmFmtTime(seg.departing_at), arr=nmFmtTime(lastSeg.arriving_at);
    var dur=nmParseDur(sl.duration||"");
    if(!dur&&seg.departing_at&&lastSeg.arriving_at)
        dur=Math.round((new Date(lastSeg.arriving_at)-new Date(seg.departing_at))/60000);
    var dstr=dur?(Math.floor(dur/60)+"h "+(dur%60)+"m"):"";
    var stp=segs.length>0?segs.length-1:0;
    var stpLabel=stp===0?"Nonstop":stp+" stop"+(stp>1?"s":"");
    var stpCls=stp===0?"nonstop":"";
    var origCode=(seg.origin||{}).iata_code||"";
    var dstCode=(lastSeg.destination||{}).iata_code||"";
    var amt=parseFloat(offer.total_amount||0), cur=offer.total_currency||"USD";
    var pStr=cur==="USD"?"$"+amt.toFixed(0):amt.toFixed(0)+" "+cur;
    var logoHtml;
    if(iata&&NM_HAS_LOGO[iata]){
        var lu="https://assets.duffel.com/img/airlines/for-light-background/full-color-logo/"+iata+".svg";
        logoHtml="<img src=\""+lu+"\" alt=\""+iata+"\" class=\"nm-fc-logo\" onerror=\"this.remove();\">";
    } else {
        logoHtml="<span class=\"nm-fc-aname\">"+nmEsc(aln)+"</span>";
    }
    var uid=offer.id||("unk"+Math.random().toString(36).slice(2));
    if(!window._nmCardData)window._nmCardData={};
    window._nmCardData[uid]={offerId:uid,amt:amt,cur:cur,from:origCode,to:dstCode,aln:aln,dep:dep,arr:arr,stops:stp};
    return "<div class=\"nm-fc\">"
        +"<div class=\"nm-fc-body\">"
        +"<div class=\"nm-fc-airline\">"+logoHtml+"</div>"
        +"<div class=\"nm-fc-times\"><span class=\"nm-fc-time\">"+dep+"</span><span class=\"nm-fc-code\">"+origCode+"</span></div>"
        +"<div class=\"nm-fc-mid\">"
        +"<div class=\"nm-fc-dur\">"+dstr+"</div>"
        +"<div class=\"nm-fc-line\"><div class=\"nm-fc-dot\"></div><div class=\"nm-fc-track\"></div><div class=\"nm-fc-dot\"></div></div>"
        +"<div class=\"nm-fc-stops "+stpCls+"\">"+stpLabel+"</div>"
        +"</div>"
        +"<div class=\"nm-fc-times\"><span class=\"nm-fc-time\">"+arr+"</span><span class=\"nm-fc-code\">"+dstCode+"</span></div>"
        +"<div class=\"nm-fc-price-col\">"
        +"<div class=\"nm-fc-price\">"+pStr+"</div>"
        +"<button type=\"button\" class=\"nm-fc-select\" data-uid=\""+uid+"\">Select &rarr;</button>"
        +"</div>"
        +"</div></div>";
}

var NM_PER_AIRLINE = 5;

function nmRenderGrouped(offers, list) {
    var groups = {}, order = [];
    offers.forEach(function(o) {
        var n = (o.owner && o.owner.name) || "Unknown";
        if (!groups[n]) { groups[n] = []; order.push(n); }
        groups[n].push(o);
    });
    var html = "";
    order.forEach(function(name) {
        var show = groups[name].slice(0, NM_PER_AIRLINE);
        var rest = groups[name].slice(NM_PER_AIRLINE);
        show.forEach(function(o) { html += nmFlightCard(o); });
        if (rest.length > 0) {
            var hh = "";
            rest.forEach(function(o) { hh += nmFlightCard(o); });
            html += "<div class=\"nm-more-flights\" style=\"display:none;\">" + hh + "</div>";
            html += "<button type=\"button\" class=\"nm-show-more-btn\" onclick=\"nmShowMore(this)\">"
                  + "<i class=\"fas fa-chevron-down me-1\"></i>Show " + rest.length + " more " + name + " flights"
                  + "</button>";
        }
    });
    list.innerHTML = html;
}

function nmShowMore(btn) {
    var h = btn.previousElementSibling;
    if (h) h.style.display = "";
    btn.style.display = "none";
}

function nmDirectChip(code, name, url, color) {
    var short = name.replace(" Airlines","").replace(" Air Lines","").replace(" Airways","");
    return "<a href=\"" + url + "\" target=\"_blank\" rel=\"noopener\" class=\"nm-al-chip\">"
        + "<img src=\"https://pics.avs.io/32/32/" + code + ".png\" onerror=\"this.style.display='none'\" style=\"width:18px;height:18px;object-fit:contain;flex-shrink:0;\">"
        + "<span>" + short + "</span>"
        + "</a>";
}

function nmRenderTPFlights(from, to, depart) {
    var list = document.getElementById("nm-fl-list");
    if (!list) return;
    var prev = document.getElementById("nm-tp-section");
    if (prev) prev.remove();

    var avsDate = depart.replace(/-/g, "");
    var avsUrl = "https://www.aviasales.com/search/" + encodeURIComponent(from) + avsDate.substring(4,8) + encodeURIComponent(to) + "1?marker=441262";
    var depParts = depart.split("-");
    var dlDate = depParts[1] + "/" + depParts[2] + "/" + depParts[0];
    var uaUrl  = "https://www.united.com/en/us/fsr/choose-flights?f=" + encodeURIComponent(from) + "&t=" + encodeURIComponent(to) + "&d=" + encodeURIComponent(depart) + "&sc=7&px=1&taxng=1&newHP=True&clm=7&st=bestmatches";
    var dlUrl  = "https://www.delta.com/";
    var swUrl  = "https://www.southwest.com/";
    var b6Url  = "https://www.jetblue.com/flights/" + encodeURIComponent(from) + "-" + encodeURIComponent(to) + "?departureDate=" + encodeURIComponent(depart) + "&cabin=economy&adults=1";
    var asUrl  = "https://www.alaskaair.com/booking/flights?A=1&C=0&D=0&O=" + encodeURIComponent(from) + "&D2=" + encodeURIComponent(to) + "&OD=" + encodeURIComponent(depart) + "&OT=oneway&BC=Y&RT=false";
    var f9Url  = "https://www.flyfrontier.com/book/plan-your-trip/?departureCity=" + encodeURIComponent(from) + "&arrivalCity=" + encodeURIComponent(to) + "&departureDate=" + encodeURIComponent(depart) + "&numberOfAdults=1&trip=ONE_WAY";

    var cards =
        "<span style=\"display:inline-flex;align-items:center;gap:5px;padding:5px 10px;font-size:12px;font-weight:700;color:#999;\">"
            + ""
        + "</span>"
        + nmDirectChip("UA","United Airlines",uaUrl,"")
        + nmDirectChip("DL","Delta Air Lines",dlUrl,"")
        + nmDirectChip("WN","Southwest Airlines",swUrl,"");

    var section = document.createElement("div");
    section.id = "nm-tp-section";
    section.style.cssText = "margin:0 0 14px 0;padding:0;width:100%;";
    section.innerHTML = "<div style=\"font-size:10px;color:#bbb;letter-spacing:.06em;text-transform:uppercase;margin:0 0 8px 0;padding:0;\">Also search on</div>"
        + "<div style=\"overflow-x:auto;-webkit-overflow-scrolling:touch;scrollbar-width:none;margin:0;padding:0;\">"
        + "<div style=\"display:flex;flex-wrap:nowrap;gap:6px;align-items:center;width:max-content;\">" + cards + "</div>"
        + "</div>";
    list.insertBefore(section, list.firstChild);
}

function nmSortFlights(by, btn) {
    document.querySelectorAll('.nm-sort-btn').forEach(function(b){b.classList.remove('active');});
    if (btn) btn.classList.add('active');
    // Sort from the full set, then re-apply active airport filter
    var all = (window._nmAllOffers || window._nmOffers || []).slice();
    var aptFilter = window._nmActiveApt || 'all';
    var s = aptFilter === 'all' ? all : all.filter(function(o){ return nmGetDepCode(o) === aptFilter; });
    if (by === 'us' || by === 'price') {
        // 'us' = US airlines first then by price; 'price' = pure cheapest first
        if (by === 'us') {
            s.sort(nmSortPriority);
        } else {
            s.sort(function(a,b){ return parseFloat(a.total_amount) - parseFloat(b.total_amount); });
        }
    } else if (by === 'dur') {
        s.sort(function(a,b){
            return nmParseDur((a.slices[0]||{}).duration||'') - nmParseDur((b.slices[0]||{}).duration||'');
        });
    } else if (by === 'stops') {
        s.sort(function(a,b){
            var sa = a.slices&&a.slices[0]&&a.slices[0].segments ? a.slices[0].segments.length-1 : 9;
            var sb = b.slices&&b.slices[0]&&b.slices[0].segments ? b.slices[0].segments.length-1 : 9;
            if (sa !== sb) return sa - sb;
            return parseFloat(a.total_amount) - parseFloat(b.total_amount);
        });
    }
    var list = document.getElementById('nm-fl-list');
    if (list) { nmRenderGrouped(s, list); }
    if (window._nmCtx) nmRenderTPFlights(window._nmCtx.from, window._nmCtx.to, window._nmCtx.depart);
}

// Event delegation for SELECT buttons — avoids all quote-escaping issues in onclick attrs
document.addEventListener('click', function(e) {
    var btn = e.target.closest('.nm-fc-select');
    if (!btn) return;
    var uid  = btn.dataset.uid;
    var data = window._nmCardData && window._nmCardData[uid];
    if (!data) return;
    nmOpenBooking(data.offerId, data.amt, data.cur, data.from, data.to, data.aln, data.dep, data.arr, data.stops);
});

// ════════════════════════════════════════════════════
// HOTELS
// ════════════════════════════════════════════════════
function nmSearchHotels() {
    var ap = document.getElementById('nm-ap-section'); if (ap) ap.style.display = 'none';
    var panel = document.getElementById('panel-hotels');
    var destEl = panel ? (panel.querySelector('.nm-search-input') || document.getElementById('nm-h-dest')) : document.getElementById('nm-h-dest');
    var dest = destEl ? destEl.value.trim() : '';
    var cin  = document.getElementById('nm-h-in') ? document.getElementById('nm-h-in').value : '';
    var cout = document.getElementById('nm-h-out') ? document.getElementById('nm-h-out').value : '';
    var adl  = document.getElementById('nm-h-adults') ? document.getElementById('nm-h-adults').value : '2';
    var rm   = document.getElementById('nm-h-rooms') ? document.getElementById('nm-h-rooms').value : '1';
    if (!dest||!cin||!cout) { alert('Please fill in destination, check-in and check-out dates.'); return; }

    var hBtn = document.getElementById('nm-h-search-btn');
    if (hBtn) {
        var rip = document.createElement('span');
        rip.className = 'nm-ripple';
        rip.style.top  = (hBtn.offsetHeight/2)+'px';
        rip.style.left = (hBtn.offsetWidth/2)+'px';
        hBtn.appendChild(rip);
        setTimeout(function(){ rip.remove(); }, 700);
        hBtn.innerHTML = '<i class="fas fa-hotel fa-spin" style="font-size:13px;"></i>&nbsp; Searching...';
        hBtn.classList.add('nm-btn-loading');
        hBtn.disabled = true;
    }

    nmLoading('Searching hotels in '+dest+'&hellip;');

    var res = document.getElementById('nm-results');
    if (res) setTimeout(function(){ res.scrollIntoView({behavior:'smooth', block:'start'}); }, 120);

    var qs = 'city='+encodeURIComponent(dest)+'&checkin='+encodeURIComponent(cin)+'&checkout='+encodeURIComponent(cout)+'&adults='+adl+'&rooms='+rm;
    fetch('/api/home/hotels?'+qs, {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){return r.json();})
    .then(function(data){
        if (hBtn) { hBtn.innerHTML='<i class="fas fa-search"></i> Search Hotels'; hBtn.classList.remove('nm-btn-loading'); hBtn.disabled=false; }
        if(data.error && !data.hotels) { nmError(data.error+' &nbsp;<a href="/hotels" style="color:#c9a84c;">Try our hotels page</a>'); return; }
        nmRenderHotels(data.hotels||[], dest, cin, cout, adl, rm);
    })
    .catch(function(){
        if (hBtn) { hBtn.innerHTML='<i class="fas fa-search"></i> Search Hotels'; hBtn.classList.remove('nm-btn-loading'); hBtn.disabled=false; }
        nmError('Hotel search failed. <a href="/hotels" style="color:#c9a84c;">Try our hotels page</a>.');
    });
}

function nmRenderHotels(hotels, dest, cin, cout, adl) {
    if (!hotels||hotels.length===0) {
        nmNone('No hotels found in '+dest+'.<br><small style="color:#999">Try different dates or visit our <a href="/hotels" style="color:#c9a84c;">hotels page</a>.</small>');
        return;
    }
    var html = '<div class="nm-results-hdr">'
        +'<h4 class="nm-results-title"><i class="fas fa-hotel me-2" style="color:#c9a84c;"></i>'+dest+'</h4>'
        +'<span style="font-size:13px;color:#888;">'+hotels.length+' hotels · '+cin+' – '+cout+'</span></div>'
        +'<div class="nm-grid">';
    hotels.slice(0,12).forEach(function(h){
        var name  = h.name||'Hotel';
        var stars = parseInt(h.categoryCode||h.stars||h.star_rating||0)||0;
        var starS = stars ? ('★').repeat(stars) : '';
        var rate  = h.minRate||h.total_amount||0;
        var nights = Math.max(1, Math.round((new Date(cout) - new Date(cin)) / 86400000));
        var perNight = nights > 1 ? Math.round(rate / nights) : null;
        var pStr  = rate ? (nights > 1 ? '$'+parseFloat(rate).toFixed(0)+' total' : '$'+parseFloat(rate).toFixed(0)+'/night') : 'Check price';
        var subStr = (nights > 1 && perNight) ? '$'+perNight+'/night &middot; '+nights+' nights' : '';
        var imgs  = h.images||[];
        var img   = h.image || h.thumbnail || (imgs.length ? imgs[0].path||imgs[0].url||'' : '');
        var addr  = (h.address&&h.address.content)||h.address||'';
        html += '<div class="nm-hc">'
            +(img?'<img src="'+img+'" class="nm-hc-img" alt="'+name+'" loading="lazy" onerror="this.outerHTML=\'<div class=nm-hc-ph>🏨</div>\'">'
                 :'<div class="nm-hc-ph">🏨</div>')
            +'<div class="nm-hc-body">'
            +'<div class="nm-hc-name">'+name+'</div>'
            +(starS?'<div class="nm-hc-stars">'+starS+'</div>':'')
            +(addr?'<div class="nm-hc-meta"><i class="fas fa-map-marker-alt"></i> '+addr+'</div>':'')
            +'<div class="nm-hc-price">'+pStr+'</div>'
            +(subStr?'<div style="font-size:11px;color:#aaa;margin-top:-6px;margin-bottom:8px;">'+subStr+'</div>':'')
            +(h.source==='duffel'&&h.hotelId?'<a href="/hotels/stay/'+h.hotelId+'?check_in='+cin+'&check_out='+cout+'&adults='+(adl||2)+'" class="nm-hc-btn">View &amp; Book</a>':'<a href="/hotels/detail/'+h.hotelId+'?check_in='+cin+'&check_out='+cout+'&adults='+(adl||2)+'" class="nm-hc-btn">View &amp; Book</a>')
            +'</div></div>';
    });
    html += '</div>';
    nmShowResults(html);
}

// ════════════════════════════════════════════════════
// SPORTS
// ════════════════════════════════════════════════════
function nmSearchSports() {
    var city = document.getElementById('nm-sp-city').value.trim();
    var kw   = document.getElementById('nm-sp-kw').value;
    var dt   = document.getElementById('nm-sp-date').value;
    nmLoading('Finding sports events'+(city?' in '+city:'')+'&hellip;');
    var qs = (city?'city='+encodeURIComponent(city)+'&':'')+(kw?'keyword='+encodeURIComponent(kw)+'&':'')+(dt?'date='+encodeURIComponent(dt):'');
    fetch('/api/home/sports?'+qs, {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){return r.json();})
    .then(function(d){
        if(d.error&&!(d.events&&d.events.length)) { nmError(d.error+' &nbsp;<a href="/sports" style="color:#c9a84c;">View sports page</a>'); return; }
        nmRenderEvents(d.events||[], 'sports', city);
    })
    .catch(function(){ nmError('Could not load events. <a href="/sports" style="color:#c9a84c;">Visit sports page</a>.'); });
}

// ════════════════════════════════════════════════════
// CONCERTS
// ════════════════════════════════════════════════════
function nmSearchConcerts() {
    var city = document.getElementById('nm-co-city').value.trim();
    var kw   = document.getElementById('nm-co-kw').value.trim();
    var dt   = document.getElementById('nm-co-date').value;
    nmLoading('Finding concerts'+(city?' in '+city:'')+'&hellip;');
    var qs = (city?'city='+encodeURIComponent(city)+'&':'')+(kw?'keyword='+encodeURIComponent(kw)+'&':'')+(dt?'date='+encodeURIComponent(dt):'');
    fetch('/api/home/concerts?'+qs, {headers:{'X-Requested-With':'XMLHttpRequest'}})
    .then(function(r){return r.json();})
    .then(function(d){
        if(d.error&&!(d.events&&d.events.length)) { nmError(d.error+' &nbsp;<a href="/concerts" style="color:#c9a84c;">View concerts page</a>'); return; }
        nmRenderEvents(d.events||[], 'concerts', city);
    })
    .catch(function(){ nmError('Could not load events. <a href="/concerts" style="color:#c9a84c;">Visit concerts page</a>.'); });
}

function nmRenderEvents(events, type, city) {
    if (!events||events.length===0) {
        nmNone('No '+(type==='sports'?'sports events':'concerts')+' found'+(city?' in '+city:'')+'.<br><small style="color:#999">Try a different city, date, or <a href="/'+type+'" style="color:#c9a84c;">browse all events</a>.</small>');
        return;
    }
    var icon    = type==='sports' ? '🏟' : '🎵';
    var pageUrl = '/'+type;
    var title   = type==='sports' ? 'Sports Events' : 'Concerts &amp; Events';
    var html = '<div class="nm-results-hdr">'
        +'<h4 class="nm-results-title">'+icon+' '+title+(city?' &middot; '+city:'')+'</h4>'
        +'<span style="font-size:13px;color:#888;">'+events.length+' found &nbsp;<a href="'+pageUrl+'" style="font-size:12px;color:#c9a84c;">(view all)</a></span></div>'
        +'<div class="nm-grid">';
    events.slice(0,12).forEach(function(ev){
        var img  = ev.image || (ev.images&&ev.images[0] ? ev.images[0].url : '');
        var ven  = ev._embedded&&ev._embedded.venues ? ev._embedded.venues[0] : {};
        var vn   = ven.name||'';
        var vcity= (ven.city?ven.city.name:'')+(ven.state?', '+ven.state.stateCode:'');
        var dstr = '';
        if (ev.dates&&ev.dates.start&&ev.dates.start.localDate) {
            try { var d=new Date(ev.dates.start.localDate+'T12:00:00'); dstr=d.toLocaleDateString('en-US',{weekday:'short',month:'short',day:'numeric',year:'numeric'}); }
            catch(e){ dstr=ev.dates.start.localDate; }
        }
        var genre= ev.classifications&&ev.classifications[0] ?
            (ev.classifications[0].genre ? ev.classifications[0].genre.name : (ev.classifications[0].segment ? ev.classifications[0].segment.name : '')) : '';
        var mp   = ev.priceRanges&&ev.priceRanges[0] ? ev.priceRanges[0].min : null;
        var pStr = mp ? 'From $'+Math.floor(mp) : 'Check prices';
        var url  = ev.url||pageUrl;
        html += '<div class="nm-ec">'
            +(img?'<img src="'+img+'" class="nm-ec-img" alt="'+ev.name+'" loading="lazy">'
                 :'<div class="nm-ec-ph">'+icon+'</div>')
            +'<div class="nm-ec-body">'
            +'<p class="nm-ec-cat">'+(genre||(type==='sports'?'Sports':'Music'))+'</p>'
            +'<h5 class="nm-ec-title">'+ev.name+'</h5>'
            +'<div class="nm-ec-meta">'
            +(vn?'<div><i class="fas fa-map-marker-alt"></i> '+vn+(vcity?', '+vcity:'')+'</div>':'')
            +(dstr?'<div><i class="fas fa-calendar"></i> '+dstr+'</div>':'')
            +'</div><div class="nm-ec-price">'+pStr+'</div>'
            +'<a href="'+url+'" target="_blank" class="nm-ec-btn"><i class="fas fa-ticket-alt me-1"></i>Get Tickets</a>'
            +'</div></div>';
    });
    html += '</div>';
    nmShowResults(html);
}

// ════════════════════════════════════════════════════
// BOOKING DRAWER
// ════════════════════════════════════════════════════
var _nmStripe=null, _nmCard=null;

function nmOpenBooking(offerId, amt, cur, from, to, aln, dep, arr, stops) {
    document.getElementById('bk-offer').value = offerId;
    document.getElementById('bk-amt').value   = amt;
    document.getElementById('bk-cur').value   = cur;
    document.getElementById('bk-from').value  = from;
    document.getElementById('bk-to').value    = to;
    document.getElementById('bk-date').value  = window._nmCtx ? window._nmCtx.depart : '';

    var pStr = cur==='USD' ? '$'+parseFloat(amt).toFixed(0) : parseFloat(amt).toFixed(0)+' '+cur;
    var stpStr = stops==0 ? 'Nonstop' : stops+' stop'+(stops>1?'s':'');

    document.getElementById('nm-drw-summary').innerHTML =
        '<div style="display:flex;justify-content:space-between;align-items:flex-start">'
        +'<div><div class="nm-drw-route">'+from+' &rarr; '+to+'</div>'
        +'<div class="nm-drw-details">'+aln+' &middot; '+dep+' &ndash; '+arr+' &middot; '+stpStr+'</div></div>'
        +'<div class="nm-drw-price">'+pStr+'</div></div>';
    document.getElementById('nm-drw-sub').textContent = from+' → '+to+' · '+aln;
    document.getElementById('nm-book-msg').innerHTML = '';
    document.getElementById('nm-card-err').textContent = '';

    var btn = document.getElementById('nm-pay-btn');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-lock me-2"></i> Pay '+pStr+' &amp; Confirm Booking';

    // Load Stripe on demand
    if (!_nmStripe) {
        if (typeof Stripe !== 'undefined') {
            _nmInitStripe();
        } else {
            var s = document.createElement('script');
            s.src = 'https://js.stripe.com/v3/';
            s.onload = _nmInitStripe;
            document.head.appendChild(s);
        }
    } else if (_nmCard) {
        _nmCard.clear();
    }

    document.getElementById('nm-overlay').classList.add('open');
    document.getElementById('nm-drawer').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function _nmInitStripe() {
    _nmStripe = Stripe('{{ env('STRIPE_KEY') }}');
    var els = _nmStripe.elements();
    _nmCard = els.create('card', {
        style:{ base:{ fontSize:'15px', color:'#0a1628', '::placeholder':{color:'#bbb'}, fontFamily:'inherit' } }
    });
    _nmCard.mount('#nm-card-el');
    _nmCard.on('change', function(e){
        document.getElementById('nm-card-err').textContent = e.error ? e.error.message : '';
    });
}

function nmCloseDrawer() {
    document.getElementById('nm-overlay').classList.remove('open');
    document.getElementById('nm-drawer').classList.remove('open');
    document.body.style.overflow = '';
}

function nmSubmitBooking(e) {
    e.preventDefault();
    var btn  = document.getElementById('nm-pay-btn');
    var fn   = document.getElementById('bk-fn').value.trim();
    var ln   = document.getElementById('bk-ln').value.trim();
    var em   = document.getElementById('bk-em').value.trim();
    var ph   = document.getElementById('bk-ph').value.trim();
    var oid  = document.getElementById('bk-offer').value;
    var amt  = parseFloat(document.getElementById('bk-amt').value);
    var cur  = document.getElementById('bk-cur').value;
    var from = document.getElementById('bk-from').value;
    var to   = document.getElementById('bk-to').value;
    var dt   = document.getElementById('bk-date').value;

    if(!fn||!ln||!em){ document.getElementById('nm-book-msg').innerHTML='<div class="nm-alert nm-alert-err mb-2">Please fill in all required fields.</div>'; return; }

    btn.disabled=true;
    btn.innerHTML='<i class="fas fa-spinner fa-spin me-2"></i>Processing…';
    document.getElementById('nm-card-err').textContent='';
    document.getElementById('nm-book-msg').innerHTML='';

    var csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '';

    // Step 1: Create PaymentIntent
    fetch('/api/flights/payment-intent',{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'X-Requested-With':'XMLHttpRequest'},
        body:JSON.stringify({offer_id:oid, amount:amt, currency:cur})
    })
    .then(function(r){return r.json();})
    .then(function(d){
        if(d.error){
            document.getElementById('nm-book-msg').innerHTML='<div class="nm-alert nm-alert-err mb-2">'+d.error+'</div>';
            btn.disabled=false; btn.innerHTML='<i class="fas fa-lock me-2"></i>Retry Payment'; return Promise.reject('pi_error');
        }
        // Step 2: Confirm card
        return _nmStripe.confirmCardPayment(d.clientSecret,{
            payment_method:{ card:_nmCard, billing_details:{name:fn+' '+ln, email:em} }
        });
    })
    .then(function(res){
        if(!res||res===undefined) return;
        if(res.error){
            document.getElementById('nm-card-err').textContent=res.error.message;
            btn.disabled=false; btn.innerHTML='<i class="fas fa-lock me-2"></i>Retry Payment'; return Promise.reject('card_error');
        }
        // Step 3: Save booking
        return fetch('/api/flights/book',{
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'X-Requested-With':'XMLHttpRequest'},
            body:JSON.stringify({offer_id:oid, payment_intent_id:res.paymentIntent.id,
                first_name:fn, last_name:ln, email:em, phone:ph,
                from:from, to:to, depart_date:dt, price:amt, currency:cur,
                adults: document.getElementById('nm-adults').value||1})
        });
    })
    .then(function(r){ if(r&&typeof r.json==='function') return r.json(); })
    .then(function(bk){
        if(!bk) return;
        if(bk.success){
            document.getElementById('nm-book-form').innerHTML =
                '<div class="nm-alert nm-alert-ok text-center" style="padding:30px;">'
                +'<i class="fas fa-check-circle fa-3x d-block mb-3" style="color:#27ae60;"></i>'
                +'<h5 style="font-weight:900;color:#0a1628;">Booking Confirmed!</h5>'
                +'<p>Thank you, '+fn+'! Booking reference: <strong>'+(bk.reference||'#'+bk.booking_id)+'</strong></p>'
                +'<p style="font-size:13px;color:#666;">Confirmation sent to '+em+'</p>'
                +'</div>';
        } else {
            document.getElementById('nm-book-msg').innerHTML='<div class="nm-alert nm-alert-err mb-2">'+(bk.error||'Booking failed.')+'</div>';
            btn.disabled=false; btn.innerHTML='<i class="fas fa-lock me-2"></i>Retry';
        }
    })
    .catch(function(err){
        if(err==='pi_error'||err==='card_error') return;
        document.getElementById('nm-book-msg').innerHTML='<div class="nm-alert nm-alert-err mb-2">Payment error. Please try again.</div>';
        btn.disabled=false; btn.innerHTML='<i class="fas fa-lock me-2"></i>Retry Payment';
    });
}


function nmSearchCars(btn) {
    var panel = (btn && btn.closest) ? btn.closest('.nm-gf-panel') : document.getElementById('panel-cars');
    if (!panel) panel = document.getElementById('panel-cars');
    var pickupEl  = panel ? panel.querySelector('input[type="text"]') : null;
    var fromEl    = panel ? panel.querySelector('input[type="date"]:first-of-type') : null;
    var toEl      = panel ? panel.querySelector('input[type="date"]:last-of-type') : null;
    var ageEl     = panel ? panel.querySelector('select') : null;
    if (!pickupEl || !fromEl || !toEl || !ageEl) {
        nmError('Car search form not ready. Please refresh the page.');
        return;
    }
    var pickup    = pickupEl.value.trim();
    var fromDate  = fromEl.value;
    var toDate    = toEl.value;
    var age       = ageEl.value;
    if (!pickup)   { nmError('Please enter a pick-up location.'); return; }
    if (!fromDate) { nmError('Please select a pick-up date.'); return; }
    if (!toDate)   { nmError('Please select a return date.'); return; }

    nmLoading('Searching cars in ' + pickup + '…');

    fetch('/api/home/cars?pickup=' + encodeURIComponent(pickup) + '&checkin=' + encodeURIComponent(fromDate) + '&checkout=' + encodeURIComponent(toDate) + '&age=' + age, {
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.error) { nmError(d.error); return; }
        nmRenderCars(d.cars || [], pickup, fromDate, toDate);
    })
    .catch(function() { nmError('Car search failed. Please try again.'); });
}

function nmRenderCars(cars, pickup, checkin, checkout) {
    if (!cars || cars.length === 0) {
        nmNone('No cars found for ' + pickup + '.');
        return;
    }
    var html = '<div class="nm-results-hdr">'
        + '<h4 class="nm-results-title"><i class="fas fa-car me-2" style="color:#c9a84c;"></i>Cars in ' + pickup + '</h4>'
        + '<span style="font-size:13px;color:#888;">' + cars.length + ' vehicles • ' + checkin + ' – ' + checkout + '</span></div>'
        + '<div class="nm-grid">';
    cars.forEach(function(c) {
        html += '<div class="nm-hc">'
            + '<img src="' + c.image + '" class="nm-hc-img" alt="' + c.name + '" loading="lazy" onerror="this.outerHTML=\'<div class=nm-hc-ph>&#x1F697;</div>\'">'  
            + '<div class="nm-hc-body">'
            + '<div class="nm-hc-name">' + c.name + '</div>'
            + '<div class="nm-hc-meta" style="font-size:11px;color:#888;margin-bottom:6px;">'
            + '<i class="fas fa-building me-1" style="color:#c9a84c;"></i>' + c.company
            + '  ·  <i class="fas fa-users me-1" style="color:#c9a84c;"></i>' + c.seats + ' seats'
            + '  ·  <i class="fas fa-cog me-1" style="color:#c9a84c;"></i>' + c.transmission
            + '</div>'
            + '<div style="font-size:11px;color:#c9a84c;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;">' + c.category + '</div>'
            + '<a href="' + c.booking_url + '" target="_blank" class="nm-hc-btn" style="margin-top:14px;"><i class="fas fa-tag me-1"></i>See Prices &amp; Book</a>'
            + '</div></div>';
    });
    html += '</div>';
    nmShowResults(html);
}

// ── Typewriter effect ───────────────────────────────
(function() {
  var el = document.getElementById('nm-type-word');
  if (!el) return;
  var words = ['Your Journey.', 'Your Trip.', 'Your Stay.', 'Your Music.', 'Your Sports.'];
  var cur = document.createElement('span');
  cur.id = 'nm-cursor'; cur.textContent = '|';
  el.insertAdjacentElement('afterend', cur);
  var idx = 0, pos = 0, deleting = false;
  var word = words[0];
  el.textContent = '';
  function tick() {
    if (!deleting) {
      pos++;
      el.textContent = word.slice(0, pos);
      if (pos === word.length) { deleting = true; setTimeout(tick, 1600); return; }
      setTimeout(tick, 85);
    } else {
      pos--;
      el.textContent = word.slice(0, pos);
      if (pos === 0) { deleting = false; idx = (idx + 1) % words.length; word = words[idx]; setTimeout(tick, 350); return; }
      setTimeout(tick, 45);
    }
  }
  setTimeout(tick, 600);
})();
</script>
@endpush
</x-app-layout>

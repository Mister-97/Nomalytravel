<x-app-layout>
@push('css')
<style>
.ht-hero { background:linear-gradient(160deg,#070D1A 0%,#1a3a6b 100%); padding:48px 0 36px; }
.ht-hero h1 { color:#C9A84C; font-weight:900; font-size:1.8rem; margin-bottom:6px; }
.ht-hero p { color:rgba(255,255,255,0.7); font-size:0.95rem; }
.ht-form-card { background:#fff; border-radius:16px; padding:24px 28px; box-shadow:0 10px 40px rgba(0,0,0,0.25); }
.ht-form-card label { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#666; margin-bottom:4px; display:block; }
.ht-form-card .form-control { height:52px; border:1.5px solid #dde2ec; border-radius:10px; font-size:14px; padding:12px 14px; }
.ht-form-card select.form-control { -webkit-appearance:none; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23c9a84c' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 14px center; padding-right:36px; }
.ht-form-card .form-control:focus { border-color:#C9A84C; box-shadow:none; }
.ht-search-btn { background:linear-gradient(135deg,#C9A84C,#e8c96a); color:#070D1A; border:none; height:52px; border-radius:10px; font-weight:800; font-size:15px; width:100%; }
.ht-search-btn:hover { filter:brightness(1.08); }
.ht-features { padding:48px 0; background:#f7f8fc; }
.ht-feature-icon { font-size:2rem; color:#C9A84C; margin-bottom:12px; }
.ht-feature-title { font-size:15px; font-weight:700; color:#070D1A; }
.ht-feature-text { font-size:13px; color:#777; }
@media(max-width:767px){
  .ht-hero { padding:28px 0 24px; }
  .ht-hero h1 { font-size:1.3rem; }
  .ht-form-card { padding:20px 16px 16px; border-radius:12px; margin-top:14px; }
  .ht-form-card .form-control { height:48px; font-size:14px; }
  .ht-form-card input[type="date"] { font-size:13px; padding:12px 8px; }
  .ht-form-card select.form-control { font-size:14px; }
  .ht-search-btn { height:48px; font-size:15px; }
}
</style>
@endpush

<div class="ht-hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <h1><i class="fas fa-hotel me-2"></i>Find Your Perfect Hotel</h1>
                <p>Real-time rates from thousands of properties worldwide</p>
                <div class="ht-form-card mt-4">
                    <form method="POST" action="{{ route('hotels.search') }}">
                        @csrf
                        <div class="row g-2">
                            <div class="col-12">
                                <label>City / Destination</label>
                                <input type="text" name="city" class="form-control" placeholder="e.g. Miami, New York, Paris" required value="{{ old('city') }}">
                            </div>
                            <div class="col-6">
                                <label>Check-in</label>
                                <input type="date" name="check_in" class="form-control" required
                                    value="{{ old('check_in', date('Y-m-d', strtotime('+7 days'))) }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                            <div class="col-6">
                                <label>Check-out</label>
                                <input type="date" name="check_out" class="form-control" required
                                    value="{{ old('check_out', date('Y-m-d', strtotime('+9 days'))) }}"
                                    min="{{ date('Y-m-d', strtotime('+2 days')) }}">
                            </div>
                            <div class="col-6">
                                <label>Adults</label>
                                <select name="adults" class="form-control">
                                    @for($i=1;$i<=6;$i++)
                                        <option value="{{ $i }}" {{ old('adults',2)==$i?'selected':'' }}>{{ $i }} Adult{{ $i>1?'s':'' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-6 d-flex align-items-end">
                                <button type="submit" class="ht-search-btn">
                                    <i class="fas fa-search me-1"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ht-features">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="ht-feature-icon"><i class="fas fa-globe"></i></div>
                <div class="ht-feature-title">Worldwide Inventory</div>
                <div class="ht-feature-text">Access to 2M+ properties in 200+ countries</div>
            </div>
            <div class="col-md-4">
                <div class="ht-feature-icon"><i class="fas fa-tag"></i></div>
                <div class="ht-feature-title">Best Available Rates</div>
                <div class="ht-feature-text">Real-time pricing with no hidden fees</div>
            </div>
            <div class="col-md-4">
                <div class="ht-feature-icon"><i class="fas fa-lock"></i></div>
                <div class="ht-feature-title">Secure Booking</div>
                <div class="ht-feature-text">Instant confirmation with encrypted payment</div>
            </div>
        </div>
    </div>
</div>

</x-app-layout>

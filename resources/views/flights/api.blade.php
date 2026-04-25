<?php header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); header("Pragma: no-cache"); ?>
<x-app-layout>
@push('css')
<style>
/* Google Flights-style compact single-row card */
.flights-list { border:1px solid #e0e4eb; border-radius:8px; overflow:hidden; margin-bottom:8px; }
.api-fc {
    display:flex; align-items:center; gap:10px;
    padding:7px 12px; border-bottom:1px solid #e0e4eb;
    background:#fff; width:100%; text-align:left;
    border-left:none; border-right:none; border-top:none;
    cursor:pointer; min-height:0;
}
.api-fc:last-child { border-bottom:none; }
.api-fc:hover { background:#f8f9fa; }
/* Logo */
.api-fc-logo { height:20px; width:auto; max-width:44px; object-fit:contain; flex-shrink:0; }
/* Dep time */
.api-fc-dep { font-size:14px; font-weight:700; color:#202124; white-space:nowrap; flex-shrink:0; min-width:58px; }
/* Duration bar */
.api-fc-bar { flex:1; display:flex; flex-direction:column; align-items:center; min-width:80px; }
.api-fc-bar-line { width:100%; display:flex; align-items:center; gap:0; }
.api-fc-bar-seg { flex:1; height:1px; background:#dadce0; }
.api-fc-bar-dot { width:5px; height:5px; border-radius:50%; background:#dadce0; flex-shrink:0; }
.api-fc-bar-arrow { font-size:10px; color:#9aa0a6; flex-shrink:0; }
.api-fc-bar-label { font-size:10px; color:#70757a; margin-top:1px; white-space:nowrap; }
/* Arr time */
.api-fc-arr { font-size:14px; font-weight:700; color:#202124; white-space:nowrap; flex-shrink:0; min-width:58px; text-align:right; }
/* Airline name */
.api-fc-airline { font-size:11px; color:#70757a; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; flex-shrink:1; min-width:0; max-width:100px; }
/* Stop badge */
.api-fc-stop-badge { font-size:10px; font-weight:700; white-space:nowrap; flex-shrink:0; padding:1px 5px; border-radius:3px; }
.api-fc-stop-badge.nonstop { color:#2e7d32; background:#e8f5e9; }
.api-fc-stop-badge.hasstop { color:#e65100; background:#fff3e0; }
/* Price */
.api-fc-price { font-size:14px; font-weight:800; color:#202124; white-space:nowrap; flex-shrink:0; min-width:52px; text-align:right; }
/* Select btn */
.api-fc-select { font-size:11px; font-weight:700; color:#b8960c; white-space:nowrap; flex-shrink:0; background:none; border:none; padding:0; cursor:pointer; }
.api-fc-select:hover { color:#8a6d00; text-decoration:underline; }
@media(max-width:767px){
    .api-fc { gap:6px; padding:6px 10px; }
    .api-fc-dep,.api-fc-arr { font-size:13px; min-width:50px; }
    .api-fc-price { font-size:13px; }
    .api-fc-airline { display:none; }
    .api-fc-bar { min-width:50px; }
}
</style>
@endpush
<!-- Page title start -->
<div class="pageheader">            
    <div class="container">
        <h1>Discover Your Next Adventure with Us</h1>
    </div>
</div>
<!-- Page title end -->

<!-- Top Hotels Section -->
<div class="innerpagewrap">
  <div class="container">

    <div class="row">
        <div class="col-lg-3">
            <div class="filtersidebar">                
                <form action="{{url('flights')}}">
                <!-- Locations -->
                <div class="filterbox">

                    <h5>Search Filter</h5>                    
                    <div class="mb-3">
                        <label for="">From</label>
                        <input type="text" class="form-control" name="from_location" placeholder="e.g. Alberta">
                    </div>
                    <div class="mb-3">
                        <label for="">To</label>
                        <input type="text" class="form-control" name="to_location" placeholder="e.g. New York">
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="triptype" id="onewayflight" checked="">
                          <label class="form-check-label" for="onewayflight">
                             One Way
                          </label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="triptype" id="twowayflight" checked="">
                          <label class="form-check-label" for="twowayflight">
                             Two Way
                          </label>
                        </div>
                      </div>


                      <div class="mb-3"><label for="">Travelling On</label><input type="date" name="travelling_date" class="form-control" placeholder="When"></div>
                      <div class="mb-3"><label for="">Return</label><input name="return_date" type="date" class="form-control" placeholder="When"></div>


                </div>

                <!-- Airline -->
                <div class="filterbox">
                    <h5>Airline</h5>
                    @if(null!==($airlines = module(4)))
                    @foreach($airlines as $airline)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$airline->id}}" name="airline" id="airline{{$airline->id}}" <?php if(request()->airline==$airline->id){echo 'checked';} ?>>
                        <label class="form-check-label" for="airline{{$airline->id}}">
                          {{$airline->title}}
                        </label>
                    </div>
                    @endforeach
                    @endif

                </div>

                <!-- Price Range -->
                <div class="filterbox">
                    <h5>Price Range</h5>

                    <div class="price-input">
                        <div class="field">
                          <span>Min</span>
                          <input type="number" class="input-min" value="10">
                        </div>
                        <div class="separator">-</div>
                        <div class="field">
                          <span>Max</span>
                          <input type="number" class="input-max" value="500">
                        </div>
                      </div>

                      <div class="slider">
                        <div class="progress"></div>
                      </div>
                      <div class="range-input">
                        <input type="range" class="range-min" min="0" max="10000" name="min_price" value="10" step="100">
                        <input type="range" class="range-max" min="0" max="10000" name="max_price" value="500" step="100">
                      </div>  
                </div>


                <!-- Stops -->
                

              
                <button class="btn btn-primary w-100">Apply Filter</button>
                    

                </form>
            </div>
        </div>

        <div class="col-lg-9">

            @if(isset($error))
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @else
                <div class="search-results-header">
                    <strong>Showing {{ count($flights ?? []) }} Search Results</strong>
                </div>

                @if(count($flights ?? []) > 0)
                    <div class="flights-list">
                        @foreach($flights as $flight)
                            @php
                                $seg = $flight['slices'][0]['segments'][0] ?? [];
                                $depRaw = $seg['departing_at'] ?? null;
                                $arrRaw = $seg['arriving_at'] ?? null;
                                $dep = $depRaw ? \Illuminate\Support\Carbon::parse($depRaw)->format('g:i A') : '';
                                $arr = $arrRaw ? \Illuminate\Support\Carbon::parse($arrRaw)->format('g:i A') : '';
                                $mins = ($depRaw && $arrRaw)
                                    ? (int)\Illuminate\Support\Carbon::parse($depRaw)->diffInMinutes(\Illuminate\Support\Carbon::parse($arrRaw))
                                    : 0;
                                $dur = $mins > 0 ? (floor($mins/60).'h '.($mins%60).'m') : '';
                                $airline = $flight['owner']['name'] ?? '';
                                $logo = $flight['owner']['logo_symbol_url'] ?? '';
                                $stops = count($flight['slices'][0]['segments'] ?? []) - 1;
                                $stopTxt = $stops === 0 ? 'Nonstop' : $stops . ' stop' . ($stops > 1 ? 's' : '');
                                $stopCls = $stops === 0 ? 'nonstop' : 'hasstop';
                                $amount = $flight['total_amount'] ?? '';
                                $currency = $flight['total_currency'] ?? 'USD';
                                $price = $currency === 'USD' ? '$' . number_format((float)$amount, 0) : $amount . ' ' . $currency;
                                $offerId = $flight['id'] ?? '';
                            @endphp
                            <button class="api-fc" onclick="selectFlight('{{ $offerId }}')">
                                @if($logo)
                                <img class="api-fc-logo" src="{{ $logo }}" alt="{{ $airline }}" onerror="this.style.display='none'">
                                @endif
                                <span class="api-fc-dep">{{ $dep }}</span>
                                <div class="api-fc-bar">
                                    <div class="api-fc-bar-line">
                                        <span class="api-fc-bar-seg"></span>
                                        <span class="api-fc-bar-dot"></span>
                                        <span class="api-fc-bar-seg"></span>
                                        <span class="api-fc-bar-arrow">&#8250;</span>
                                    </div>
                                    <span class="api-fc-bar-label">{{ $dur }}</span>
                                </div>
                                <span class="api-fc-arr">{{ $arr }}</span>
                                <span class="api-fc-airline">{{ $airline }}</span>
                                <span class="api-fc-stop-badge {{ $stopCls }}">{{ $stopTxt }}</span>
                                <span class="api-fc-price">{{ $price }}</span>
                                <span class="api-fc-select">Select &#8250;</span>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        No flights found for your search criteria.
                    </div>
                @endif
            @endif

        </div>
    </div>
    
    

  </div>
</div>

<!-- Widgets -->
<div class="container pb-5">
  <div class="row">
    <div class="col-lg-6">
        <div class="hotelwidget">
            <h2>25% Off</h2>
            <h3>Explore the World, One Destination at a Time</h3>
            <a href="#" class="btn btn-sec">Book Now</a>
        </div>
    </div>
    <div class="col-lg-6">
      <div class="fligtwidget">
          <h2>25% Off</h2>
          <h3>Experience the World in Extraordinary Ways</h3>
          <a href="#" class="btn btn-sec">Book Now</a>
      </div>
  </div>
  </div>
</div>
</x-app-layout>
<x-app-layout>
    <!-- Page title start -->
    <form action="{{ url('/flights/search') }}" method="GET">
        <div class="flightinthero">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">

                <h1>{{ __('frontend.search_flights') }}</h1>
                <div class="duffeltopsearch">

                    @php
                        $triptype = request('triptype');
                    @endphp

                    <div class="tripetype" role="group">
                        <input type="radio" class="btn-check" name="triptype" id="onewayflight" value="oneway"
                            {{ isset($triptype) && $triptype == 'oneway'
                                ? 'checked'
                                : (!in_array($triptype, ['twoway', 'Multicity'])
                                    ? 'checked'
                                    : '') }}>
                        <label class="btn btn-outline-primary" for="onewayflight">One Way</label>

                        <input type="radio" class="btn-check" name="triptype" id="twowayflight" value="twoway"
                            {{ isset($triptype) && $triptype == 'twoway' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="twowayflight">Round Trip</label>

                        <input type="radio" class="btn-check" name="triptype" id="Multi-city" value="Multicity"
                            {{ isset($triptype) && $triptype == 'Multicity' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="Multi-city">Multi-city</label>
                    </div>

                    @php
                        $slices = request('slices');
                    @endphp

                    <div class="row single-city">
                        <div class="col">
                            <div class="mt-3">
                                <label>From</label>
                                <input type="text" class="form-control from_location" name="slices[0][from_location]"
                                    id="from_location"
                                    placeholder="{{ request('from_type') == 'code' ? 'e.g. LHR' : 'e.g. London' }}"
                                    value="{{ $slices[0]['from_location'] ?? '' }}">
                                <input type="hidden" name="slices[0][from]" class="from_code" id="from_code"
                                    value="{{ $slices[0]['from'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col">
                            <div class="mt-3">
                                <label>To</label>
                                <input type="text" class="form-control to_location" name="slices[0][to_location]"
                                    id="to_location"
                                    placeholder="{{ request('to_type') == 'code' ? 'e.g. JFK' : 'e.g. New York' }}"
                                    value="{{ $slices[0]['to_location'] ?? '' }}">
                                <input type="hidden" name="slices[0][to]" id="to_code" class="to_code"
                                    value="{{ $slices[0]['to'] ?? '' }}">
                            </div>
                        </div>

                        <div class="col">
                            <div class="mt-3">
                                <label>Travelling On</label>
                                <input type="text" name="slices[0][travelling_date]" id="travelling_date"
                                    class="form-control travelling_date" placeholder="Select From Date"
                                    value="{{ $slices[0]['travelling_date'] ?? '' }}" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-auto hidden-button"
                            @if (request('triptype') != 'Multicity') style="display: none;" @endif>
                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-city w-100"
                                    style="visibility: hidden;" title="Remove this city">
                                    &times;
                                </button>
                            </div>
                        </div>

                        <div class="col return-date" @if (request('triptype') != 'twoway') style="display: none;" @endif>
                            <div class="mt-3">
                                <label>Return</label>
                                <input name="return_date" type="text" id="return_date" class="form-control"
                                    placeholder="Select Return Date" value="{{ request('return_date') }}"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="multiple-city">
                    </div>

                    <div class="row">
                        <div class="col-md-3 mutiple-button me-auto" @if (request('triptype') != 'Multicity') style="display: none;" @endif>
                            <div class="addmoreflight">
                                <button type="button" id="add-city" class="btn btn-sec">
                                    + Add Flight
                                </button>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mt-3">
                                <label>Cabin Class</label>
                                <select class="form-control" name="cabin_class">
                                    <option value="">Any Class</option>
                                    <option value="economy"
                                        {{ request('cabin_class') == 'economy' ? 'selected' : '' }}>
                                        Economy</option>
                                    <option value="premium_economy"
                                        {{ request('cabin_class') == 'premium_economy' ? 'selected' : '' }}>Premium
                                        Economy</option>
                                    <option value="business"
                                        {{ request('cabin_class') == 'business' ? 'selected' : '' }}>Business</option>
                                    <option value="first" {{ request('cabin_class') == 'first' ? 'selected' : '' }}>
                                        First Class</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mt-3">
                                <label>Adults</label>
                                <input type="number" class="form-control" name="adults" min="1"
                                    max="9" value="{{ request('adults', 1) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mt-3">
                                <label>Children</label>
                                <input type="number" class="form-control" name="children" min="0"
                                    max="9" value="{{ request('children', 0) }}">
                            </div>
                        </div>
                        <div class="col-md-2 ms-auto text-right mt-3"><label>&nbsp;</label> <button
                                class="btn btn-primary d-block w-100">Search</button></div>
                    </div>

                </div>

                 </div>
                </div>

            </div>
        </div>
        <!-- Page title end -->
        <!-- Main Content -->
        <div class="innerpagewrap">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-lg-9">

                     <button class="btn btn-primary d-md-none w-100 mb-2" id="filter-toggle-btn" type="button">
                        <i class="fa fa-sliders"></i> Filter &amp; Sort
                     </button>
                     <div class="sortingbox sticky-top" id="filter-bar" @if (request()->path() === 'flights' && count(request()->query()) === 0) style="display:none" @endif>

                        <div class="row">
                            <!-- Sort By -->
                            <div class="col-md-3">
                                    <label class="form-label d-block" for="sort_by">Sort By</label>
                                    <select class="form-select form-control" name="sort_by" id="sort_by">
                                        <option value="best"
                                            {{ request('sort_by') == 'best' || !request('sort_by') ? 'selected' : '' }}>Best</option>
                                        <option value="price_asc"
                                            {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Cheapest
                                        </option>
                                        <option value="price_desc"
                                            {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Most Expensive
                                        </option>
                                        <option value="duration_asc"
                                            {{ request('sort_by') == 'duration_asc' ? 'selected' : '' }}>Fastest
                                        </option>
                                        <option value="duration_desc"
                                            {{ request('sort_by') == 'duration_desc' ? 'selected' : '' }}>Longest
                                            Duration
                                        </option>
                                    </select>
                            </div>

                            <!-- Stops -->
                            <div class="col-md-3">
                                    <label class="form-label d-block" for="max_connections">Stops</label>
                                    <select name="max_connections" id="max_connections" class="form-control form-select">
                                        <option value=""
                                            {{ empty(request('max_connections')) ? 'selected' : '' }}>
                                            Any Stops
                                        </option>
                                        <option value="0"
                                            {{ request('max_connections') === '0' ? 'selected' : '' }}>
                                            Non-stop Only
                                        </option>
                                        <option value="1"
                                            {{ request('max_connections') === '1' ? 'selected' : '' }}>
                                            1 Stop or Less
                                        </option>
                                        <option value="2"
                                            {{ request('max_connections') === '2' ? 'selected' : '' }}>
                                            2 Stops or Less
                                        </option>
                                    </select>
                            </div>

                            <!-- Airline Select -->
                            <div class="col-md-4">
                                    <label for="airline">Airline</label>
                                    <select name="airline" id="airline" class="form-control">
                                        <option value="" {{ request('airline') == null ? 'selected' : '' }}>All Airlines</option>
                                        @php
                                        // Normalize airlines: handles both string arrays and object arrays from different controllers
                                        $usNames = ['United', 'Delta', 'American', 'Southwest', 'JetBlue', 'Alaska', 'Frontier', 'Sun Country'];
                                        $usAirlineFound = [];
                                        $otherAirlines = [];
                                        if (!empty($airlines)) {
                                            foreach ($airlines as $alKey => $al) {
                                                if (is_array($al)) {
                                                    $alId   = $al['id'] ?? $alKey;
                                                    $alName = $al['name'] ?? '';
                                                } else {
                                                    $alId = $alName = (string)$al;
                                                }
                                                if (empty($alName)) continue;
                                                $isUS = false;
                                                foreach ($usNames as $us) {
                                                    if (stripos($alName, $us) !== false) { $isUS = true; break; }
                                                }
                                                $entry = ['id' => $alId, 'name' => $alName];
                                                if ($isUS) $usAirlineFound[] = $entry;
                                                else $otherAirlines[] = $entry;
                                            }
                                        }
                                        @endphp
                                        @if(count($usAirlineFound) > 0)
                                            <optgroup label="US Airlines">
                                            @foreach($usAirlineFound as $al)
                                                <option value="{{ $al['id'] }}" {{ request('airline') == $al['id'] ? 'selected' : '' }}>{{ $al['name'] }}</option>
                                            @endforeach
                                            </optgroup>
                                        @endif
                                        @if(count($otherAirlines) > 0)
                                            <optgroup label="International">
                                            @foreach($otherAirlines as $al)
                                                <option value="{{ $al['id'] }}" {{ request('airline') == $al['id'] ? 'selected' : '' }}>{{ $al['name'] }}</option>
                                            @endforeach
                                            </optgroup>
                                        @endif
                                    </select>
                            </div>

                             <div class="col-md-2 ms-auto text-right"><label>&nbsp;</label> <button
                                class="btn btn-sec d-block w-100">
                                Apply</button>
                            </div>

                        </div>

                    </div>

                    @php
                    if (!function_exists('nmAirportTimezone')) {
                        function nmAirportTimezone(string $iata): string {
                            $map = [
                                'JFK'=>'America/New_York','LGA'=>'America/New_York','EWR'=>'America/New_York',
                                'BOS'=>'America/New_York','MIA'=>'America/New_York','FLL'=>'America/New_York',
                                'MCO'=>'America/New_York','TPA'=>'America/New_York','PHL'=>'America/New_York',
                                'DCA'=>'America/New_York','IAD'=>'America/New_York','BWI'=>'America/New_York',
                                'ATL'=>'America/New_York','CLT'=>'America/New_York','DTW'=>'America/New_York',
                                'PIT'=>'America/New_York','BUF'=>'America/New_York','RDU'=>'America/New_York',
                                'ORF'=>'America/New_York','RIC'=>'America/New_York','SYR'=>'America/New_York',
                                'CLE'=>'America/New_York','CMH'=>'America/New_York','IND'=>'America/Indiana/Indianapolis',
                                'ORD'=>'America/Chicago','MDW'=>'America/Chicago','MSP'=>'America/Chicago',
                                'STL'=>'America/Chicago','DFW'=>'America/Chicago','DAL'=>'America/Chicago',
                                'HOU'=>'America/Chicago','IAH'=>'America/Chicago','MSY'=>'America/Chicago',
                                'MKE'=>'America/Chicago','OMA'=>'America/Chicago','MCI'=>'America/Chicago',
                                'BNA'=>'America/Chicago','MEM'=>'America/Chicago','LIT'=>'America/Chicago',
                                'DSM'=>'America/Chicago','OKC'=>'America/Chicago','TUL'=>'America/Chicago',
                                'DEN'=>'America/Denver','SLC'=>'America/Denver','ABQ'=>'America/Denver',
                                'ELP'=>'America/Denver','BOI'=>'America/Denver','BIL'=>'America/Denver',
                                'PHX'=>'America/Phoenix','TUS'=>'America/Phoenix',
                                'LAX'=>'America/Los_Angeles','SFO'=>'America/Los_Angeles',
                                'SJC'=>'America/Los_Angeles','SEA'=>'America/Los_Angeles',
                                'PDX'=>'America/Los_Angeles','LAS'=>'America/Los_Angeles',
                                'SAN'=>'America/Los_Angeles','OAK'=>'America/Los_Angeles',
                                'SNA'=>'America/Los_Angeles','BUR'=>'America/Los_Angeles',
                                'SMF'=>'America/Los_Angeles','ONT'=>'America/Los_Angeles',
                                'RNO'=>'America/Los_Angeles','SBA'=>'America/Los_Angeles',
                                'HNL'=>'Pacific/Honolulu','OGG'=>'Pacific/Honolulu',
                                'KOA'=>'Pacific/Honolulu','LIH'=>'Pacific/Honolulu',
                                'ANC'=>'America/Anchorage','FAI'=>'America/Anchorage',
                                'LHR'=>'Europe/London','LGW'=>'Europe/London','LCY'=>'Europe/London',
                                'CDG'=>'Europe/Paris','ORY'=>'Europe/Paris',
                                'FRA'=>'Europe/Berlin','MUC'=>'Europe/Berlin','DUS'=>'Europe/Berlin',
                                'AMS'=>'Europe/Amsterdam','MAD'=>'Europe/Madrid','BCN'=>'Europe/Madrid',
                                'FCO'=>'Europe/Rome','MXP'=>'Europe/Rome',
                                'DXB'=>'Asia/Dubai','DOH'=>'Asia/Qatar',
                                'NRT'=>'Asia/Tokyo','HND'=>'Asia/Tokyo',
                                'PEK'=>'Asia/Shanghai','PVG'=>'Asia/Shanghai',
                                'SIN'=>'Asia/Singapore','BKK'=>'Asia/Bangkok',
                                'SYD'=>'Australia/Sydney','MEL'=>'Australia/Melbourne',
                                'YYZ'=>'America/Toronto','YVR'=>'America/Vancouver','YUL'=>'America/Montreal',
                                'MEX'=>'America/Mexico_City','GDL'=>'America/Mexico_City',
                                'GRU'=>'America/Sao_Paulo','EZE'=>'America/Argentina/Buenos_Aires',
                                'BOG'=>'America/Bogota','LIM'=>'America/Lima','SCL'=>'America/Santiago',
                            ];
                            return $map[$iata] ?? '';
                        }
                        function nmFormatFlightTime(string $datetime, string $iata): string {
                            try {
                                $tz = nmAirportTimezone($iata);
                                $c = \Carbon\Carbon::parse($datetime);
                                if ($tz) $c = $c->setTimezone($tz);
                                $abbr = $c->format('T');
                                // Map offset-based abbreviations to standard US names
                                $abbrMap = [
                                    '-05:00'=>'EST','-06:00'=>'CST','-07:00'=>'MST','-08:00'=>'PST',
                                    '+00:00'=>'GMT','+01:00'=>'CET','+02:00'=>'EET',
                                ];
                                if (strlen($abbr) > 4) $abbr = $abbrMap[$abbr] ?? $abbr;
                                return $c->format('g:i A') . ' ' . $abbr;
                            } catch (\Exception $e) {
                                return date('g:i A', strtotime($datetime));
                            }
                        }
                    }
                    @endphp

                        <div id="flight-results">
                            @if (isset($error))
                                <div class="alert alert-warning text-center">
                                    {{ $error }}
                                </div>
                            @else
                                <div class="search-results-header mb-4 text-center">
                                    <h2>Showing {{ count($flights ?? []) }} Search Results</h2>
                                </div>

                                @if (count($flights ?? []) > 0)
                                    <div class="flights-list">
                                        @foreach ($flights as $index => $flight)
                                <div class="nm-flight-card {{ $index >= 6 ? 'd-none extra-flight' : '' }}" data-index="{{ $index }}">
                                  <div class="nm-card">

                                    {{-- Airline col --}}
                                    <div class="nm-airline">
                                      <img src="{{ $flight['owner']['logo_symbol_url'] ?? '' }}"
                                           alt="{{ $flight['owner']['name'] ?? 'Airline' }}"
                                           onerror="this.style.display='none'">
                                      <div class="nm-airline-name">{{ $flight['owner']['name'] ?? '' }}</div>
                                      <div class="nm-cabin-badge">
                                        {{ $flight['slices'][0]['segments'][0]['passengers'][0]['cabin_class_marketing_name'] ?? 'Economy' }}
                                      </div>
                                    </div>

                                    <div class="nm-vr"></div>

                                    {{-- Route(s) --}}
                                    <div class="nm-routes">
                                      @foreach ($flight['slices'] as $si => $slice)
                                        @php
                                          $dep    = $slice['segments'][0]['departing_at'];
                                          $arr    = $slice['segments'][count($slice['segments'])-1]['arriving_at'];
                                          $depIata = $slice['origin']['iata_code'] ?? '';
                                          $arrIata = $slice['destination']['iata_code'] ?? '';
                                          $stops  = count($slice['segments']) - 1;
                                          $rawDur = $slice['duration'] ?? ($slice['segments'][0]['duration'] ?? '');
                                          if ($rawDur) {
                                            preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?/', $rawDur, $dm);
                                            $durLabel = trim(($dm[1] ?? 0) > 0 ? $dm[1].'h ' : '') . trim(($dm[2] ?? 0) > 0 ? $dm[2].'m' : '');
                                          } else { $durLabel = ''; }
                                          $depFormatted = nmFormatFlightTime($dep, $depIata);
                                          $arrFormatted = nmFormatFlightTime($arr, $arrIata);
                                        @endphp
                                        <div class="nm-route-row">
                                          <div class="nm-ep">
                                            <div class="nm-time">{{ $depFormatted }}</div>
                                            <div class="nm-iata">{{ $depIata }}</div>
                                            <div class="nm-city-name">{{ $slice['origin']['city_name'] ?? '' }}</div>
                                            <div class="nm-route-date">{{ date('D d M', strtotime($dep)) }}</div>
                                          </div>
                                          <div class="nm-path">
                                            @if($durLabel)<div class="nm-dur">{{ $durLabel }}</div>@endif
                                            <div class="nm-line-wrap">
                                              <span class="nm-dot-start"></span>
                                              <div class="nm-line-bar">
                                                <i class="fas fa-plane nm-plane-ico"></i>
                                              </div>
                                              <span class="nm-dot-end"></span>
                                            </div>
                                            <div class="nm-stops-lbl {{ $stops === 0 ? 'nm-direct' : '' }}">
                                              {{ $stops === 0 ? 'Non-stop' : $stops.' stop'.($stops>1?'s':'') }}
                                            </div>
                                          </div>
                                          <div class="nm-ep nm-ep-right">
                                            <div class="nm-time">{{ $arrFormatted }}</div>
                                            <div class="nm-iata">{{ $arrIata }}</div>
                                            <div class="nm-city-name">{{ $slice['destination']['city_name'] ?? '' }}</div>
                                            <div class="nm-route-date">{{ date('D d M', strtotime($arr)) }}</div>
                                          </div>
                                        </div>
                                        @if(!$loop->last)<hr class="nm-slice-hr">@endif
                                      @endforeach
                                    </div>

                                    <div class="nm-vr"></div>

                                    {{-- Price --}}
                                    <div class="nm-price-col">
                                      <div class="nm-amount">{{ number_format((float)($flight['total_amount'] ?? 0), 0) }}</div>
                                      <div class="nm-curr">{{ $flight['total_currency'] ?? 'USD' }}</div>
                                      <div class="nm-per">per person &middot; total fare</div>
                                      <a href="{{ route('flights.booking.form', trim($flight['id'])) }}"
                                         class="nm-book-btn"
                                         style="display:block;text-align:center;text-decoration:none;">
                                        <i class="fas fa-bolt"></i> Book Now
                                      </a>
                                    </div>

                                  </div>
                                </div>
                                        @endforeach
                                    </div>

                                    @if (count($flights) > 6)
                                        <div class="text-center mt-4 mb-2">
                                            <button id="load-more-flights" class="nm-show-more" type="button">
                                                <i class="fas fa-chevron-down"></i> Show More Flights
                                            </button>
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-info text-center">
                                        No flights found for your search criteria.
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                </div>



                @if (null !== ($arilines = moduleF(4)))
        <!-- Popular Flights -->
        <div class="popflights pt-5">
            <div class="container">
                <ul class="row topaircompany">
                    @foreach ($arilines as $airline)
                        <li class="col-4 col-lg mb-3">
                            <div class="arilinebox">
                            <img src="{{ asset('images/' . $airline->image) }}">
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif



                <!-- Widgets -->
                <div class="container pt-5">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php $widget = widget(5); ?>
                            <?php $img = asset('images/' . $widget->extra_image_1); ?>
                            <div class="hotelwidget" style="background: url({{ $img }}) no-repeat;">
                                <h2>{{ $widget->extra_field_1 }}</h2>
                                <h3>{{ $widget->description }}</h3>
                                <a href="#" class="btn btn-sec">Book Now</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <?php $widget = widget(6); ?>
                            <?php $img = asset('images/' . $widget->extra_image_1); ?>
                            <div class="hotelwidget" style="background: url({{ $img }}) no-repeat;">
                                <h2>{{ $widget->extra_field_1 }}</h2>
                                <h3>{{ $widget->description }}</h3>
                                <a href="#" class="btn btn-sec">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@push('css')
<style>
/* Google Flights-style Airport Autocomplete */
.nm-ac-dropdown { 
    border-radius: 12px !important; 
    box-shadow: 0 8px 32px rgba(0,0,0,0.18) !important; 
    border: 1px solid #e0e4ef !important;
    max-height: 400px; overflow-y: auto;
    padding: 4px 0 !important;
}
.nm-ac-dropdown .ui-menu-item { padding: 0 !important; }
.nm-ac-city-item { cursor: pointer; }
.nm-ac-city-item.ui-state-active .nm-ac-city-row,
.nm-ac-city-item:hover .nm-ac-city-row { background: #f0f4ff; }
.nm-ac-city-row {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 16px 8px; border-bottom: 1px solid #f0f0f0;
}
.nm-ac-city-name { font-size: 14px; font-weight: 700; color: #0a1628; }
.nm-ac-city-sub { font-size: 11px; color: #999; margin-top: 1px; }
.nm-ac-airport-item { cursor: pointer; }
.nm-ac-airport-item.ui-state-active .nm-ac-airport-row,
.nm-ac-airport-item:hover .nm-ac-airport-row { background: #fef9ec; }
.nm-ac-airport-row {
    display: flex; align-items: center; gap: 12px;
    padding: 8px 16px 8px 28px;
}
.nm-ac-airport-info { display: flex; align-items: center; gap: 8px; flex: 1; }
.nm-ac-airport-name { font-size: 13px; color: #333; flex: 1; }
.nm-ac-airport-code { 
    font-size: 11px; font-weight: 800; color: #c9a84c; 
    background: #fef9ec; border: 1px solid #e8d89a;
    padding: 2px 7px; border-radius: 4px; letter-spacing: 0.5px;
}
.nm-ac-icon { font-size: 13px; color: #0a1628; width: 16px; flex-shrink: 0; }
.nm-ac-icon-airport { color: #c9a84c; }
.ui-autocomplete { z-index: 9999 !important; }
</style>
<style>
/* ── Nomaly Flight Card ─────────────────────────────────────────── */
.nm-flight-card { margin-bottom: 14px; }
.nm-card {
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 2px 16px rgba(20,30,80,.07);
  border-left: 4px solid #c9a84c;
  display: flex;
  align-items: center;
  padding: 18px 20px;
  gap: 16px;
  transition: box-shadow .2s, transform .15s;
}
.nm-card:hover { box-shadow: 0 6px 28px rgba(20,30,80,.13); transform: translateY(-2px); }

/* Airline */
.nm-airline { display:flex; flex-direction:column; align-items:center; min-width:82px; flex-shrink:0; }
.nm-airline img { width:46px; height:46px; object-fit:contain; margin-bottom:5px; }
.nm-airline-name { font-size:11px; color:#666; text-align:center; font-weight:500;
  white-space:nowrap; max-width:88px; overflow:hidden; text-overflow:ellipsis; }
.nm-cabin-badge { margin-top:7px; font-size:10px; background:#f0e8d0; color:#9a7b2e;
  border-radius:20px; padding:2px 9px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; }

/* Vertical rule */
.nm-vr { width:1px; height:70px; background:#ececec; flex-shrink:0; }

/* Routes */
.nm-routes { flex:1; display:flex; flex-direction:column; gap:8px; min-width:0; }
.nm-route-row { display:flex; align-items:center; gap:0; }
.nm-ep { min-width:100px; flex-shrink:0; }
.nm-ep-right { text-align:right; }
.nm-time { font-size:18px; font-weight:800; color:#0a1628; line-height:1; white-space:nowrap; }
.nm-iata { font-size:12px; font-weight:700; color:#c9a84c; letter-spacing:1.2px; margin-top:2px; }
.nm-city-name { font-size:11px; color:#666; margin-top:1px; white-space:nowrap;
  overflow:hidden; text-overflow:ellipsis; max-width:95px; }
.nm-route-date { font-size:10px; color:#aaa; margin-top:1px; }

/* Path */
.nm-path { flex:1; display:flex; flex-direction:column; align-items:center; padding:0 10px; }
.nm-dur { font-size:12px; font-weight:600; color:#444; margin-bottom:4px; }
.nm-line-wrap { width:100%; display:flex; align-items:center; }
.nm-dot-start,.nm-dot-end { width:7px; height:7px; border-radius:50%; background:#c9a84c; flex-shrink:0; }
.nm-line-bar { flex:1; height:2px; background:linear-gradient(90deg,#c9a84c 0%,#0a1628 100%);
  position:relative; }
.nm-plane-ico { position:absolute; left:50%; top:50%; transform:translate(-50%,-58%);
  color:#0a1628; font-size:13px; }
.nm-stops-lbl { font-size:11px; color:#999; margin-top:4px; font-weight:500; }
.nm-stops-lbl.nm-direct { color:#27ae60; font-weight:700; }
.nm-slice-hr { margin:6px 0; border-color:#f0f0f0; }

/* Price */
.nm-price-col { min-width:130px; text-align:center; flex-shrink:0; }
.nm-amount { font-size:28px; font-weight:900; color:#0a1628; line-height:1; }
.nm-curr { font-size:13px; font-weight:700; color:#c9a84c; margin-top:2px; }
.nm-per { font-size:10px; color:#bbb; margin-bottom:12px; margin-top:1px; }
.nm-book-btn {
  background:linear-gradient(135deg,#0a1628 0%,#1a3a6b 100%);
  color:#fff; border:none; border-radius:9px; padding:10px 18px;
  font-size:13px; font-weight:700; width:100%; cursor:pointer;
  transition:opacity .2s, transform .1s; letter-spacing:.3px;
  border: 2px solid #c9a84c;
}
.nm-book-btn:hover { background:linear-gradient(135deg,#c9a84c 0%,#e8c96a 100%); color:#0a1628; transform:scale(1.03); }
.nm-book-btn i { margin-right:4px; }

/* Show more */
.nm-show-more {
  background:none; border:2px solid #c9a84c; color:#c9a84c;
  border-radius:30px; padding:10px 32px; font-size:14px; font-weight:600;
  cursor:pointer; transition:all .2s;
}
.nm-show-more:hover { background:#c9a84c; color:#0a1628; }
.nm-show-more i { margin-right:6px; }

@media (max-width:767px) {
  .nm-card { flex-wrap:wrap; border-left:none; border-top:4px solid #c9a84c; padding:14px; gap:12px; }
  .nm-vr { display:none; }
  .nm-airline { flex-direction:row; gap:10px; min-width:100%; }
  .nm-routes { min-width:100%; }
  .nm-price-col { min-width:100%; }
  .nm-time { font-size:16px; }
  .nm-amount { font-size:22px; }
  .nm-book-btn { padding:12px; }
  #filter-bar { position:static !important; }
  #filter-bar .row > div { margin-bottom:10px; }
  #filter-toggle-btn { background:#0a1628; border-color:#c9a84c; font-weight:600; }
}
</style>
@endpush
    @push('js')
                                <script>

            // Mobile filter bar toggle
            (function() {
                var btn = document.getElementById('filter-toggle-btn');
                var bar = document.getElementById('filter-bar');
                if (btn && bar) {
                    if (window.innerWidth < 768 && bar.style.display !== 'none') {
                        bar.style.display = 'none';
                    }
                    btn.addEventListener('click', function() {
                        bar.style.display = (bar.style.display === 'none') ? 'block' : 'none';
                    });
                }
            })();

            // Auto-submit sort/filter selects
            document.querySelectorAll('#sort_by, #max_connections, #airline').forEach(function(el) {
                el.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            });

            function initDatepickers() {
                $('.travelling_date').each(function() {
                    if (!$(this).hasClass('hasDatepicker')) {
                        $(this).datepicker({
                            dateFormat: 'yy-mm-dd',
                            minDate: 0
                        });
                    }
                });
            }

            // Google Flights-style airport autocomplete
            var nmAirportSearchUrl = "{{ route('flights.search.airports') }}";
                // Google Flights-style grouped airport autocomplete
                function nmSetupAirportAC(inputId, codeId) {
                    var $input = $('#' + inputId);
                    var $code  = $('#' + codeId);
            
                    $input.autocomplete({
                        source: function(req, res) {
                            $.ajax({
                                url: nmAirportSearchUrl,
                                dataType: 'json',
                                data: { query: req.term },
                                success: function(data) { res(data); },
                                error: function() { res([]); }
                            });
                        },
                        minLength: 2,
                        delay: 200,
                        select: function(e, ui) {
                            e.preventDefault();
                            if (ui.item.itemType === 'city') {
                                $input.val(ui.item.city + ' (' + ui.item.code + ')');
                            } else {
                                $input.val(ui.item.city + ' (' + ui.item.code + ')');
                            }
                            $code.val(ui.item.code);
                            return false;
                        },
                        focus: function(e, ui) {
                            e.preventDefault();
                            return false;
                        }
                    });
            
                    // Custom renderer for grouped items
                    var widget = $input.autocomplete('instance');
                    if (widget) {
                        widget._renderItem = function(ul, item) {
                            if (item.itemType === 'city') {
                                return $('<li class="nm-ac-city-item">')
                                    .append('<div class="nm-ac-city-row"><i class="fas fa-map-marker-alt nm-ac-icon"></i><div><div class="nm-ac-city-name">' + (item.city || item.label) + '</div><div class="nm-ac-city-sub">' + (item.country || '') + '</div></div></div>')
                                    .appendTo(ul);
                            } else {
                                return $('<li class="nm-ac-airport-item">')
                                    .append('<div class="nm-ac-airport-row"><i class="fas fa-plane-departure nm-ac-icon nm-ac-icon-airport"></i><div class="nm-ac-airport-info"><span class="nm-ac-airport-name">' + (item.displayName || item.label) + '</span><span class="nm-ac-airport-code">' + (item.code || '') + '</span></div></div>')
                                    .appendTo(ul);
                            }
                        };
                        widget._renderMenu = function(ul, items) {
                            var self = this;
                            $.each(items, function(i, item) { self._renderItemData(ul, item); });
                            ul.addClass('nm-ac-dropdown');
                        };
                    }
                }

            function setupAutocomplete(inputSelector, codeSelector, typeSelector) {
                $(inputSelector).each(function() {
                    const $input = $(this);
                    const $code = $input.closest('.city-row, .single-city').find(codeSelector);
                    const inputId = 'nm_ac_' + Math.random().toString(36).substr(2,9);
                    $input.attr('id', inputId);
                    const codeId = 'nm_code_' + Math.random().toString(36).substr(2,9);
                    $code.attr('id', codeId);
                    nmSetupAirportAC(inputId, codeId);
                });
            }

            function addCityRow() {
                const sliceIndex = $('.multiple-city .single-city').length + 1;
                let new_html = `
            <div class="row single-city align-items-end">
                <div class="col-12"><h4 class="newflighttitle">Add New Flight Details</h4></div>
                <div class="col">
                    <div class="mt-3">
                        <label>From</label>
                        <input type="text" class="form-control from_location" name="slices[${sliceIndex}][from_location]"
                            placeholder="e.g. London">
                        <input type="hidden" name="slices[${sliceIndex}][from]" class="from_code" value="">
                    </div>
                </div>
                <div class="col">
                    <div class="mt-3">
                        <label>To</label>
                        <input type="text" class="form-control to_location" name="slices[${sliceIndex}][to_location]"
                            placeholder="e.g. New York">
                        <input type="hidden" name="slices[${sliceIndex}][to]" class="to_code" value="">
                    </div>
                </div>
                <div class="col">
                    <div class="mt-3">
                        <label>Travelling On</label>
                        <input type="text" name="slices[${sliceIndex}][travelling_date]" class="form-control travelling_date"
                            placeholder="Select From Date" autocomplete="off">
                    </div>
                </div>
                <div class="col-auto">
                    <div class="mt-3">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-city w-100" style="visibility: visible;"
                            title="Remove this city">
                            &times;
                        </button>
                    </div>
                </div>
            </div>`;

                $('.multiple-city').append(new_html);
                initDatepickers();
                setupAutocomplete('.multiple-city .from_location:last', '.from_code:last', '#from_type');
                setupAutocomplete('.multiple-city .to_location:last', '.to_code:last', '#to_type');
            }

            function checkFlightLimit() {
                if ($('.single-city').length >= 6) {
                    $('#add-city').prop('disabled', true);
                } else {
                    $('#add-city').prop('disabled', false);
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                initDatepickers();
                setupAutocomplete('.from_location', '.from_code', '#from_type');
                setupAutocomplete('.to_location', '.to_code', '#to_type');
            });
            $(document).ready(function() {

                $('input[name="triptype"]').change(function() {
                    if ($(this).val() === 'twoway') {
                        $('.multiple-city').empty();
                        $(".mutiple-button,.hidden-button").hide();
                        $('.return-date').show();
                        $('#return_date').prop('required', true);
                    } else if ($(this).val() === 'oneway') {
                        $('.return-date').hide();
                        $(".mutiple-button,.hidden-button").hide();
                        $('.multiple-city').empty();
                        $('#return_date').prop('required', false);
                        $('#return_date').val('');
                    } else {
                        $(".mutiple-button,.hidden-button").show();
                        $('.return-date').hide();
                        $('#return_date').prop('required', false);
                        $('#return_date').val('');
                        if ($('.multiple-city .single-city').length === 0) {
                            addCityRow();
                        }
                    }
                });

                $('#return_date').datepicker({
                    dateFormat: 'yy-mm-dd',
                    minDate: 0
                });

                $('.select-flight-btn').click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const offerId = $(this).data('offer-id');
                    const origin = $(this).data('origin');
                    const destination = $(this).data('destination');
                    $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
                    $(this).prop('disabled', true);
                    sessionStorage.setItem('origin_code', origin);
                    sessionStorage.setItem('destination_code', destination);
                    const bookingUrl = '{{ route("flights.booking.form", "__ID__") }}'.replace('__ID__', offerId);
                    window.location.href = bookingUrl;
                });

                $('form').on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let hasError = false;
                    form.find('.text-danger.error-msg').remove();
                    form.find('.from_location:visible').each(function() {
                        let $input = $(this);
                        let fromCode = $input.closest('.single-city').find('.from_code').val();
                        if (!$input.val() || !fromCode) {
                            showError($input, 'Please select a valid origin location');
                            hasError = true;
                        }
                    });
                    form.find('.to_location:visible').each(function() {
                        let $input = $(this);
                        let toCode = $input.closest('.single-city').find('.to_code').val();
                        if (!$input.val() || !toCode) {
                            showError($input, 'Please select a valid destination location');
                            hasError = true;
                        }
                    });
                    let previousDate = null;
                    form.find('.travelling_date:visible').each(function() {
                        let $input = $(this);
                        let dateVal = $input.val();
                        if (!dateVal) {
                            showError($input, 'Please select a departure date');
                            hasError = true;
                            return;
                        }
                        let currentDate = new Date(dateVal);
                        if (previousDate !== null && currentDate < previousDate) {
                            showError($input, 'This date cannot be earlier than the previous one');
                            hasError = true;
                        }
                        previousDate = currentDate;
                    });
                    let tripType = $('input[name="triptype"]:checked').val();
                    let returnDateInput = $('#return_date');
                    if (tripType === 'twoway' && returnDateInput.is(':visible') && !returnDateInput.val()) {
                        showError(returnDateInput, 'Please select a return date for a two-way trip');
                        hasError = true;
                    }
                    if (hasError) return false;
                    form.find('button[type="submit"]').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Searching...'
                    ).prop('disabled', true);
                    this.submit();
                    function showError($input, message) {
                        let errorDiv = $('<div class="text-danger mt-1 error-msg">' + message + '</div>');
                        $input.closest('.mt-3').append(errorDiv);
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const loadMoreBtn = document.getElementById('load-more-flights');
                if (loadMoreBtn) {
                    loadMoreBtn.addEventListener('click', function() {
                        const extraFlights = document.querySelectorAll('.extra-flight');
                        extraFlights.forEach(function(el) {
                            el.classList.remove('d-none', 'extra-flight');
                        });
                        loadMoreBtn.style.display = 'none';
                    });
                }
            });
        </script>
</x-app-layout>

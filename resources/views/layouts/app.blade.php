<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        
        <?php 

        $seo = seo (collect(request()->segments())->last());

        ?>
        <title>{{@$seo['title']}}</title>
        <meta name="description" content="{{@$seo['meta_description']}}">
        <meta name="keywords" content="{{@$seo['meta_keywords']}}">

        <!-- OpenGraph -->
        <meta property="og:type"        content="website">
        <meta property="og:site_name"   content="Nomaly Travel">
        <meta property="og:title"       content="Nomaly Travel">
        <meta property="og:description" content="{{@$seo['meta_description']}}">
        <meta property="og:image"       content="{{ asset('images/nomalyopengraph.png') }}">
        <meta property="og:url"         content="{{ url()->current() }}">
        <meta name="twitter:card"       content="summary_large_image">
        <meta name="twitter:title"      content="Nomaly Travel">
        <meta name="twitter:image"      content="{{ asset('images/nomalyopengraph.png') }}">

        <!-- Fav Icon -->

    <link rel="shortcut icon" href="{{asset('favicon.ico') }}">

        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css') }}">

        <!-- Fontawesome css -->
        <link rel="stylesheet" href="{{asset('css/all.css') }}">

        <!-- Magnific-popup css -->
        <link rel="stylesheet" href="{{asset('css/magnific-popup.css') }}">

        <!-- Owl Carousel css -->
        <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Main css -->
        <link rel="stylesheet" href="{{asset('css/style.css') }}">
        
        <!-- RTL CSS for RTL languages -->
        @php
            use App\Helpers\TranslationHelper;
            $currentLanguage = TranslationHelper::getCurrentLanguage();
        @endphp
        @if($currentLanguage && $currentLanguage->is_rtl)
            <link rel="stylesheet" href="{{asset('css/rtlstyle.css') }}">
        @endif
        
        <!-- Styles -->
        <script type="text/javascript">
          var base_url = "{!!url('/')!!}"
          var images_limit = 1
        </script>
        <!-- Scripts -->
        <!-- jQuery UI (local) -->
        <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
        @stack('css')

        <style type="text/css">
            .display-block{
                display: block;
            }
            html, body { overflow-x: hidden; max-width: 100%; }
        </style>
        
    </head>
    <body class="nav-fixed">
        @include('livewire.common.navbar')
        {{ $slot }}
        @include('livewire.common.footer')
        @stack('modals')
        <script src="{{asset('js/jquery.min.js') }}"></script>
        <!-- jQuery UI (local, no CDN dependency) -->
        <script src="{{asset('js/jquery-ui.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.bundle.min.js') }}"></script> 

        <!-- Popup --> 
        <script src="{{asset('js/jquery.magnific-popup.min.js') }}"></script> 
        <script src="{{asset('js/magnific-popup-options.js') }}"></script> 

        <!-- Carousel --> 
        <script src="{{asset('js/owl.carousel.min.js') }}"></script> 


        <!-- Google Map --> 
        @if(empty($disableGmapAndCustomJs))
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMqMG_n4C0aAi3F8a82Q6s3hxDLrTXxe8&callback=initMap&loading=async" async defer></script> 
        <script src="{{asset('js/gmap.js') }}"></script> 
        @endif

        <!-- Custom --> 
        @if(empty($disableGmapAndCustomJs))
        <script src="{{asset('js/custom.js') }}"></script>
        @endif

        @stack('scripts')
        @stack('js')
    


<datalist id="nm-city-list">
<option value="New York, NY"><option value="Los Angeles, CA"><option value="Chicago, IL">
<option value="Houston, TX"><option value="Phoenix, AZ"><option value="Philadelphia, PA">
<option value="San Antonio, TX"><option value="San Diego, CA"><option value="Dallas, TX">
<option value="San Jose, CA"><option value="Austin, TX"><option value="Jacksonville, FL">
<option value="Fort Worth, TX"><option value="Columbus, OH"><option value="Charlotte, NC">
<option value="Indianapolis, IN"><option value="San Francisco, CA"><option value="Seattle, WA">
<option value="Denver, CO"><option value="Nashville, TN"><option value="Oklahoma City, OK">
<option value="El Paso, TX"><option value="Washington, DC"><option value="Las Vegas, NV">
<option value="Boston, MA"><option value="Louisville, KY"><option value="Portland, OR">
<option value="Memphis, TN"><option value="Atlanta, GA"><option value="Miami, FL">
<option value="Minneapolis, MN"><option value="New Orleans, LA"><option value="Cleveland, OH">
<option value="Baltimore, MD"><option value="Raleigh, NC"><option value="Tampa, FL">
<option value="Arlington, TX"><option value="Honolulu, HI"><option value="Anaheim, CA">
<option value="Aurora, CO"><option value="Santa Ana, CA"><option value="Corpus Christi, TX">
<option value="Riverside, CA"><option value="St. Louis, MO"><option value="Lexington, KY">
</datalist>
<datalist id="nm-artist-list">
<option value="Taylor Swift"><option value="Beyonce"><option value="Drake"><option value="Kendrick Lamar">
<option value="Bad Bunny"><option value="The Weeknd"><option value="Billie Eilish"><option value="Ariana Grande">
<option value="Post Malone"><option value="Ed Sheeran"><option value="Bruno Mars"><option value="Lady Gaga">
<option value="Eminem"><option value="Jay-Z"><option value="Rihanna"><option value="Justin Bieber">
<option value="Coldplay"><option value="Adele"><option value="Harry Styles"><option value="Dua Lipa">
<option value="Olivia Rodrigo"><option value="SZA"><option value="Tyler the Creator"><option value="Zach Bryan">
<option value="Morgan Wallen"><option value="Luke Combs"><option value="Kane Brown"><option value="Chris Stapleton">
<option value="Lizzo"><option value="Doja Cat"><option value="Cardi B"><option value="Nicki Minaj">
</datalist>
<datalist id="nm-sport-list">
<option value="NFL"><option value="NBA"><option value="MLB"><option value="NHL">
<option value="MLS Soccer"><option value="College Football"><option value="College Basketball">
<option value="UFC"><option value="Boxing"><option value="Tennis"><option value="Golf">
<option value="Cowboys"><option value="Lakers"><option value="Yankees"><option value="Patriots">
<option value="Celtics"><option value="Warriors"><option value="Dodgers"><option value="Bears">
<option value="Bulls"><option value="Cubs"><option value="Knicks"><option value="Heat">
<option value="Eagles"><option value="Chiefs"><option value="49ers"><option value="Ravens">
</datalist>
<style>
.nm-search-wrap{position:relative;width:100%}
.nm-search-input{width:100%;padding:14px 16px;font-size:16px;border:1px solid #ddd;border-radius:10px;outline:none;background:#fff;box-sizing:border-box;-webkit-appearance:none}
.nm-search-input:focus{border-color:#C9A84C;box-shadow:0 0 0 2px rgba(201,168,76,0.2)}
.nm-dropdown{position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #ddd;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,0.15);z-index:999999;max-height:280px;overflow-y:auto;display:none}
.nm-dropdown-item{padding:14px 16px;font-size:15px;cursor:pointer;border-bottom:1px solid #f0f0f0}
.nm-dropdown-item:hover{background:#C9A84C;color:#000}
.nm-dropdown-item:last-child{border-bottom:none}
.nm-no-results{padding:14px 16px;color:#999;font-size:14px}
</style>

<script>
var nmAirports=[
['ATL','Atlanta ATL (Georgia)'],
['LAX','Los Angeles LAX (California)'],
['ORD','Chicago ORD O Hare (Illinois)'],
['MDW','Chicago MDW Midway (Illinois)'],
['DFW','Dallas Fort Worth DFW (Texas)'],
['DEN','Denver DEN (Colorado)'],
['JFK','New York JFK (New York)'],
['LGA','New York LGA LaGuardia (New York)'],
['EWR','Newark EWR (New Jersey)'],
['SFO','San Francisco SFO (California)'],
['SEA','Seattle SEA (Washington)'],
['LAS','Las Vegas LAS (Nevada)'],
['MCO','Orlando MCO (Florida)'],
['PHX','Phoenix PHX (Arizona)'],
['IAH','Houston Bush IAH (Texas)'],
['HOU','Houston Hobby HOU (Texas)'],
['MIA','Miami MIA (Florida)'],
['FLL','Fort Lauderdale FLL (Florida)'],
['BOS','Boston BOS (Massachusetts)'],
['MSP','Minneapolis MSP (Minnesota)'],
['DTW','Detroit DTW (Michigan)'],
['PHL','Philadelphia PHL (Pennsylvania)'],
['CLT','Charlotte CLT (North Carolina)'],
['BWI','Baltimore BWI (Maryland)'],
['DCA','Washington Reagan DCA (DC)'],
['IAD','Washington Dulles IAD (DC)'],
['SLC','Salt Lake City SLC (Utah)'],
['TPA','Tampa TPA (Florida)'],
['SAN','San Diego SAN (California)'],
['PDX','Portland PDX (Oregon)'],
['BNA','Nashville BNA (Tennessee)'],
['AUS','Austin AUS (Texas)'],
['MSY','New Orleans MSY (Louisiana)'],
['CLE','Cleveland CLE (Ohio)'],
['PIT','Pittsburgh PIT (Pennsylvania)'],
['RDU','Raleigh Durham RDU (NC)'],
['STL','St Louis STL (Missouri)'],
['MCI','Kansas City MCI (Missouri)'],
['SAT','San Antonio SAT (Texas)'],
['RSW','Fort Myers RSW (Florida)'],
['JAX','Jacksonville JAX (Florida)'],
['SMF','Sacramento SMF (California)'],
['MKE','Milwaukee MKE (Wisconsin)'],
['BUF','Buffalo BUF (New York)'],
['IND','Indianapolis IND (Indiana)'],
['CMH','Columbus CMH (Ohio)'],
['MEM','Memphis MEM (Tennessee)'],
['CUN','Cancun CUN (Mexico)'],
['NAS','Nassau NAS (Bahamas)'],
['MBJ','Montego Bay MBJ (Jamaica)'],
['PUJ','Punta Cana PUJ (Dominican Republic)'],
['LHR','London Heathrow LHR (UK)'],
['CDG','Paris CDG (France)'],
['DXB','Dubai DXB (UAE)'],
['FCO','Rome FCO (Italy)'],
['BCN','Barcelona BCN (Spain)'],
['NRT','Tokyo NRT (Japan)'],
['SYD','Sydney SYD (Australia)'],
['YYZ','Toronto YYZ (Canada)']
];

var nmCities=[
'New York NY','Los Angeles CA','Chicago IL','Houston TX','Miami FL',
'Las Vegas NV','Dallas TX','Atlanta GA','Boston MA','Philadelphia PA',
'Denver CO','Seattle WA','Phoenix AZ','San Francisco CA','Nashville TN',
'Orlando FL','Minneapolis MN','Detroit MI','Portland OR','Charlotte NC',
'Tampa FL','Baltimore MD','Austin TX','San Diego CA','New Orleans LA',
'Cleveland OH','Kansas City MO','Indianapolis IN','Pittsburgh PA',
'Sacramento CA','Milwaukee WI','Memphis TN','Raleigh NC',
'Salt Lake City UT','Buffalo NY','Columbus OH','Jacksonville FL',
'Fort Lauderdale FL','San Antonio TX','Cancun Mexico',
'Punta Cana Dominican Republic','Montego Bay Jamaica','Nassau Bahamas',
'London UK','Paris France','Dubai UAE','Rome Italy','Barcelona Spain',
'Tokyo Japan','Toronto Canada','Bali Indonesia'
];

var nmArtists=[
'Taylor Swift','Beyonce','Drake','Bad Bunny','Kendrick Lamar',
'Morgan Wallen','Bruno Mars','The Weeknd','Billie Eilish','Post Malone',
'Zach Bryan','Chris Brown','Usher','Luke Combs','Ed Sheeran',
'Justin Timberlake','Nicki Minaj','Doja Cat','SZA','J Cole',
'Travis Scott','Lil Baby','Lil Wayne','Lil Durk','21 Savage',
'Future','Gunna','NBA YoungBoy','Rod Wave','Kanye West','Jay Z',
'Eminem','Cardi B','Burna Boy','Coldplay','Karol G','Peso Pluma',
'Shakira','Megan Thee Stallion','Tyler The Creator','Frank Ocean'
];

var nmSports=[
'NFL Football','NBA Basketball','MLB Baseball','NHL Hockey',
'MLS Soccer','College Football','College Basketball','UFC MMA',
'Boxing','Golf PGA Tour','Tennis','NASCAR','WWE Wrestling','Formula 1'
];

var nmHotels=[
'Hilton','Marriott','Hyatt','Sheraton','Westin','W Hotels',
'Four Seasons','Ritz Carlton','InterContinental','Holiday Inn',
'Hampton Inn','Best Western','Courtyard Marriott','Residence Inn',
'Embassy Suites','Doubletree Hilton','Waldorf Astoria','Sandals Resorts',
'Excellence Resorts','Iberostar','Hard Rock Hotel','MGM Grand',
'Bellagio','Caesars Palace','Wynn'
];

function nmSearch(input,data,isAirport,hiddenId){
var wrap=document.createElement('div');
wrap.className='nm-search-wrap';
var newInput=document.createElement('input');
newInput.type='text';
newInput.className='nm-search-input';
newInput.placeholder=input.placeholder||(isAirport?'Type city or airport...':'Type to search...');
newInput.autocomplete='off';

var hidden=document.createElement('input');
hidden.type='hidden';
hidden.name=input.name;
if(hiddenId) hidden.id=hiddenId;

var dropdown=document.createElement('div');
dropdown.className='nm-dropdown';

input.parentNode.insertBefore(wrap,input);
wrap.appendChild(newInput);
wrap.appendChild(hidden);
wrap.appendChild(dropdown);
input.parentNode.removeChild(input);

function show(items){
dropdown.innerHTML='';
if(items.length===0){
dropdown.style.display='none';
return;
}
items.slice(0,8).forEach(function(item){
var div=document.createElement('div');
div.className='nm-dropdown-item';
var label=isAirport?item[1]:item;
var val=isAirport?item[0]:item;
div.textContent=label;
div.addEventListener('mousedown',function(e){e.preventDefault();newInput.value=label;hidden.value=val;dropdown.style.display='none';});
div.addEventListener('touchstart',function(e){e.preventDefault();newInput.value=label;hidden.value=val;dropdown.style.display='none';});
dropdown.appendChild(div);
});
dropdown.style.display='block';
}

newInput.addEventListener('input',function(){
var q=this.value.toLowerCase().trim();
if(q.length===0){dropdown.style.display='none';return;}
var results=data.filter(function(item){
var text=isAirport?(item[0]+' '+item[1]).toLowerCase():item.toLowerCase();
return text.indexOf(q)>-1;
});
show(results);
});

newInput.addEventListener('focus',function(){
if(this.value.trim().length>0) newInput.dispatchEvent(new Event('input'));
});

document.addEventListener('click',function(e){
if(!wrap.contains(e.target)) dropdown.style.display='none';
});
}

document.addEventListener('DOMContentLoaded',function(){

// FROM airport
document.querySelectorAll(
'input[name="slices[0][from_location]"],input[name="from_location"],input#from_location,input#flight_from,input#hp_from'
).forEach(function(el){nmSearch(el,nmAirports,true,el.id+'_iata');});

// TO airport
document.querySelectorAll(
'input[name="slices[0][to_location]"],input[name="to_location"],input#to_location,input#flight_to,input#hp_to'
).forEach(function(el){nmSearch(el,nmAirports,true,el.id+'_iata');});

// CITY
document.querySelectorAll(
'input[name="city"],input#city,input#sports_city,input#concerts_city,input#hp_sports_city,input#hp_concert_city'
).forEach(function(el){nmSearch(el,nmCities,false);});

// DESTINATION / HOTEL
document.querySelectorAll(
'input[name="destination"],input#destination,input#hotel_dest,input#hp_hotel_dest'
).forEach(function(el){nmSearch(el,nmHotels.concat(nmCities),false);});

// ARTIST
document.querySelectorAll(
'input[name="keyword"],input#artist,input#keyword,input#hp_artist'
).forEach(function(el){nmSearch(el,nmArtists,false);});

// Fallback: catch remaining text inputs by placeholder/name
document.querySelectorAll('input[type="text"]').forEach(function(el){
if(el.classList.contains('nm-search-input')) return;
var combined=(el.placeholder+' '+el.name).toLowerCase();
if(combined.match(/from|origin/)) nmSearch(el,nmAirports,true);
else if(combined.match(/\bto\b|arrival/)) nmSearch(el,nmAirports,true);
else if(combined.match(/artist|event|venue|concert/)) nmSearch(el,nmArtists,false);
else if(combined.match(/hotel|resort/)) nmSearch(el,nmHotels.concat(nmCities),false);
else if(combined.match(/city|destination|location/)) nmSearch(el,nmCities,false);
});

});
</script>

</body>
</html>

<style>
/* Desktop nav */
.navbar-nav .nav-link { white-space: nowrap; display: flex; align-items: center; gap: 3px; padding-left: 8px !important; padding-right: 8px !important; font-size: 13.5px; }
.navbar-nav .nav-link i { display: inline !important; font-size: 0.85em; }
.navbar-nav .nav-item.ps-2 { padding-left: 0 !important; }
.header-wrap .btn { font-size: 13px; padding: 6px 12px; }
#nm-mobile-topbar { display: none; }
/* Dropdown toggle — hide Bootstrap caret, use our own chevron */
.navbar-nav .dropdown-toggle::after { display: none !important; }
.nm-caret { font-size: 10px; margin-left: 3px; opacity: .6; transition: transform .2s; }
.nav-item.dropdown.show .nm-caret { transform: rotate(180deg); }
/* Dropdown menus */
.navbar-nav .dropdown-menu {
  border: 1px solid #ebebeb;
  box-shadow: 0 8px 28px rgba(0,0,0,.10);
  border-radius: 10px;
  padding: 6px 0;
  min-width: 190px;
  margin-top: 4px;
  animation: none !important;
}
.navbar-nav .dropdown-item {
  font-size: 13.5px; padding: 9px 18px;
  color: #222; font-family: 'DM Sans', sans-serif;
  display: flex; align-items: center; gap: 10px;
}
.navbar-nav .dropdown-item i { color: #c9a84c; font-size: 13px; width: 16px; flex-shrink: 0; }
.navbar-nav .dropdown-item:hover { background: #f5f5f5; color: #0a1628; }
/* Kill any underline/border animation on dropdown toggles */
.navbar-nav .nav-link.dropdown-toggle { border-bottom: none !important; }
/* Mobile dropdown expand */
@media (max-width: 991px) {
  #navbarSupportedContent .dropdown-menu {
    position: static !important; box-shadow: none; border: none;
    background: #f7f8fc; border-radius: 0; padding: 0; margin: 0;
  }
  #navbarSupportedContent .dropdown-item {
    padding: 11px 36px; font-size: 14px; border-bottom: 1px solid #eee; color: #111;
  }
  #navbarSupportedContent .dropdown-toggle { justify-content: space-between; }
  #navbarSupportedContent .dropdown-menu { display: none; }
  #navbarSupportedContent .dropdown-menu.nm-open { display: block !important; }
}

/* Mobile nav */
@media (max-width: 991px) {
  #navbarSupportedContent {
    position: fixed; top: 0; left: 0; width: 80%; max-width: 300px; height: 100vh;
    background: #fff; box-shadow: 4px 0 24px rgba(0,0,0,0.15);
    z-index: 9999; padding: 64px 0 32px; overflow-y: auto;
    transform: translateX(-100%); transition: transform 0.3s ease;
  }
  #navbarSupportedContent.show { transform: translateX(0); }
  #navbarSupportedContent .navbar-nav { flex-direction: column !important; padding: 8px 0; }
  #navbarSupportedContent .nav-item { border-bottom: 1px solid #f2f2f2; }
  #navbarSupportedContent .nav-link { font-size: 15px !important; padding: 14px 24px !important; color: #111 !important; gap: 10px !important; }
  #navbarSupportedContent .nav-link i { font-size: 1em !important; color: #c9a84c; }
  #navbarSupportedContent .nav-link:hover { background: #fafafa; color: #c9a84c !important; }
  #navbarSupportedContent .close-toggler { display: none; }
  #navbarSupportedContent .btn { display: block; margin: 8px 16px 0; width: calc(100% - 32px); text-align: center; }
  .nav-item:has(.language-switcher) { display: none; }
  #nm-mobile-topbar {
    display: flex; align-items: center; gap: 12px;
    position: absolute; top: 14px; right: 14px; z-index: 10002;
  }
  #nm-mobile-topbar .lang-flag-btn { margin: 0 !important; width: 34px !important; height: 34px !important; }
  #nm-mobile-topbar .lang-flag-btn::after { display: none !important; }
  #nm-mobile-close {
    width: 34px; height: 34px; border-radius: 50%;
    background: #f2f2f2; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; color: #444;
  }
  #nm-mobile-close:hover { background: #ddd; }
}

/* Logo sizing */
.logo img { max-width: 160px; height: auto; display: block; }
@media (max-width: 991px) {
  .logo img { max-width: 110px; }
  /* Slim the banner */
  .header-wrap { padding: 6px 0 !important; position: relative; }
  .header-wrap > .container { padding-left: 0; padding-right: 0; }
  .header-wrap .col-lg-2 { padding-left: 4px; }
  .logo { display: flex; align-items: center; }
  /* Language switcher + hamburger grouped on the right */
  .nm-mobile-right {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .navbar-toggler {
    position: static !important;
    transform: none !important;
    margin: 0 !important;
  }
}
/* Slim desktop banner too */
.header-wrap { padding: 8px 30px !important; position: relative; z-index: 1050; }
.header-wrap .row { align-items: center; }
/* Remove the extra top margin pushing nav down */
.header-wrap .navbar { margin-top: 0 !important; width: 100%; }
.header-wrap .col-lg-10 { display: flex; align-items: center; }
/* nm-nav-panel: desktop flex (replaces Bootstrap navbar-collapse) */
@media (min-width: 992px) {
  .nm-nav-panel {
    display: flex !important;
    flex-basis: auto;
    flex-grow: 1;
    align-items: center;
    justify-content: flex-end;
    background: transparent !important;
    position: static !important;
    transform: none !important;
    box-shadow: none !important;
    width: auto !important;
    height: auto !important;
    padding: 0 !important;
    overflow: visible !important;
  }
}
#navbarSupportedContent { z-index: 1049; background: #fff; }
</style>
<div class="header-wrap">
  <div class="container">
     <div class="row">
        <div class="col-lg-2 navbar-light">
           <div class="logo"><a href="{{url('/')}}"><img src="{{asset('images/nomaly-logo.png')}}" alt="Nomaly Travel"></a></div>
           <div class="nm-mobile-right d-lg-none">
             @include('components.language-switcher')
             <button class="navbar-toggler" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" onclick="document.getElementById('navbarSupportedContent').classList.toggle('show')"> <i class="fas fa-bars"></i> </button>
           </div>
        </div>

        <div class="col-lg-10">
        <nav class="navbar navbar-expand-lg navbar-light">
           <div class="nm-nav-panel" id="navbarSupportedContent">
              <div id="nm-mobile-topbar">
                <button id="nm-mobile-close" aria-label="Close menu" onclick="document.getElementById('navbarSupportedContent').classList.remove('show')"><i class="fas fa-times"></i></button>
              </div>
              <button class="close-toggler" type="button" data-toggle="offcanvas"> <span><i class="fas fa-times-circle" aria-hidden="true"></i></span> </button>

              <ul class="navbar-nav mb-2 mb-lg-0">

              <li class="nav-item ps-2 d-lg-none"><a href="{{url('/')}}" class="nav-link">{{ __('frontend.home') }}</a></li>

              {{-- Travel --}}
              <li class="nav-item dropdown ps-2">
                <a href="#" class="nav-link dropdown-toggle" id="nmTravelDd" role="button" data-nm-dd="nmTravelDd" aria-expanded="false">
                  Travel <i class="fas fa-chevron-down nm-caret"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="nmTravelDd">
                  <li><a class="dropdown-item" href="{{ url('/') }}#flights"><i class="fas fa-plane"></i> Flights</a></li>
                  <li><a class="dropdown-item" href="{{ url('/') }}#hotels"><i class="fas fa-hotel"></i> Hotels</a></li>
                  {{-- <li><a class="dropdown-item" href="{{ url('/tours') }}"><i class="fas fa-map-marked-alt"></i> Tours</a></li> --}}
                </ul>
              </li>

              {{-- Entertainment --}}
              <li class="nav-item dropdown ps-2">
                <a href="#" class="nav-link dropdown-toggle" id="nmEntDd" role="button" data-nm-dd="nmEntDd" aria-expanded="false">
                  Entertainment <i class="fas fa-chevron-down nm-caret"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="nmEntDd">
                  <li><a class="dropdown-item" href="{{ url('/sports') }}"><i class="fas fa-football-ball"></i> Sports</a></li>
                  <li><a class="dropdown-item" href="{{ url('/concerts') }}"><i class="fas fa-music"></i> Concerts</a></li>
                </ul>
              </li>

              {{-- Services & Blog --}}
              <li class="nav-item ps-2"><a href="{{ url('/services') }}" class="nav-link">Services</a></li>
              <li class="nav-item ps-2"><a href="{{ url('/blog') }}" class="nav-link">Blog</a></li>

              {{-- About Us --}}
              <li class="nav-item dropdown ps-2">
                <a href="#" class="nav-link dropdown-toggle" id="nmAboutDd" role="button" data-nm-dd="nmAboutDd" aria-expanded="false">
                  About Us <i class="fas fa-chevron-down nm-caret"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="nmAboutDd">
                  <li><a class="dropdown-item" href="{{ url('/about-us') }}">About Us</a></li>
                  <li><a class="dropdown-item" href="{{ url('/contact-us') }}">Contact Us</a></li>
                </ul>
              </li>

                


                 
                 @if(auth()->user())
                 {{-- Desktop: avatar + dropdown --}}
                 <li class="nav-item dropdown d-none d-lg-flex align-items-center" style="margin-left:12px; margin-right:8px;">
                   <a href="#" class="dropdown-toggle" id="userdata" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                       <img class="img-fluid" src="{{ Auth::user()->profile_photo_url }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" />
                     @else
                       <img class="img-fluid" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name[0]) }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;" />
                     @endif
                   </a>
                   <ul class="dropdown-menu dropdown-menu-end animate slideIn" aria-labelledby="userdata">
                     <li class="nav-item"><a href="{{url('/dashboard')}}" class="nav-link"><i class="fas fa-tachometer-alt"></i> {{ __('frontend.dashboard') }}</a></li>
                     <li class="nav-item"><a href="{{ route('profile.show') }}" class="nav-link"><i class="fas fa-edit"></i> {{ __('frontend.my_profile') }}</a></li>
                     <li class="nav-item"><a href="{{ route('hotel-booking') }}" class="nav-link"><i class="fas fa-hotel"></i> {{ __('frontend.my_hotel_bookings') }}</a></li>
                     <li class="nav-item"><a href="{{ route('flight-booking') }}" class="nav-link"><i class="fas fa-plane"></i> {{ __('frontend.my_flight_bookings') }}</a></li>
                     <li class="nav-item"><a href="{{ url('change-password') }}" class="nav-link"><i class="fas fa-key"></i> {{ __('frontend.change_password') }}</a></li>
                     <li class="nav-item"><a href="{{route('payment-history')}}" class="nav-link"><i class="fas fa-credit-card"></i> {{ __('frontend.payment_history') }}</a></li>
                     <li class="nav-item"><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="fas fa-sign-out-alt"></i> {{ __('frontend.logout') }}</a></li>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
                   </ul>
                 </li>

                 {{-- Mobile: full-width account menu rows --}}
                 <li class="nav-item d-lg-none">
                   <a href="{{url('/dashboard')}}" class="nav-link"><i class="fas fa-tachometer-alt"></i> {{ __('frontend.dashboard') }}</a>
                 </li>
                 <li class="nav-item d-lg-none">
                   <a href="{{ route('profile.show') }}" class="nav-link"><i class="fas fa-edit"></i> {{ __('frontend.my_profile') }}</a>
                 </li>
                 <li class="nav-item d-lg-none">
                   <a href="{{ route('hotel-booking') }}" class="nav-link"><i class="fas fa-hotel"></i> {{ __('frontend.my_hotel_bookings') }}</a>
                 </li>
                 <li class="nav-item d-lg-none">
                   <a href="{{ route('flight-booking') }}" class="nav-link"><i class="fas fa-plane"></i> {{ __('frontend.my_flight_bookings') }}</a>
                 </li>
                 <li class="nav-item d-lg-none">
                   <a href="{{ url('change-password') }}" class="nav-link"><i class="fas fa-key"></i> {{ __('frontend.change_password') }}</a>
                 </li>
                 <li class="nav-item d-lg-none">
                   <a href="{{route('payment-history')}}" class="nav-link"><i class="fas fa-credit-card"></i> {{ __('frontend.payment_history') }}</a>
                 </li>
                 <li class="nav-item d-lg-none">
                   <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> {{ __('frontend.logout') }}</a>
                 </li>
                 @endif
                 
                 <li class="nav-item ps-2 d-lg-flex d-none">
                    @include('components.language-switcher')
                 </li>
              </ul>
              @if(!auth()->user())
              <a class="btn btn-sec ms-3" href="{{url('/login')}}"><i class="fas fa-sign-in-alt"></i> {{ __('frontend.login') }}</a>
              <a class="btn btn-primary ms-3" href="{{url('/register')}}" ><i class="fas fa-user"></i> {{ __('frontend.register') }}</a>
              @endif

              

           </div>
        </nav>
        </div>
     </div>
  </div>
</div>

<script>
(function(){
  function initDropdowns() {
    document.querySelectorAll('[data-nm-dd]').forEach(function(toggle){
      var menu = toggle.parentElement.querySelector('.dropdown-menu');
      if (!menu) return;

      // Desktop: show on click, close on outside click
      toggle.addEventListener('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var isOpen = menu.classList.contains('show');
        closeAll();
        if (!isOpen) {
          menu.classList.add('show');
          menu.classList.add('nm-open');
          toggle.querySelector('.nm-caret') && (toggle.querySelector('.nm-caret').style.transform = 'rotate(180deg)');
        }
      });
    });

    // Close all on outside click
    document.addEventListener('click', function(){ closeAll(); });

    // Prevent clicks inside the mobile nav panel from bubbling to document
    // so no external handler can close the panel when user taps items inside it
    var navPanel = document.getElementById('navbarSupportedContent');
    if (navPanel) {
      navPanel.addEventListener('click', function(e){ e.stopPropagation(); });

      // Close mobile nav when any real link (not a dropdown toggle) is clicked
      navPanel.querySelectorAll('a:not([data-nm-dd])').forEach(function(link) {
        link.addEventListener('click', function() {
          navPanel.classList.remove('show');
        });
      });
    }
  }

  function closeAll() {
    document.querySelectorAll('[data-nm-dd]').forEach(function(t){
      var m = t.parentElement.querySelector('.dropdown-menu');
      if (m) { m.classList.remove('show'); m.classList.remove('nm-open'); }
      var c = t.querySelector('.nm-caret');
      if (c) c.style.transform = '';
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDropdowns);
  } else {
    initDropdowns();
  }
})();
</script>

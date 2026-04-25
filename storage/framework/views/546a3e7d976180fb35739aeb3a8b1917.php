<div class="header-wrap">
  <div class="container">
     <div class="row">
        <div class="col-lg-2 navbar-light">
           <div class="logo"><a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('images/'.widget(1)->extra_image_1)); ?>" alt="<?php echo e(widget(1)->extra_field_1); ?>"></a></div>
           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <i class="fas fa-bars"></i> </button>
        </div>

        <div class="col-lg-10">                  
        <nav class="navbar navbar-expand-lg navbar-light mt-2">
           <div class="collapse navbar-collapse ms-auto" id="navbarSupportedContent">
              <button class="close-toggler" type="button" data-toggle="offcanvas"> <span><i class="fas fa-times-circle" aria-hidden="true"></i></span> </button>
                               
              <ul class="navbar-nav  mb-2 mb-lg-0 ms-auto">

              <li class="nav-item ps-2"><a href="<?php echo e(url('/')); ?>" class="nav-link"><?php echo e(__('frontend.home')); ?></a></li>
                <li class="nav-item ps-2"><a href="<?php echo e(url('/sports')); ?>" class="nav-link"><i class="fas fa-football-ball me-1" style="color:#c9a84c"></i> Sports</a></li>
                <li class="nav-item ps-2"><a href="<?php echo e(url('/concerts')); ?>" class="nav-link"><i class="fas fa-music me-1" style="color:#c9a84c"></i> Concerts</a></li>

                 <?php echo get_menus(1); ?>


                


                 
                 <?php if(auth()->user()): ?>
                 <li class="nav-item dropdown ps-0 pe-0"> <a href="#" class=" dropdown-toggle" id="userdata" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if(Laravel\Jetstream\Jetstream::managesProfilePhotos()): ?>

                        <img class="img-fluid" src="<?php echo e(Auth::user()->profile_photo_url); ?>" />

                        <?php else: ?>
                        <img class="img-fluid" src="https://ui-avatars.com/api/?name=<?php echo e(Auth::user()->name[0]); ?>" />
                        

                        <?php endif; ?></a>
                    <ul class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="userdata">
                                              <li class="nav-item"><a href="<?php echo e(url('/dashboard')); ?>" class="nav-link"><i class="fas fa-tachometer-alt"></i> <?php echo e(__('frontend.dashboard')); ?> </a></li>
                       <li class="nav-item"><a href="<?php echo e(route('profile.show')); ?>" class="nav-link"><i class="fas fa-edit"></i> <?php echo e(__('frontend.my_profile')); ?></a></li>
                       <li class="nav-item"><a href="<?php echo e(route('hotel-booking')); ?>" class="nav-link"><i class="fas fa-hotel"></i> <?php echo e(__('frontend.my_hotel_bookings')); ?></a></li>
                       <li class="nav-item"><a href="<?php echo e(route('flight-booking')); ?>" class="nav-link"><i class="fas fa-plane"></i> <?php echo e(__('frontend.my_flight_bookings')); ?></a></li>
                       <li class="nav-item"><a href="<?php echo e(url('change-password')); ?>" class="nav-link"><i class="fas fa-key"></i> <?php echo e(__('frontend.change_password')); ?></a></li>
                       <li class="nav-item"><a href="<?php echo e(route('payment-history')); ?>" class="nav-link"><i class="fas fa-credit-card"></i> <?php echo e(__('frontend.payment_history')); ?></a></li>
                       <li class="nav-item"><a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link"><i class="fas fa-sign-out-alt"></i> <?php echo e(__('frontend.logout')); ?></a></li>
                       <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
    
                      </ul>

                  </li>
                 <?php endif; ?>  
                 
                 <li class="nav-item ps-2">
                    <?php echo $__env->make('components.language-switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                 </li>    
              </ul>
              <?php if(!auth()->user()): ?>
              <a class="btn btn-sec ms-3" href="<?php echo e(url('/login')); ?>"><i class="fas fa-sign-in-alt"></i> <?php echo e(__('frontend.login')); ?></a>
              <a class="btn btn-primary ms-3" href="<?php echo e(url('/register')); ?>" ><i class="fas fa-user"></i> <?php echo e(__('frontend.register')); ?></a>
              <?php endif; ?>

              

           </div>                                  
        </nav>
        </div>
     </div>
  </div>
</div>
<?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/livewire/common/navbar.blade.php ENDPATH**/ ?>
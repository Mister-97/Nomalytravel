<footer>
  <div class="container"> 
    <div class="footerlogo"><img src="<?php echo e(asset('images/'.widget(1)->extra_image_2)); ?>"></div>
    <!-- social Section -->
    <?php $links = widget(30); ?>
    <div class="socialLinks" >
      <a href="<?php echo e($links->extra_field_1); ?>"><i class="fab fa-facebook-f"></i></a>
      <a href="<?php echo e($links->extra_field_2); ?>"><i class="fab fa-twitter"></i></a>
      <a href="<?php echo e($links->extra_field_3); ?>"><i class="fab fa-linkedin-in"></i></a>
      <a href="<?php echo e($links->extra_field_4); ?>"><i class="fab fa-instagram"></i></a>
      <a href="<?php echo e($links->extra_field_5); ?>"><i class="fab fa-youtube"></i></a>
    </div>

    <ul class="quicklinks">
      <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('frontend.home')); ?></a></li>
      <li><a href="<?php echo e(url('/flights')); ?>"><?php echo e(__('frontend.menu.flights')); ?></a></li>
      <li><a href="<?php echo e(url('/hotels')); ?>"><?php echo e(__('frontend.menu.hotels')); ?></a></li>
      <li><a href="<?php echo e(url('/tours')); ?>"><?php echo e(__('frontend.menu.tours')); ?></a></li>
      <li><a href="<?php echo e(url('/about-us')); ?>"><?php echo e(__('frontend.menu.about-us')); ?></a></li>
      <li><a href="<?php echo e(url('/services')); ?>"><?php echo e(__('frontend.menu.services')); ?></a></li>
      <li><a href="<?php echo e(url('/blog')); ?>"><?php echo e(__('frontend.menu.blog')); ?></a></li>
      <li><a href="<?php echo e(url('/contact-us')); ?>"><?php echo e(__('frontend.menu.contact-us')); ?></a></li>
    </ul>



    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="footer-copyright">
          <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(widget(1)->extra_field_1); ?>  | <?php echo e(__('frontend.all_rights_reserved')); ?></p>
        </div>
      </div>
    </div>
  </div>
</footer>

<?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/livewire/common/footer.blade.php ENDPATH**/ ?>
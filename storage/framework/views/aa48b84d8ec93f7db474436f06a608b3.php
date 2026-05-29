<style>
.nm-footer {
  background: #070D1A;
  border-top: 1px solid rgba(201,168,76,.2);
  padding: 72px 0 0;
  font-family: 'DM Sans', sans-serif;
}
.nm-footer-logo img {
  max-width: 180px; height: auto; margin-bottom: 14px;
}
.nm-footer-tagline {
  font-size: 13px; color: rgba(255,255,255,.38);
  line-height: 1.7; max-width: 240px; margin-bottom: 22px;
}
.nm-footer-social {
  display: flex; gap: 10px; flex-wrap: wrap;
}
.nm-footer-social a {
  width: 36px; height: 36px; border-radius: 50%;
  border: 1px solid rgba(201,168,76,.3);
  display: flex; align-items: center; justify-content: center;
  color: rgba(255,255,255,.45); font-size: 13px;
  transition: all .2s; text-decoration: none;
}
.nm-footer-social a:hover {
  background: rgba(201,168,76,.15);
  border-color: rgba(201,168,76,.7);
  color: #C9A84C;
}
.nm-footer-heading {
  font-size: 9px; font-weight: 700; letter-spacing: 3px;
  text-transform: uppercase; color: #C9A84C;
  margin-bottom: 18px;
  padding-bottom: 10px;
  border-bottom: 1px solid rgba(201,168,76,.15);
  text-align: left;
}
.nm-footer-links { list-style: none; padding: 0; margin: 0; }
.nm-footer-links li { margin-bottom: 9px; }
.nm-footer-links a {
  font-size: 13px; color: rgba(255,255,255,.45);
  text-decoration: none; transition: color .2s;
  display: flex; align-items: center; gap: 7px;
}
.nm-footer-links a:hover { color: #C9A84C; }
.nm-footer-links a i { font-size: 10px; color: rgba(201,168,76,.4); width: 10px; }
.nm-footer-divider {
  border: none;
  border-top: 1px solid rgba(255,255,255,.06);
  margin: 52px 0 0;
}
.nm-footer-bottom {
  padding: 18px 0;
  display: flex; align-items: center;
  justify-content: space-between; flex-wrap: wrap; gap: 8px;
}
.nm-footer-copy { font-size: 12px; color: rgba(255,255,255,.28); }
.nm-footer-copy span { color: rgba(201,168,76,.55); }
.nm-footer-badge {
  font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
  color: rgba(255,255,255,.18); font-weight: 600;
}
/* Desktop brand col: left-aligned */
.nm-footer-brand-col { text-align: left; }
.nm-footer-logo { text-align: left; }

@media (max-width: 767px) {
  .nm-footer { padding: 48px 0 0; }
  .nm-footer-tagline { max-width: 100%; }
  .nm-footer-social { justify-content: center; }
  .nm-footer-logo { text-align: center; }
  .nm-footer-logo img { max-width: 160px; }
  .nm-footer-bottom { justify-content: center; text-align: center; }
  .nm-footer-brand-col { text-align: center; margin-bottom: 36px; }
}
</style>

<footer class="nm-footer">
  <div class="container">
    <div class="row g-4">

      
      <div class="col-lg-4 col-md-12 nm-footer-brand-col">
        <div class="nm-footer-logo">
          <a href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(asset('images/nomaly-logo-footer.png')); ?>" alt="Nomaly Travel">
          </a>
        </div>
        <p class="nm-footer-tagline">Your journey starts here. Flights, hotels, sports and concerts curated for the modern traveler.</p>
        <?php $links = widget(30); ?>
        <div class="nm-footer-social">
          <a href="<?php echo e($links->extra_field_1); ?>" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="<?php echo e($links->extra_field_2); ?>" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="<?php echo e($links->extra_field_3); ?>" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="<?php echo e($links->extra_field_4); ?>" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="<?php echo e($links->extra_field_5); ?>" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      
      <div class="col-lg-2 col-6">
        <div class="nm-footer-heading">Explore</div>
        <ul class="nm-footer-links">
          <li><a href="<?php echo e(url('/')); ?>"><i class="fas fa-chevron-right"></i> Home</a></li>
          <li><a href="<?php echo e(url('/')); ?>#flights"><i class="fas fa-plane"></i> Flights</a></li>
          <li><a href="<?php echo e(url('/')); ?>#hotels"><i class="fas fa-hotel"></i> Hotels</a></li>
          <li><a href="<?php echo e(url('/sports')); ?>"><i class="fas fa-football-ball"></i> Sports</a></li>
          <li><a href="<?php echo e(url('/concerts')); ?>"><i class="fas fa-music"></i> Concerts</a></li>
        </ul>
      </div>

      
      <div class="col-lg-2 col-6">
        <div class="nm-footer-heading">Company</div>
        <ul class="nm-footer-links">
          <li><a href="<?php echo e(url('/about-us')); ?>"><i class="fas fa-chevron-right"></i> About Us</a></li>
          <li><a href="<?php echo e(url('/services')); ?>"><i class="fas fa-chevron-right"></i> Services</a></li>
          <li><a href="<?php echo e(url('/blog')); ?>"><i class="fas fa-chevron-right"></i> Blog</a></li>
          <li><a href="<?php echo e(url('/contact-us')); ?>"><i class="fas fa-chevron-right"></i> Contact</a></li>
          <li><a href="<?php echo e(route('terms.show')); ?>"><i class="fas fa-file-contract"></i> Terms</a></li>
          <li><a href="<?php echo e(route('policy.show')); ?>"><i class="fas fa-shield-alt"></i> Privacy Policy</a></li>
        </ul>
      </div>

      
      <div class="col-lg-4 col-md-12">
        <div class="nm-footer-heading">Get In Touch</div>
        <ul class="nm-footer-links">
          <li><a href="mailto:nomalytravel@gmail.com"><i class="fas fa-envelope"></i> nomalytravel@gmail.com</a></li>
          <li><a href="tel:+1"><i class="fas fa-phone"></i> Available 24/7</a></li>
          <li><a href="<?php echo e(url('/contact-us')); ?>"><i class="fas fa-headset"></i> Live Support</a></li>
        </ul>
      </div>

    </div>

    <hr class="nm-footer-divider">

    <div class="nm-footer-bottom">
      <p class="nm-footer-copy">&copy; <?php echo e(date('Y')); ?> <span>Nomaly Travel</span> &mdash; <?php echo e(__('frontend.all_rights_reserved')); ?></p>
      <span class="nm-footer-badge">Premium Travel Experience</span>
    </div>
  </div>
</footer>
<?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/livewire/common/footer.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

<?php $__env->startSection('content'); ?>
<!-- Inner Heading Start -->


<div class="pageheader"">            
            <div class="container">            
                <h1><?php echo e($cms->getTranslatedTitle()); ?></h1>
            </div>
      </div>



<section class="innerPages">
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-12">
        <div class="cmspagecontent">           
      		<?php echo $cms->getTranslatedDescription(); ?>

        </div>
      </div>
      <aside class="col-lg-5">
		    <?php if($cms->image!='' && null!==($cms->image)): ?>
          <div class="about_img"><img src="<?php echo e(asset('images/'.$cms->image)); ?>" class="d-block w-100" /></div>
          <?php endif; ?>
		  
		    <div class="callWrp">
          <div class="getquoteBx">
            <div class="icon">
              <i class="fas fa-phone-alt"></i>
            </div>
            <p><?php echo e(__('Contact us for more information or to start a project with us')); ?>.</p>
            <a href="<?php echo e(url('contact-us')); ?>" class="btn btn-white mt-4"><?php echo e(__('Contact Us')); ?></a>
          </div>
        </div>		  
		  
      </aside>






    </div>
  </div>
</section>


 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>


<?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/pages/cms.blade.php ENDPATH**/ ?>
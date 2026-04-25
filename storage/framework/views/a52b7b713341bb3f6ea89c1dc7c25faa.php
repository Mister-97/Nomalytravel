<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    
<!-- Page title start -->
<div class="pageheader">            
    <div class="container">
        <h1><?php echo e(__('Post Overview')); ?></h1>
    </div>
</div>
<!-- Page title end -->




<section class="innerPages">
<div class="container">


<div class="row">
               <!-- Sidebar -->
               <div class="col-lg-3">
                  <div class="blogsidebar sticky-top">
                     <div class="widget">
                     <form action="<?php echo e(url('/blog')); ?>" method="GET" class="sidebar-search-form">
    <input type="search" name="keyword" placeholder="Search.." value="<?php echo e(request('keyword')); ?>">
    <button type="submit"><i class="fas fa-search"></i></button>
</form>


                     </div>


                     <div class="widget">
                         <div class="widget_title">Categories</div>
                         <?php if(null !== ($categories = module(24))): ?>
                            <ul class="wdgtnav">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a href="<?php echo e(url('/blog?category=' . $category->id)); ?>">
                                            <?php echo e($category->title); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>
                     </div>                     
                 </div>
               </div>
               <!-- Posts -->
               <div class="col-lg-9">
                <div class="postimage"><img src="<?php echo e(asset('images/'.$blog->image)); ?>" alt="<?php echo e($blog->getTranslatedTitle()); ?>"></div>
                <div class="blogdetail">
                    <h2 class="post-title"><?php echo e($blog->getTranslatedTitle()); ?></h2>    
                    <div class="date"><i class="fas fa-calendar-alt"></i> <?php echo e(date('d M Y',strtotime($blog->created_at))); ?></div>               

                    <div class="postcontent">
                    <?php echo $blog->getTranslatedDescription(); ?>

                    </div>
                  </div>
               </div>
            </div>

    




</div>    
</section>




 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/blogs/detail.blade.php ENDPATH**/ ?>
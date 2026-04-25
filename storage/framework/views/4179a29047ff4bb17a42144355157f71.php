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
        <h1><?php echo e(__('Latest From Blog')); ?></h1>
    </div>
</div>
<!-- Page title end -->

    <div class="hmblog parallax-section">
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
               <div class="row">



               <?php if($blogs->isEmpty()): ?>
    <h2 class="text-center">No records found for 
        <?php if(request('keyword')): ?>
            "<?php echo e(request('keyword')); ?>"
        <?php elseif(request('category')): ?>
            "Category: <?php echo e(request('category')); ?>"
        <?php endif; ?>
    </h2>
<?php else: ?>
    <h4 class="mb-3"><?php echo e($blogs->total()); ?> records found for 
        <?php if(request('keyword')): ?>
            "<?php echo e(request('keyword')); ?>"
        <?php elseif(request('category')): ?>
            "Category: <?php echo e(request('category')); ?>"
        <?php endif; ?>
    </h4>

    <div class="row">
        <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-6">
                <div class="subposts">
                    <div class="postimg">
                        <img src="<?php echo e(asset('images/' . $blog->image)); ?>">
                    </div>
                    <div class="postinfo">
                        <h3><a href="<?php echo e(route('blogs.detail', $blog->slug)); ?>" class="pageLnks"><?php echo e($blog->getTranslatedTitle()); ?></a></h3>
                    </div>
                    <div class="date"><?php echo e(date('d M Y', strtotime($blog->created_at))); ?></div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination Links -->
    <div class="pagination-wrapper">
    <?php echo e($blogs->links('pagination::bootstrap-4')); ?>

    </div>
<?php endif; ?>





            
         </div>                
             
               </div>
            </div>




       
         
      </div>
   </div>



 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/blogs/index.blade.php ENDPATH**/ ?>
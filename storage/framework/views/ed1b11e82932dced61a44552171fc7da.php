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
        <h1>Register</h1>
    </div>
</div>
<!-- Page title end -->


<!-- Page content start -->
<div class="innerpagewrap">
    <div class="container register-form">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10">


        <div class="account-main">
            <div class="account-title">
                <h3>Register Your Account</h3>
            </div>
            <?php if (isset($component)) { $__componentOriginal71c6471fa76ce19017edc287b6f4508c = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.validation-errors','data' => ['class' => 'mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('validation-errors'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal71c6471fa76ce19017edc287b6f4508c)): ?>
<?php $component = $__componentOriginal71c6471fa76ce19017edc287b6f4508c; ?>
<?php unset($__componentOriginal71c6471fa76ce19017edc287b6f4508c); ?>
<?php endif; ?>

            <?php if(session('status')): ?>
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('register')); ?>" class="needs-validation" novalidate>
            <?php echo csrf_field(); ?>

                <div class="form-outline mb-4 mt-4">
                     <div class="account-form-label"><label>Your Name</label></div>
                        <input type="text" name="name" class="form-control <?php if($errors->has('name')): ?> is-invalid <?php endif; ?>" placeholder="Enter Your Name" value="<?php echo e(old('name')); ?>" required>
                        <div class="invalid-feedback"><?php echo e($errors->first('name') ?? 'Please enter your name.'); ?></div>
                     </div>


                <div class="form-outline mb-4 mt-4">
                     <div class="account-form-label"><label>Your Email</label></div>
                        <input type="email" name="email" class="form-control <?php if($errors->has('email')): ?> is-invalid <?php endif; ?>" placeholder="Enter Your Email" value="<?php echo e(old('email')); ?>" required>
                        <div class="invalid-feedback"><?php echo e($errors->first('email') ?? 'Please enter a valid email.'); ?></div>
                     </div>

               
                <div class="form-outline mb-3">
                    <div class="account-form-label"><label>Your Password</label> </div>
                    <input type="password" name="password" class="form-control <?php if($errors->has('password')): ?> is-invalid <?php endif; ?>" placeholder="Password" required>
                    <div class="invalid-feedback"><?php echo e($errors->first('password') ?? 'Please enter a strong password.'); ?></div>
                </div>

                <div class="form-outline mb-3">
                    <div class="account-form-label"><label>Confirm Password</label> </div>
                    <input type="password" name="password_confirmation" class="form-control <?php if($errors->has('password_confirmation')): ?> is-invalid <?php endif; ?>" placeholder="Confirm Password" required>
                    <div class="invalid-feedback"><?php echo e($errors->first('password_confirmation') ?? 'Please confirm your password.'); ?></div>
                </div>
                <!-- Submit button -->
                <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-block w-100">Register</button>
                </div>

                <div class="account-bottom-text mt-5">
                    <p>You have an account?  <a href="<?php echo e(url('/login')); ?>">Login</a></p>
                </div>

            </form>
        </div>

        </div>
        </div>
    </div>
    </div>
<!--  end -->



 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/u394640813/domains/nomalytravel.com/public_html/resources/views/auth/register.blade.php ENDPATH**/ ?>
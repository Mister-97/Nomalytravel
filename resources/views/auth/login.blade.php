<x-app-layout>
<!-- Page title start -->
<div class="pageheader">            
    <div class="container">
        <h1>Login</h1>
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
                <h3>Sign in to Your Account</h3>
            </div>
            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
            @csrf

                <div class="form-outline mb-4 mt-4">
                     <div class="account-form-label"><label>Your Email</label></div>
                        <input type="email" name="email" class="form-control @if($errors->has('email')) is-invalid @endif" placeholder="Enter Your Email" value="{{ old('email') }}" required>
                        <div class="invalid-feedback">{{ $errors->first('email') ?? 'Please enter a valid email address.' }}</div>
                     </div>

               
                <div class="form-outline mb-3">
                    <div class="account-form-label"><label>Your Password</label> </div>
                    <input type="password" name="password" class="form-control @if($errors->has('password')) is-invalid @endif" placeholder="Password" required>
                    <div class="invalid-feedback">{{ $errors->first('password') ?? 'Please enter your password.' }}</div>
                </div>

                <!-- Remember me -->
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" value="" id="form2Example31" checked="">
                    <label class="form-check-label" for=""> Remember me </label>
                </div>

                <!-- Submit button -->
                <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-block w-100">Login</button>
                </div>

                <div class="account-bottom-text mt-5">
                    <p>Don't have an account?  <a href="{{url('/register')}}">Sign Up for free</a></p>
                </div>

            </form>
        </div>

        </div>
        </div>
    </div>
    </div>
<!--  end -->



</x-app-layout>

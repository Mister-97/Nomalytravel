<x-app-layout>
<!-- Page title start -->
<div class="pageheader">
    <div class="container">
        <h1>Forgot Password</h1>
    </div>
</div>
<!-- Page title end -->

<div class="innerpagewrap">
    <div class="container register-form">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-10">
                <div class="account-main">
                    <div class="account-title">
                        <h3>Reset Your Password</h3>
                        <p class="text-muted mt-2">Enter your email and we'll send you a reset link.</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success mb-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-outline mb-4 mt-4">
                            <div class="account-form-label"><label>Your Email</label></div>
                            <input type="email" name="email" class="form-control @if($errors->has('email')) is-invalid @endif"
                                placeholder="Enter Your Email" value="{{ old('email') }}" required autofocus>
                            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-block w-100">Send Reset Link</button>
                        </div>

                        <div class="account-bottom-text mt-5">
                            <p>Remembered your password? <a href="{{ route('login') }}">Back to Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

<x-app-layout>
<div class="pageheader">
    <div class="container"><h1>Reset Password</h1></div>
</div>
<div class="innerpagewrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow-sm p-4 p-lg-5">
                    <h4 class="mb-1">Set a New Password</h4>
                    <p class="text-muted small mb-4">Enter your new password below.</p>
                    <hr class="mb-4">

                    <x-validation-errors class="mb-4" />

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input id="email" type="email" name="email" class="form-control"
                                   value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">New Password</label>
                            <input id="password" type="password" name="password" class="form-control"
                                   required autocomplete="new-password">
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation"
                                   class="form-control" required autocomplete="new-password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

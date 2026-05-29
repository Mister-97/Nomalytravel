<x-app-layout>
<div class="innerpagewrap" style="min-height:60vh; display:flex; align-items:center;">
    <div class="container text-center py-5">
        <div style="font-size:100px; font-weight:800; color:#0a1628; line-height:1;">403</div>
        <h2 class="mt-3 mb-2">Access Denied</h2>
        <p class="text-muted mb-4">You don't have permission to view this page.</p>
        <a href="{{ url('/') }}" class="btn btn-primary me-2"><i class="fas fa-home me-2"></i>Back to Home</a>
        <a href="{{ url('/login') }}" class="btn btn-outline-secondary"><i class="fas fa-sign-in-alt me-2"></i>Login</a>
    </div>
</div>
</x-app-layout>

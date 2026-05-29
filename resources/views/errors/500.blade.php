<x-app-layout>
<div class="innerpagewrap" style="min-height:60vh; display:flex; align-items:center;">
    <div class="container text-center py-5">
        <div style="font-size:100px; font-weight:800; color:#0a1628; line-height:1;">500</div>
        <h2 class="mt-3 mb-2">Server Error</h2>
        <p class="text-muted mb-4">Something went wrong on our end. We're working to fix it — please try again shortly.</p>
        <a href="{{ url('/') }}" class="btn btn-primary me-2"><i class="fas fa-home me-2"></i>Back to Home</a>
        <a href="{{ url('/contact-us') }}" class="btn btn-outline-secondary"><i class="fas fa-headset me-2"></i>Contact Support</a>
    </div>
</div>
</x-app-layout>

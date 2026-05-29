<x-app-layout>
<div class="pageheader">
    <div class="container"><h1>Privacy Policy</h1></div>
</div>
<div class="innerpagewrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-sm p-4 p-lg-5">
                    <h2 class="mb-2">Privacy Policy</h2>
                    <p class="text-muted small mb-4">Last updated: {{ date('F j, Y') }}</p>
                    <hr class="mb-4">

                    <h5>1. Information We Collect</h5>
                    <p>We collect information you provide directly — such as your name, email address, and payment details — when you create an account or make a booking. We also collect usage data (pages visited, search queries) to improve the Service.</p>

                    <h5>2. How We Use Your Information</h5>
                    <p>We use your information to: process bookings and payments; send booking confirmations and travel updates; improve our platform; and comply with legal obligations. We do not sell your personal data to third parties.</p>

                    <h5>3. Sharing Your Information</h5>
                    <p>We share your information only with: suppliers (airlines, hotels, venues) necessary to fulfill your booking; payment processors (Stripe, PayPal) to complete transactions; and service providers who assist our operations under strict confidentiality agreements.</p>

                    <h5>4. Cookies</h5>
                    <p>We use cookies and similar technologies to maintain sessions, remember preferences, and analyze traffic. You can control cookie settings in your browser, though some features may not function without them.</p>

                    <h5>5. Data Security</h5>
                    <p>We use industry-standard encryption and security measures to protect your personal data. However, no method of transmission over the internet is 100% secure.</p>

                    <h5>6. Your Rights</h5>
                    <p>You have the right to access, correct, or delete your personal data. To make a request, contact us at <a href="mailto:info@nomalytravel.com">info@nomalytravel.com</a>.</p>

                    <h5>7. Data Retention</h5>
                    <p>We retain your personal data for as long as your account is active or as needed to provide services and comply with legal obligations.</p>

                    <h5>8. Third-Party Links</h5>
                    <p>Our platform may contain links to third-party websites. We are not responsible for their privacy practices and encourage you to review their policies.</p>

                    <h5>9. Changes to This Policy</h5>
                    <p>We may update this Privacy Policy periodically. We will notify you of significant changes via email or a notice on our platform.</p>

                    <h5>10. Contact</h5>
                    <p>Questions about this Privacy Policy? Contact us at <a href="mailto:info@nomalytravel.com">info@nomalytravel.com</a> or visit our <a href="{{ url('/contact-us') }}">Contact page</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

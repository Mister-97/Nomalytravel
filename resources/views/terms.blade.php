<x-app-layout>
<div class="pageheader">
    <div class="container"><h1>Terms of Service</h1></div>
</div>
<div class="innerpagewrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-sm p-4 p-lg-5">
                    <h2 class="mb-2">Terms of Service</h2>
                    <p class="text-muted small mb-4">Last updated: {{ date('F j, Y') }}</p>
                    <hr class="mb-4">

                    <h5>1. Acceptance of Terms</h5>
                    <p>By accessing or using Nomaly Travel ("the Service"), you agree to be bound by these Terms of Service. If you do not agree, please do not use the Service.</p>

                    <h5>2. Use of Service</h5>
                    <p>Nomaly Travel provides a platform to search and book flights, hotels, sports events, and concert tickets. We act as an agent — contracts of carriage or attendance are between you and the relevant airline, hotel, or venue.</p>

                    <h5>3. Bookings and Payments</h5>
                    <p>All bookings are subject to availability and the fare/rate rules of the supplier. Prices displayed include taxes and fees unless otherwise stated. Payment is processed securely through our payment partners.</p>

                    <h5>4. Cancellations and Refunds</h5>
                    <p>Cancellation and change policies vary by supplier. Please review the specific terms at the time of booking. Nomaly Travel's service fee is non-refundable unless the booking is cancelled within 24 hours of purchase.</p>

                    <h5>5. User Accounts</h5>
                    <p>You are responsible for maintaining the confidentiality of your account credentials and agree to notify us immediately of any unauthorized use.</p>

                    <h5>6. Prohibited Conduct</h5>
                    <p>You may not use the Service for any unlawful purpose, to make fraudulent bookings, or to interfere with the operation of the platform.</p>

                    <h5>7. Limitation of Liability</h5>
                    <p>Nomaly Travel is not liable for delays, cancellations, or issues caused by airlines, hotels, or third-party providers. Our liability is limited to the fees paid to Nomaly Travel for the specific booking.</p>

                    <h5>8. Changes to Terms</h5>
                    <p>We reserve the right to update these Terms at any time. Continued use of the Service after changes constitutes acceptance of the new terms.</p>

                    <h5>9. Contact</h5>
                    <p>For questions about these Terms, contact us at <a href="mailto:info@nomalytravel.com">info@nomalytravel.com</a> or visit our <a href="{{ url('/contact-us') }}">Contact page</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

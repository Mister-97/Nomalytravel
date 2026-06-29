@extends('layouts.app')

@section('title', 'Booking Confirmed')

@section('content')
<div class="container py-5" style="max-width:720px;">

    @if ($error ?? null)
        <div class="alert alert-danger">{{ $error }}</div>
    @endif

    @php
        $r        = $reservation;
        $acc      = $r['accommodation'] ?? [];
        $currency = $r['total_currency'] ?? 'USD';
    @endphp

    <div class="text-center mb-5">
        <div style="font-size:3rem;">&#10003;</div>
        <h1 class="fw-bold">Booking Confirmed!</h1>
        <p class="text-muted">Your reservation reference is <strong>{{ $r['reference'] ?? $r['id'] ?? 'N/A' }}</strong></p>
        <p class="text-muted small">A confirmation has been sent to your email address.</p>
    </div>

    {{-- Accommodation summary --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="fw-semibold mb-1">{{ $acc['name'] ?? 'Your Stay' }}</h5>
            <p class="text-muted small mb-2">
                {{ $acc['location']['address']['line_one'] ?? '' }},
                {{ $acc['location']['address']['city_name'] ?? '' }}
            </p>
            <div class="row small">
                <div class="col-6">
                    <p class="mb-1"><strong>Check-in</strong></p>
                    <p>{{ $r['check_in_date'] ?? '' }}</p>
                </div>
                <div class="col-6">
                    <p class="mb-1"><strong>Check-out</strong></p>
                    <p>{{ $r['check_out_date'] ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Cost breakdown -- required by Duffel go-live --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h6 class="fw-semibold mb-3">Payment Summary</h6>
            <div class="d-flex justify-content-between small"><span>Base rate</span><span>{{ $currency }} {{ number_format(($r['total_amount'] ?? 0) - ($r['tax_amount'] ?? 0) - ($r['fee_amount'] ?? 0), 2) }}</span></div>
            <div class="d-flex justify-content-between small"><span>Tax</span><span>{{ $currency }} {{ number_format($r['tax_amount'] ?? 0, 2) }}</span></div>
            <div class="d-flex justify-content-between small"><span>Fees</span><span>{{ $currency }} {{ number_format($r['fee_amount'] ?? 0, 2) }}</span></div>
            <div class="d-flex justify-content-between small text-muted"><span>Due at property</span><span>{{ $currency }} {{ number_format($r['due_at_accommodation_amount'] ?? 0, 2) }}</span></div>
            <hr>
            <div class="d-flex justify-content-between fw-bold"><span>Total charged</span><span>{{ $currency }} {{ number_format($r['total_amount'] ?? 0, 2) }}</span></div>
        </div>
    </div>

    {{-- Cancellation policy -- required by Duffel go-live --}}
    <div class="card mb-4 border-warning">
        <div class="card-body">
            <h6 class="fw-semibold">Cancellation Policy</h6>
            @forelse ($r['conditions']['refund_conditions'] ?? [] as $condition)
                <p class="small mb-1">
                    @if ($condition['penalty_type'] === 'no_refund')
                        <span class="text-danger fw-semibold">Non-refundable</span>
                    @elseif ($condition['penalty_type'] === 'free_cancellation')
                        <span class="text-success fw-semibold">Free cancellation</span>
                        @if (!empty($condition['applicable_before']))before {{ $condition['applicable_before'] }}@endif
                    @else
                        {{ ucfirst(str_replace('_', ' ', $condition['penalty_type'])) }}
                    @endif
                </p>
            @empty
                <p class="small text-muted">Contact the property or Nomaly Travel for cancellation details.</p>
            @endforelse
        </div>
    </div>

    {{-- Key collection -- required by Duffel go-live --}}
    <div class="card mb-4 border-info">
        <div class="card-body">
            <h6 class="fw-semibold">Key Collection</h6>
            @if (!empty($acc['key_collection']['instructions']))
                <p class="small">{{ $acc['key_collection']['instructions'] }}</p>
            @else
                <p class="small text-muted">Key collection details will be provided by the property. Check your confirmation email or contact them directly.</p>
            @endif
        </div>
    </div>

    {{-- Guest details --}}
    @if (!empty($r['guests']))
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">Guest Details</h6>
                @foreach ($r['guests'] as $guest)
                    <p class="small mb-1">
                        {{ $guest['given_name'] ?? '' }} {{ $guest['family_name'] ?? '' }}
                        &mdash; {{ $guest['email'] ?? '' }}
                        &mdash; {{ $guest['phone_number'] ?? '' }}
                    </p>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Business footer -- required by Duffel go-live --}}
    <div class="card bg-light border-0">
        <div class="card-body small text-muted">
            <p class="fw-semibold mb-1">Nomaly Travel</p>
            <p class="mb-1">123 Travel Street, Suite 1, Your City &mdash; contact@nomalytravel.com</p>
            <p class="mb-0">
                This booking is subject to our <a href="/terms" target="_blank">Terms &amp; Conditions</a>.
                For support, email us at contact@nomalytravel.com.
            </p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('stays.index') }}" class="btn btn-outline-primary">Search More Hotels</a>
    </div>

</div>
@endsection

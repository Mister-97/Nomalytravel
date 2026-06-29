@extends('layouts.app')

@section('title', 'Complete Your Booking')

@section('content')
<div class="container py-5" style="max-width:700px;">
    <h1 class="fw-bold mb-4">Complete Your Booking</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    @php
        $q         = $quote;
        $baseRate  = $q['total_amount'] ?? 0;
        $taxAmt    = $q['tax_amount'] ?? 0;
        $feeAmt    = $q['fee_amount'] ?? 0;
        $dueAtProp = $q['due_at_accommodation_amount'] ?? 0;
        $currency  = $q['currency'] ?? 'USD';
    @endphp

    {{-- Quote summary --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="fw-semibold">{{ $q['accommodation']['name'] ?? 'Your Stay' }}</h5>
            <p class="text-muted small mb-2">
                {{ $q['check_in_date'] ?? '' }} &ndash; {{ $q['check_out_date'] ?? '' }}
            </p>
            <hr>
            <div class="d-flex justify-content-between small"><span>Base rate</span><span>{{ $currency }} {{ number_format($baseRate - $taxAmt - $feeAmt, 2) }}</span></div>
            <div class="d-flex justify-content-between small"><span>Tax</span><span>{{ $currency }} {{ number_format($taxAmt, 2) }}</span></div>
            <div class="d-flex justify-content-between small"><span>Fees</span><span>{{ $currency }} {{ number_format($feeAmt, 2) }}</span></div>
            <div class="d-flex justify-content-between small text-muted"><span>Due at property</span><span>{{ $currency }} {{ number_format($dueAtProp, 2) }}</span></div>
            <hr>
            <div class="d-flex justify-content-between fw-bold"><span>Total charged now</span><span>{{ $currency }} {{ number_format($baseRate, 2) }}</span></div>
        </div>
    </div>

    {{-- Cancellation conditions --}}
    <div class="card mb-4 border-warning">
        <div class="card-body">
            <h6 class="fw-semibold">Cancellation Policy</h6>
            @forelse ($q['conditions']['refund_conditions'] ?? [] as $condition)
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
                <p class="small text-muted">Please review the property's cancellation policy.</p>
            @endforelse
        </div>
    </div>

    {{-- Guest details form --}}
    <form action="{{ route('stays.reserve') }}" method="POST">
        @csrf
        <input type="hidden" name="quote_id" value="{{ $q['id'] }}">
        <input type="hidden" name="amount"   value="{{ $baseRate }}">
        <input type="hidden" name="currency" value="{{ $currency }}">

        <h5 class="fw-semibold mb-3">Lead Guest Details</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" required value="{{ old('first_name') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Phone (with country code)</label>
                <input type="tel" name="phone" class="form-control" placeholder="+1 555 555 0100" required value="{{ old('phone') }}">
            </div>
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" id="agreeTerms" required>
            <label class="form-check-label small" for="agreeTerms">
                I agree to the <a href="/terms" target="_blank">Terms &amp; Conditions</a> and the property's cancellation policy shown above.
            </label>
        </div>

        <button type="submit" class="btn btn-success px-5 fw-bold">
            Confirm &amp; Pay {{ $currency }} {{ number_format($baseRate, 2) }}
        </button>
    </form>

    <p class="text-muted small mt-3">
        Booking provided by Nomaly Travel. Contact us at contact@nomalytravel.com for support.
    </p>
</div>
@endsection

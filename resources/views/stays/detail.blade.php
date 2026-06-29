@extends('layouts.app')

@section('title', ($accommodation['name'] ?? 'Hotel Detail'))

@section('content')
<div class="container py-5">

    @if ($error ?? null)
        <div class="alert alert-warning">{{ $error }}</div>
    @endif

    @php
        $acc = $accommodation;
        $addr = $acc['location']['address'] ?? [];
    @endphp

    {{-- Property header --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="fw-bold">{{ $acc['name'] ?? '' }}</h1>
            <p class="text-muted">
                {{ $addr['line_one'] ?? '' }}{{ !empty($addr['line_two']) ? ', ' . $addr['line_two'] : '' }},
                {{ $addr['city_name'] ?? '' }},
                {{ $addr['country_code'] ?? '' }}
            </p>
            @if (!empty($acc['rating']))
                <div class="mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <span style="font-size:1.2rem;color:{{ $i <= $acc['rating'] ? '#f5a623' : '#ccc' }}">&#9733;</span>
                    @endfor
                </div>
            @endif
            @if (!empty($acc['description']))
                <p>{{ $acc['description'] }}</p>
            @endif
        </div>
    </div>

    {{-- Photo gallery --}}
    @if (!empty($acc['photos']))
        <div class="d-flex gap-2 mb-4 overflow-auto">
            @foreach (array_slice($acc['photos'], 0, 6) as $photo)
                <img src="{{ $photo['url'] }}" style="height:180px;border-radius:6px;" alt="">
            @endforeach
        </div>
    @endif

    {{-- Amenities --}}
    @if (!empty($acc['amenities']))
        <h5 class="fw-semibold mb-2">Amenities</h5>
        <ul class="list-inline mb-4">
            @foreach ($acc['amenities'] as $amenity)
                <li class="list-inline-item badge bg-light text-dark border me-1 mb-1">{{ $amenity['description'] ?? $amenity['type'] ?? $amenity }}</li>
            @endforeach
        </ul>
    @endif

    {{-- Check-in / check-out info --}}
    @if (!empty($acc['check_in_information']) || !empty($acc['check_out_information']))
        <div class="row mb-4">
            @if (!empty($acc['check_in_information']))
                <div class="col-md-6">
                    <h5 class="fw-semibold">Check-in</h5>
                    <p class="mb-1">From: {{ $acc['check_in_information']['check_in_after_time'] ?? 'N/A' }}</p>
                    <p>Instructions: {{ $acc['check_in_information']['instructions'] ?? 'Please contact the property.' }}</p>
                </div>
            @endif
            @if (!empty($acc['check_out_information']))
                <div class="col-md-6">
                    <h5 class="fw-semibold">Check-out</h5>
                    <p>By: {{ $acc['check_out_information']['check_out_before_time'] ?? 'N/A' }}</p>
                </div>
            @endif
        </div>
    @endif

    {{-- Key collection -- required by Duffel go-live, always visible --}}
    <div class="card mb-4 border-info">
        <div class="card-body">
            <h5 class="fw-semibold">Key Collection</h5>
            @php $keyInfo = $acc['key_collection'] ?? null; @endphp
            @if (!empty($keyInfo['instructions']))
                <p>{{ $keyInfo['instructions'] }}</p>
            @else
                <p class="text-muted">Key collection details will be confirmed in your booking confirmation email.</p>
            @endif
        </div>
    </div>

    {{-- Rate plans --}}
    <h4 class="fw-bold mb-3">Available Rates</h4>
    @forelse ($acc['rate_plans'] ?? [] as $plan)
        @php
            $baseAmount      = $plan['total_amount'] ?? 0;
            $taxAmount       = $plan['tax_amount'] ?? 0;
            $feeAmount       = $plan['fee_amount'] ?? 0;
            $dueAtProperty   = $plan['due_at_accommodation_amount'] ?? 0;
            $currency        = $plan['currency'] ?? 'USD';
        @endphp
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <div class="row align-items-start">
                    <div class="col-md-8">
                        <h6 class="fw-semibold">{{ $plan['name'] ?? 'Standard Rate' }}</h6>
                        @if (!empty($plan['board_type']))
                            <p class="text-muted small mb-1">Board: {{ ucfirst(str_replace('_', ' ', $plan['board_type'])) }}</p>
                        @endif

                        {{-- Cancellation / conditions -- required verbatim --}}
                        <div class="mt-2">
                            <p class="fw-semibold mb-1 small">Cancellation &amp; Conditions:</p>
                            @if (!empty($plan['conditions']['refund_conditions']))
                                @foreach ($plan['conditions']['refund_conditions'] as $condition)
                                    <p class="small mb-1">
                                        @if ($condition['penalty_type'] === 'no_refund')
                                            <span class="text-danger">Non-refundable</span>
                                            @if (!empty($condition['applicable_before']))
                                                &mdash; applies if cancelled after {{ $condition['applicable_before'] }}
                                            @endif
                                        @elseif ($condition['penalty_type'] === 'free_cancellation')
                                            <span class="text-success">Free cancellation</span>
                                            @if (!empty($condition['applicable_before']))
                                                before {{ $condition['applicable_before'] }}
                                            @endif
                                        @else
                                            {{ ucfirst(str_replace('_', ' ', $condition['penalty_type'])) }}
                                            @if (!empty($condition['applicable_before']))
                                                &mdash; before {{ $condition['applicable_before'] }}
                                            @endif
                                        @endif
                                    </p>
                                @endforeach
                            @elseif (!empty($plan['conditions']))
                                <p class="small text-muted">Please review the property's cancellation policy before booking.</p>
                            @else
                                <p class="small text-muted">Cancellation conditions not specified. Contact the property for details.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Pricing breakdown -- required by Duffel go-live --}}
                    <div class="col-md-4 text-md-end">
                        <p class="mb-1 small">Base rate: <strong>{{ $currency }} {{ number_format($baseAmount - $taxAmount - $feeAmount, 2) }}</strong></p>
                        <p class="mb-1 small">Tax: <strong>{{ $currency }} {{ number_format($taxAmount, 2) }}</strong></p>
                        <p class="mb-1 small">Fees: <strong>{{ $currency }} {{ number_format($feeAmount, 2) }}</strong></p>
                        <p class="mb-2 small text-muted">Due at property: <strong>{{ $currency }} {{ number_format($dueAtProperty, 2) }}</strong></p>
                        <p class="fw-bold fs-5 mb-2">{{ $currency }} {{ number_format($baseAmount, 2) }} total</p>

                        <form action="{{ route('stays.quote') }}" method="POST">
                            @csrf
                            <input type="hidden" name="accommodation_id" value="{{ $acc['id'] }}">
                            <input type="hidden" name="rate_plan_id"     value="{{ $plan['id'] }}">
                            <input type="hidden" name="check_in_date"    value="{{ $params['check_in_date'] ?? '' }}">
                            <input type="hidden" name="check_out_date"   value="{{ $params['check_out_date'] ?? '' }}">
                            <input type="hidden" name="rooms"            value="{{ $params['rooms'] ?? 1 }}">
                            <input type="hidden" name="adults"           value="{{ $params['adults'] ?? 2 }}">
                            <button type="submit" class="btn btn-primary">Book This Rate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">No rates available for this property on the selected dates.</p>
    @endforelse

    {{-- Business details -- required by Duffel go-live --}}
    <div class="card mt-5 bg-light border-0">
        <div class="card-body small text-muted">
            <p class="fw-semibold mb-1">Booking provided by Nomaly Travel</p>
            <p class="mb-1">123 Travel Street, Suite 1, Your City &mdash; contact@nomalytravel.com</p>
            <p class="mb-0">
                By completing a booking you agree to our
                <a href="/terms" target="_blank">Terms &amp; Conditions</a>
                and the property's house rules listed above.
            </p>
        </div>
    </div>

</div>
@endsection

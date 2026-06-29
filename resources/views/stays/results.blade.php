@extends('layouts.app')

@section('title', 'Hotel Search Results')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-2">Results for {{ $params['destination'] ?? '' }}</h1>
    <p class="text-muted mb-4">
        {{ $params['check_in_date'] }} &ndash; {{ $params['check_out_date'] }} &middot;
        {{ $params['adults'] ?? 1 }} adult(s) &middot; {{ $params['rooms'] ?? 1 }} room(s)
    </p>

    <a href="{{ route('stays.index') }}" class="btn btn-outline-secondary mb-4">Modify Search</a>

    @if ($error ?? null)
        <div class="alert alert-warning">{{ $error }}</div>
    @endif

    @if (count($accommodations) === 0)
        <p>No results found. Try a different destination or dates.</p>
    @else
        <div class="row g-4">
            @foreach ($accommodations as $acc)
                @php
                    $searchId = $acc['search_id'] ?? $searchId;
                    $lowestRate = collect($acc['cheapest_rate_plan'] ?? [])->first();
                    $totalAmount = $acc['cheapest_rate_total_amount'] ?? null;
                    $currency    = $acc['cheapest_rate_currency'] ?? 'USD';
                @endphp
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        @if (!empty($acc['photos'][0]['url']))
                            <img src="{{ $acc['photos'][0]['url'] }}" class="card-img-top"
                                 style="height:200px;object-fit:cover;"
                                 alt="{{ $acc['name'] }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $acc['name'] }}</h5>
                            <p class="text-muted small mb-1">
                                {{ $acc['location']['address']['line_one'] ?? '' }},
                                {{ $acc['location']['address']['city_name'] ?? '' }}
                            </p>
                            @if (!empty($acc['rating']))
                                <p class="small mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span style="color:{{ $i <= $acc['rating'] ? '#f5a623' : '#ccc' }}">&#9733;</span>
                                    @endfor
                                </p>
                            @endif
                            @if ($totalAmount)
                                <p class="fw-bold mt-auto mb-1">{{ $currency }} {{ number_format($totalAmount, 2) }} total</p>
                                <p class="text-muted small">Includes taxes and fees</p>
                            @endif
                            <a href="{{ route('stays.detail', [$searchId, $acc['id']]) }}?{{ http_build_query($params) }}"
                               class="btn btn-primary mt-2">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Find a Place to Stay')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Find a Place to Stay</h1>

    <form action="{{ route('stays.search') }}" method="GET" class="card shadow-sm p-4">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Destination</label>
                <input type="text" name="destination" id="destination" class="form-control"
                    placeholder="City, neighbourhood, or landmark" required>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Check-in</label>
                <input type="date" name="check_in_date" class="form-control" required
                    min="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Check-out</label>
                <input type="date" name="check_out_date" class="form-control" required
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Adults</label>
                <select name="adults" class="form-select">
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Rooms</label>
                <select name="rooms" class="form-select">
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary px-5">Search</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const destInput = document.getElementById('destination');
    destInput.addEventListener('blur', function () {
        const val = encodeURIComponent(this.value);
        fetch(`https://nominatim.openstreetmap.org/search?q=${val}&format=json&limit=1`)
            .then(r => r.json())
            .then(data => {
                if (data && data[0]) {
                    document.getElementById('latitude').value  = data[0].lat;
                    document.getElementById('longitude').value = data[0].lon;
                }
            });
    });
});
</script>
@endsection

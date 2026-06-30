@extends('layouts.dashboard')

@section('title', $bien->titre)

@php
    $firstImage = is_array($bien->image) && count($bien->image) > 0 ? $bien->image[0] : null;
@endphp
@section('content')
    <div class="container mt-5">
        <h2 class="mb-0">{{ $bien->titre }}</h2>
        @if($firstImage)
            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $bien->titre }}" class="img-fluid mb-3 rounded">
        @endif

        <h5 class="text-muted">Description</h5>
        <p class="card-text">{{ $bien->description }}</p>

        <h5 class="text-muted mt-4">Prix</h5>
        <p class="h4 text-primary">{{ number_format($bien->prix, 0, ',', ' ') }} FCFA</p>
    </div>
@endsection
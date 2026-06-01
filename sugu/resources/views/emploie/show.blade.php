@extends('layouts.dashboard')

@section('title', $emploi->titre)

@section('content')
    <div class="container mt-5">
        <h2 class="mb-0">{{ $emploi->titre }}</h2>
        <h5 class="text-muted">Description</h5>
        <p class="card-text">{{ $emploi->description }}</p>

        <h5 class="text-muted mt-4">Détails de l'offre</h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Ville:</strong> {{ $emploi->ville }}</p>
                <p><strong>Salaire:</strong> {{ number_format($emploi->salaire, 0, ',', ' ') }} FCFA</p>
            </div>
            <div class="col-md-6">
                <p><strong>Publié par:</strong> {{ $emploi->user->name }}</p>
                <p><strong>Date de publication:</strong> {{ $emploi->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>
@endsection
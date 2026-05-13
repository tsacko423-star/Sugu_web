@extends('layouts.admin')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="display-6">Liste des annonces</h1>
            <p class="text-secondary mb-0">Découvrez toutes les annonces disponibles sur SUGU-WEB.</p>
        </div>
        <a href="{{ route('annonces.create') }}" class="btn btn-luxe">
            <i class="bi bi-plus-circle me-2"></i> Créer une annonce
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($annonces->count() > 0)
        <div class="row g-4">
            @foreach($annonces as $annonce)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        @php
                            $firstImage = is_array($annonce->images) && count($annonce->images) > 0 
                                ? $annonce->images[0] 
                                : null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $annonce->titre }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-{{ $annonce->categorie->icon ?? 'tag' }}" style="font-size: 3rem; color: #6c757d;"></i>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $annonce->titre }}</h5>
                            <p class="card-text text-truncate">{{ $annonce->description }}</p>
                            <div class="mt-auto">
                                <p class="h5 text-primary mb-2">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-secondary">{{ ucfirst($annonce->categorie->name ?? 'Annonce') }}</span>
                                    <a href="{{ route('annonces.show', $annonce->id) }}" class="btn btn-luxe btn-sm">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-info-circle" style="font-size: 3rem; color: #6c757d;"></i>
            <h3 class="mt-3 text-muted">Aucune annonce trouvée</h3>
            <p class="text-muted">Soyez le premier à publier une annonce !</p>
            <a href="{{ route('annonces.create') }}" class="btn btn-luxe">
                <i class="bi bi-plus-circle"></i> Créer la première annonce
            </a>
        </div>
    @endif
</div>
@endsection
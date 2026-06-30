@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h2 mb-2" style="color: var(--sugu-text);">Liste des annonces</h1>
        <p class="mb-0" style="color: var(--sugu-text-muted);">Découvrez toutes les annonces disponibles sur SUGU-WEB.</p>
    </div>
    <a href="{{ route('annonces.create') }}" class="btn-primary-custom" style="white-space: nowrap;">
        <i class="bi bi-plus-circle me-2"></i> Créer une annonce
    </a>
</div>

    @if(session('success'))
        <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.15); border: 1px solid var(--sugu-success); color: var(--sugu-success);">
            {{ session('success') }}
        </div>
    @endif

    @if($annonces->count() > 0)
        <div class="row g-4">
            @foreach($annonces as $annonce)
                <div class="col-md-6 col-lg-4">
                    <div class="dashboard-card h-100">
                        @php
                            $firstImage = is_array($annonce->images) && count($annonce->images) > 0
                                ? $annonce->images[0]
                                : null;
                        @endphp
                        @if($firstImage)
                            <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $annonce->titre }}" style="height: 200px; object-fit: cover; width: 100%;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background: var(--sugu-bg-card);">
                                <i class="bi bi-{{ $annonce->categorie->icon ?? 'tag' }}" style="font-size: 3rem; color: var(--sugu-text-muted);"></i>
                            </div>
                        @endif
                        <div class="dashboard-card-body d-flex flex-column">
                            <h5 class="card-title mb-2" style="color: var(--sugu-text);">{{ $annonce->titre }}</h5>
                            <p class="card-text text-truncate mb-3" style="color: var(--sugu-text-muted);">{{ $annonce->description }}</p>
                            <div class="mt-auto">
                                <p class="h5 mb-2" style="color: var(--sugu-accent);">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</p>
                                <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                    <span class="badge" style="background: rgba(249, 115, 22, 0.2); color: var(--sugu-accent);">{{ ucfirst($annonce->categorie->name ?? 'Annonce') }}</span>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('annonces.show', $annonce->id) }}" class="btn-outline-custom btn-sm">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                        <a href="{{ route('annonces.show', $annonce->id) }}#contact-vendeur" class="btn-primary-custom btn-sm">
                                            <i class="bi bi-envelope"></i> Contacter
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-info-circle" style="font-size: 3rem; color: var(--sugu-text-muted);"></i>
            <h3 class="mt-3 mb-2" style="color: var(--sugu-text-muted);">Aucune annonce trouvée</h3>
            <p style="color: var(--sugu-text-muted);">Soyez le premier à publier une annonce !</p>
            <a href="{{ route('annonces.create') }}" class="btn-primary-custom">
                <i class="bi bi-plus-circle"></i> Créer la première annonce
            </a>
        </div>
    @endif
@endsection

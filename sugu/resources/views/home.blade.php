@extends('layouts.app')

@section('content')
<section class="hero">
    <div>
        <h1>Sugu Web</h1>
        <p>Plateforme moderne pour acheter, vendre et trouver un emploi</p>
        <a href="#immobilier" class="btn btn-luxe mt-3">Explorer</a>
    </div>
</section>

<section class="search-section">
    <div class="container search-container">
        <div class="search-bar">
            <button class="hamburger-menu" type="button">
                <i class="bi bi-list"></i>
            </button>
            <div class="search-input-group">
                <form action="{{ route('search') }}" method="GET" style="width: 100%;">
                    <div style="position: relative;">
                        <i class="bi bi-search search-icon"></i>
                        <input type="search" name="q" class="search-input" placeholder="Rechercher une annonce sur SUGU-WEB" autocomplete="off">
                    </div>
                </form>
            </div>
        </div>

        <div class="categories-row">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}" class="category-link">{{ $category->name }}</a>
                @if(!$loop->last)
                    <span class="category-separator">•</span>
                @endif
            @endforeach
        </div>
    </div>
</section>

<section id="immobilier" class="section container">
    <h2>Immobilier</h2>
    <div class="row g-4">
        @foreach($biens as $bien)
            <div class="col-md-4">
                <div class="card">
                    @if($bien->image_url)
                        <img src="{{ $bien->image_url }}" alt="{{ $bien->titre }}">
                    @endif
                    <div class="card-body">
                        <h5>{{ $bien->titre }}</h5>
                        <p>{{ $bien->prix }} FCFA - {{ $bien->ville }}</p>
                        <button class="btn btn-luxe">Contacter</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="voitures" class="section container">
    <h2>Voitures</h2>
    <div class="row g-4">
        @foreach($voitures as $voiture)
            <div class="col-md-4">
                <div class="card">
                    @if($voiture->image)
                        <img src="{{ asset('storage/' . $voiture->image) }}" alt="{{ $voiture->marque }} {{ $voiture->modele }}">
                    @endif
                    <div class="card-body">
                        <h5>{{ $voiture->marque }} {{ $voiture->modele }}</h5>
                        <p>{{ $voiture->prix }} FCFA</p>
                        <button class="btn btn-luxe">Contacter</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="emploi" class="section container">
    <h2>Offres d'emploi</h2>
    <div class="row g-4">
        @foreach($emplois as $emploi)
            <div class="col-md-4">
                <div class="card p-3">
                    <h5>{{ $emploi->titre }}</h5>
                    <p>{{ $emploi->ville }} - {{ $emploi->salaire }} FCFA</p>
                    <button class="btn btn-luxe">Postuler</button>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
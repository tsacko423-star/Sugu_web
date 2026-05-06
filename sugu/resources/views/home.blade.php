@extends('layouts.app')

@push('styles')
    <style>
        body {
            background: #262222;
            color: #f5f5f3;
            font-family: 'Poppins', sans-serif;
        }

        h1,
        h2,
        h3,
        h5 {
            font-family: 'Playfair Display', serif;
        }

        .hero {
            min-height: 100vh;
            margin-top: -6rem;
            padding-top: 6rem;
            background: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.75)), url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero .hero-inner {
            max-width: 760px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .hero h1 {
            font-size: clamp(2.6rem, 5vw, 4.5rem);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.15rem;
            color: #ddd;
            margin-bottom: 1.75rem;
        }

        .btn-luxe {
            background: gold;
            color: #000;
            border-radius: 30px;
            padding: 0.9rem 2.2rem;
            font-weight: 600;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-luxe:hover {
            background: #fff;
            color: #000;
        }

        .section {
            padding: 5rem 0;
        }

        .section h2 {
            border-left: 5px solid gold;
            padding-left: 15px;
            margin-bottom: 2rem;
            font-size: 2rem;
        }

        .section .section-body {
            gap: 1.5rem;
        }

        .section .section-footer {
            text-align: center;
            margin-top: 2rem;
        }

        .card {
            background: #111;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.12);
            min-height: 100%;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.25);
        }

        .card img {
            width: 100%;
            height: 240px;
            object-fit: cover;
        }

        .card-body {
            padding: 1.4rem;
        }

        .card-body h5 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .card-body p {
            color: #bbb;
            margin-bottom: 1.25rem;
        }

        .card-body .btn-luxe {
            width: 100%;
        }

        footer {
            background: #000;
            padding: 40px;
            text-align: center;
            color: #aaa;
        }
    </style>
@endpush

@section('content')
    <section class="hero">
        <div class="hero-inner text-white">
            <h1>Sugu Web</h1>
            <p>Plateforme moderne pour acheter, vendre et trouver un emploi en un seul endroit.</p>
            <a href="#immobilier" class="btn btn-luxe mt-3">Explorer</a>
        </div>
    </section>

    <section id="immobilier" class="section bg-dark">
        <div class="container">
            <h2>Immobilier</h2>
            <div class="row g-4 section-body">
                @foreach($biens as $bien)
                    <div class="col-md-4">
                        <div class="card h-100">
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
            <div class="section-footer">
                <a href="{{ route('acceuil') }}" class="btn btn-luxe">Voir toutes les annonces</a>
            </div>
        </div>
    </section>

    <section id="voitures" class="section">
        <div class="container">
            <h2>Voitures</h2>
            <div class="row g-4 section-body">
                @foreach($voitures as $voiture)
                    <div class="col-md-4">
                        <div class="card h-100">
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
            <div class="section-footer">
                <a href="{{ route('acceuil') }}" class="btn btn-luxe">Voir toutes les voitures</a>
            </div>
        </div>
    </section>

    <section id="emploi" class="section bg-dark">
        <div class="container">
            <h2>Offres d'emploi</h2>
            <div class="row g-4 section-body">
                @foreach($emplois as $emploi)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5>{{ $emploi->titre }}</h5>
                                <p>{{ $emploi->ville }} - {{ $emploi->salaire }} FCFA</p>
                                <button class="btn btn-luxe">Postuler</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="section-footer">
                <a href="{{ route('acceuil') }}" class="btn btn-luxe">Voir toutes les offres</a>
            </div>
        </div>
    </section>
@endsection
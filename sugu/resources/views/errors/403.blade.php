@extends('layouts.app')

@section('title', 'Accès refusé')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center">
                <div class="mb-4">
                    <i class="bi bi-shield-lock-fill text-warning" style="font-size: 4rem;"></i>
                </div>

                <div class="text-warning fw-bold text-uppercase" style="font-size: 0.9rem; letter-spacing: 0.1em;">Erreur 403</div>
                <h1 class="fw-bold mb-3" style="font-size: 2.5rem;">Accès refusé</h1>

                <p class="text-secondary mb-4">
                    Cette partie est réservée aux administrateurs. Votre compte est bien connecté,
                    mais il n'a pas les droits nécessaires pour utiliser cette fonctionnalité.
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-warning">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Retour au tableau de bord
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-house me-2"></i>
                        Accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

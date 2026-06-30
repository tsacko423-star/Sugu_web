@extends('layouts.app')

@section('content')
    <section class="hero">
        <div>
            <h1>Sugu Web</h1>
            <p>Plateforme moderne pour acheter, vendre et trouver un emploi</p>
            <a href="{{ route('home') }}" class="btn btn-luxe mt-3">Acceder a l'accueil</a>
        </div>
    </section>
@endsection

@extends('layouts.admin')

@section('content')
<div class="container py-5 mt-5">
    <div class="card p-4">
        <h1 class="h3 mb-3">{{ $attribut->nom }}</h1>
        <p class="text-secondary mb-4">Attribut créé le {{ $attribut->created_at->format('d/m/Y H:i') }}</p>

        <div class="d-flex gap-2">
            <a href="{{ route('attributs.edit', $attribut->id) }}" class="btn btn-primary">Modifier</a>
            <a href="{{ route('attributs.index') }}" class="btn btn-outline-dark">Retour</a>
        </div>
    </div>
</div>
@endsection

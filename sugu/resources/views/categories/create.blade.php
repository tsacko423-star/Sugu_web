@extends('layouts.admin')

@section('content')
<div class="container py-5 mt-5">
    <div class="card p-4">
        <div class="mb-4">
            <h1 class="h3">Enregistrer une catégorie</h1>
            <p class="text-secondary">Ajoutez une nouvelle catégorie à votre catalogue.</p>
        </div>

        <form method="POST" action="{{ route('categories.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nom de la catégorie</label>
                <input type="text" name="name" class="form-control" placeholder="Nom de la catégorie" required />
            </div>

            <div class="mb-3">
                <label class="form-label">Icône (optionnel)</label>
                <input type="text" name="icon" class="form-control" placeholder="Ex: house, car-front" />
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-luxe" type="submit">
                    Enregistrer
                </button>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-dark">
                    Liste des catégories
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

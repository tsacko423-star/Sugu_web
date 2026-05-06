@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Modifier l'annonce</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('annonces.update', $annonce->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" value="{{ old('titre', $annonce->titre) }}" class="form-control" placeholder="Titre de l'annonce" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catégorie</label>
                <select name="categorie_id" class="form-control" required>
                    <option value="">Sélectionnez une catégorie</option>
                    @foreach($categories ?? [] as $categorie)
                        <option value="{{ $categorie->id }}" {{ old('categorie_id', $annonce->categorie_id) == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Description détaillée">{{ old('description', $annonce->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix</label>
                <input type="number" name="prix" value="{{ old('prix', $annonce->prix) }}" class="form-control" step="0.01" placeholder="Prix en FCFA" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Modifier l'annonce</button>
                <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
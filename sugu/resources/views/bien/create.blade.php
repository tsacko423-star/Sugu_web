@extends('layouts.dashboard')

@section('title', 'Créer un bien')

@section('content')
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Créer un bien</h2>

            <form action="{{ route('biens.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ville</label>
                    <input type="text" name="ville" value="{{ old('ville') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Décrire le bien...">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prix</label>
                    <input type="number" name="prix" value="{{ old('prix') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Images (optionnel)</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    <div class="form-text">Vous pouvez sélectionner plusieurs images.</div>
                </div>

                <button type="submit" class="btn btn-success w-100">Créer</button>
            </form>
        </div>
    </div>
@endsection

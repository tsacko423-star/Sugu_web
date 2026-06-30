@extends('layouts.dashboard')

@section('title', 'Modifier un bien')

@php
    $existingImages = is_array($bien->image) ? $bien->image : [];
@endphp
@section('content')
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Modifier un bien</h2>

            <form action="{{ route('biens.update', $bien->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" value="{{ old('titre', $bien->titre) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ville</label>
                    <input type="text" name="ville" value="{{ old('ville', $bien->ville) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Décrire le bien...">{{ old('description', $bien->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prix</label>
                    <input type="number" name="prix" value="{{ old('prix', $bien->prix) }}" class="form-control" required>
                </div>

                @if(count($existingImages) > 0)
                    <div class="mb-3">
                        <label class="form-label">Images existantes</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($existingImages as $img)
                                <img src="{{ asset('storage/' . $img) }}" class="rounded" style="height: 100px; width: 100px; object-fit: cover;">
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Ajouter des images</label>
                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    <small class="text-muted">Sélectionnez de nouvelles images pour les ajouter.</small>
                </div>

                <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
            </form>
        </div>
    </div>
@endsection

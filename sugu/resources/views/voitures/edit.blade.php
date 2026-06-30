@extends('layouts.dashboard')

@section('title', 'Modifier une voiture')

@section('content')
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Modifier une voiture</h2>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form enctype="multipart/form-data" action="{{ route('voitures.update', $voiture->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Marque</label>
                    <input type="text" name="marque" value="{{ old('marque', $voiture->marque) }}" class="form-control" placeholder="Ex: Toyota" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Modèle</label>
                    <input type="text" name="modele" value="{{ old('modele', $voiture->modele) }}" class="form-control" placeholder="Ex: Corolla" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Année</label>
                    <input type="number" name="annee" value="{{ old('annee', $voiture->annee) }}" class="form-control" placeholder="Ex: 2020" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prix</label>
                    <input type="number" name="prix" value="{{ old('prix', $voiture->prix) }}" class="form-control" placeholder="Ex: 5000000" required>
                </div>

                @php
                    $existingImages = is_array($voiture->image) ? $voiture->image : [];
                @endphp
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
                    <small class="text-muted">Sélectionnez de nouvelles images pour les ajouter à la galerie.</small>
                </div>

                <button type="submit" class="btn btn-primary w-100">Modifier</button>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.dashboard')

@section('title', 'Modifier un bien')

@section('content')
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Modifier un bien</h2>

            <form action="{{ route('biens.update', $bien->id) }}" method="POST">
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
                    <label class="form-label">Prix</label>
                    <input type="number" name="prix" value="{{ old('prix', $bien->prix) }}" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
            </form>
        </div>
    </div>
@endsection
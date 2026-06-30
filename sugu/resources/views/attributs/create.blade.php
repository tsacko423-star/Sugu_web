@extends('layouts.admin')

@section('content')
<div class="container py-5 mt-5">
    <div class="card p-4">
        <h1 class="h3 mb-4">Ajouter un attribut</h1>

        <form action="{{ route('attributs.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" class="form-control" required>
                @error('nom')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Créer</button>
                <a href="{{ route('attributs.index') }}" class="btn btn-outline-dark">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection

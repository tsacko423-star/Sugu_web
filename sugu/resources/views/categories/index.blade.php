@extends('layouts.app')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="display-6">Liste des catégories</h1>
            <p class="text-secondary">Gérez les catégories de votre marketplace depuis l’espace admin.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="btn btn-luxe">
            <i class="bi bi-plus-circle me-2"></i>Ajouter une catégorie
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $categorie)
                        <tr>
                            <td>{{ $categorie->id }}</td>
                            <td>{{ $categorie->name }}</td>
                            <td class="d-flex flex-column gap-2">
                                <a href="{{ route('categories.edit', $categorie->id) }}" class="btn btn-outline-dark w-100">
                                    Modifier
                                </a>
                                <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

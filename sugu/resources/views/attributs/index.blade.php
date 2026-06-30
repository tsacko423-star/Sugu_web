@extends('layouts.admin')

@section('content')
<div class="container py-5 mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2">Liste des attributs</h1>
            <p class="text-secondary mb-0">Gérez les attributs disponibles pour les annonces.</p>
        </div>
        <a href="{{ route('attributs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un attribut
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attributs as $attribut)
                            <tr>
                                <td>{{ $attribut->id }}</td>
                                <td>{{ $attribut->nom }}</td>
                                <td>
                                    <form action="{{ route('attributs.destroy', $attribut->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet attribut ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-secondary py-4">
                                    Aucun attribut trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

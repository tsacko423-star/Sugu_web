@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h2 mb-2" style="color: var(--sugu-text);">Liste des categories</h1>
        <p class="mb-0" style="color: var(--sugu-text-muted);">Gerez les categories de votre marketplace depuis l'espace admin.</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn-primary-custom" style="white-space: nowrap;">
        <i class="bi bi-plus-circle me-2"></i>Ajouter une categorie
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="dashboard-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="color: var(--sugu-text);">
            <thead>
                <tr style="border-bottom: 1px solid var(--sugu-border);">
                    <th style="color: var(--sugu-text-muted);">ID</th>
                    <th style="color: var(--sugu-text-muted);">Nom</th>
                    <th style="color: var(--sugu-text-muted);">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $categorie)
                    <tr style="border-bottom: 1px solid var(--sugu-border);">
                        <td>{{ $categorie->id }}</td>
                        <td>{{ $categorie->name }}</td>
                        <td class="d-flex gap-2">
                            <a href="{{ route('categories.edit', $categorie->id) }}" class="btn-action edit" title="Modifier">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('categories.destroy', $categorie->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette categorie ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action delete" title="Supprimer">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-4" style="color: var(--sugu-text-muted);">
                            Aucune categorie pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

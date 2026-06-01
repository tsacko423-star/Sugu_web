@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h2 mb-2" style="color: var(--sugu-text);">Offres d'emploi</h1>
        <p class="mb-0" style="color: var(--sugu-text-muted);">Gérez vos offres d'emploi</p>
    </div>
    <a href="{{ route('emplois.create') }}" class="btn-primary-custom" style="white-space: nowrap;">
        <i class="bi bi-plus-circle me-2"></i> Créer une offre
    </a>
</div>

<div class="row g-4">
    @foreach($emplois as $emploi)
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card p-4 h-100 d-flex flex-column">
            <h5 class="card-title mb-2" style="color: var(--sugu-text);">{{ $emploi->titre }}</h5>
            <p class="mb-2" style="color: var(--sugu-text-muted);">
                <i class="bi bi-geo-alt"></i> {{ $emploi->ville }}
            </p>
            <p class="h5 mb-3" style="color: var(--sugu-accent);">{{ number_format($emploi->salaire, 0, ',', ' ') }} FCFA</p>

            <div class="d-flex gap-2 mt-auto">
                <a href="{{ route('emplois.edit', $emploi->id) }}" class="btn-outline-custom flex-grow-1">
                    <i class="bi bi-pencil"></i> Modifier
                </a>

                <form action="{{ route('emplois.destroy', $emploi->id) }}" method="POST" class="flex-grow-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-outline-custom w-100" style="border-color: var(--sugu-danger); color: var(--sugu-danger);">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
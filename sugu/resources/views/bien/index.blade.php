@extends('layouts.admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start mb-4">
    <div>
        <h1 class="h2 mb-2" style="color: var(--sugu-text);">Liste des biens immobiliers</h1>
        <p class="mb-0" style="color: var(--sugu-text-muted);">Gérez vos biens immobiliers</p>
    </div>
    <a href="{{ route('biens.create') }}" class="btn-primary-custom" style="white-space: nowrap;">
        <i class="bi bi-plus-circle me-2"></i> Ajouter un bien
    </a>
</div>

<div class="row g-4">
    @foreach($biens as $bien)
    @php
        $firstImage = is_array($bien->image) && count($bien->image) > 0 ? $bien->image[0] : null;
    @endphp
    <div class="col-md-6 col-lg-4">
        <div class="dashboard-card h-100">
            @if($firstImage)
                <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $bien->titre }}" style="height: 200px; object-fit: cover; width: 100%;">
            @else
                <div style="height: 200px; background: var(--sugu-bg-card); display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-building" style="font-size: 3rem; color: var(--sugu-text-muted);"></i>
                </div>
            @endif

            <div class="dashboard-card-body d-flex flex-column">
                <h5 class="card-title mb-2" style="color: var(--sugu-text);">{{ $bien->titre }}</h5>

                <p class="mb-2" style="color: var(--sugu-text-muted);">
                    <i class="bi bi-geo-alt"></i> {{ $bien->ville }}
                </p>

                <p class="h5 mb-3" style="color: var(--sugu-accent);">{{ number_format($bien->prix, 0, ',', ' ') }} FCFA</p>

                <div class="d-flex gap-2 mt-auto">
                    <a href="{{ route('biens.edit', $bien->id) }}" class="btn-outline-custom flex-grow-1">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>

                    <form action="{{ route('biens.destroy', $bien->id) }}" method="POST" class="flex-grow-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-outline-custom w-100" style="border-color: var(--sugu-danger); color: var(--sugu-danger);">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
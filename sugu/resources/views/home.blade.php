@extends('layouts.app')

@section('content')
<section class="hero">
    <div>
        <h1>Sugu Web</h1>
        <p>Plateforme moderne pour acheter, vendre et trouver un emploi</p>
        <a href="#annonces" class="btn btn-luxe mt-3">Explorer</a>
    </div>
</section>

<section class="search-section">
    <div class="container search-container">
        <div class="search-bar">
            <button class="hamburger-menu" type="button" id="resetFilters" title="Afficher toutes les annonces">
                <i class="bi bi-list"></i>
            </button>
            <div class="search-input-group">
                <form action="{{ route('search') }}" method="GET" style="width: 100%;" id="homeSearchForm">
                    <div style="position: relative;">
                        <i class="bi bi-search search-icon"></i>
                        <input type="search" name="q" id="homeSearchInput" class="search-input" placeholder="Rechercher une annonce sur SUGU-WEB" autocomplete="off">
                    </div>
                </form>
            </div>
        </div>

        <div class="categories-row">
            <a href="#annonces" class="category-link active" data-category-filter="all">Toutes</a>
            @if($categories->count() > 0)
                <span class="category-separator">•</span>
            @endif
            @foreach($categories as $category)
                <a href="#annonces" class="category-link" data-category-filter="{{ $category->id }}">{{ $category->name }}</a>
                @if(!$loop->last)
                    <span class="category-separator">•</span>
                @endif
            @endforeach
        </div>
    </div>
</section>

<section id="annonces" class="section container">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4">
        <h2 class="mb-0">Annonces récentes</h2>
        <p class="text-muted mb-0"><span id="visibleAnnonceCount">{{ $annonces->count() }}</span> annonce(s)</p>
    </div>

    <div class="row g-4" id="annoncesGrid">
        @forelse($annonces as $annonce)
            <div class="col-md-6 col-lg-4 annonce-item"
                 data-category-id="{{ $annonce->categorie_id }}"
                 data-search-text="{{ $annonce->titre }} {{ $annonce->description }} {{ $annonce->prix }} {{ $annonce->categorie->name ?? '' }}">
                <div class="card h-100">
                    @php
                        $firstImage = is_array($annonce->images) && count($annonce->images) > 0
                            ? $annonce->images[0]
                            : null;
                    @endphp

                    @if($firstImage)
                        <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $annonce->titre }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-{{ $annonce->categorie->icon ?? 'tag' }}" style="font-size: 3rem; color: #6c757d;"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $annonce->titre }}</h5>
                        <p class="card-text text-truncate">{{ $annonce->description }}</p>
                        <div class="mt-auto">
                            <p class="h5 text-primary mb-2">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</p>
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <span class="badge bg-secondary">{{ ucfirst($annonce->categorie->name ?? 'Annonce') }}</span>
                                <div class="d-flex gap-2">
                                    
                                    <a href="{{ route('annonces.show', $annonce->id) }}#contact-vendeur" class="btn btn-luxe btn-sm">
                                        <i class="bi bi-envelope"></i> Contacter
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted mb-0">Aucune annonce disponible pour le moment.</p>
            </div>
        @endforelse
    </div>

    <div class="text-center py-5 d-none" id="noAnnonceResult">
        <i class="bi bi-search" style="font-size: 3rem; color: #6c757d;"></i>
        <h3 class="mt-3 text-muted">Aucune annonce trouvée</h3>
        <p class="text-muted mb-0">Essayez une autre catégorie ou une autre recherche.</p>
    </div>
</section>
@endsection

@push('styles')
<style>
    .category-link.active {
        color: var(--gold-accent, #f5c518);
        font-weight: 700;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('homeSearchForm');
    const searchInput = document.getElementById('homeSearchInput');
    const categoryLinks = document.querySelectorAll('[data-category-filter]');
    const annonceItems = document.querySelectorAll('.annonce-item');
    const visibleCount = document.getElementById('visibleAnnonceCount');
    const noResult = document.getElementById('noAnnonceResult');
    const resetFilters = document.getElementById('resetFilters');
    let activeCategory = 'all';

    const normalize = (value) => value
        .toString()
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();

    function applyFilters() {
        const query = normalize(searchInput.value);
        let count = 0;

        annonceItems.forEach((item) => {
            const sameCategory = activeCategory === 'all' || item.dataset.categoryId === activeCategory;
            const text = normalize(item.dataset.searchText || '');
            const matchSearch = !query || text.includes(query);
            const shouldShow = sameCategory && matchSearch;

            item.classList.toggle('d-none', !shouldShow);
            if (shouldShow) {
                count++;
            }
        });

        visibleCount.textContent = count;
        noResult.classList.toggle('d-none', count > 0 || annonceItems.length === 0);
    }

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();
        applyFilters();
    });

    searchInput.addEventListener('input', applyFilters);

    categoryLinks.forEach((link) => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            activeCategory = this.dataset.categoryFilter;

            categoryLinks.forEach((categoryLink) => categoryLink.classList.remove('active'));
            this.classList.add('active');

            applyFilters();
            document.getElementById('annonces').scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });

    resetFilters.addEventListener('click', function () {
        activeCategory = 'all';
        searchInput.value = '';
        categoryLinks.forEach((categoryLink) => {
            categoryLink.classList.toggle('active', categoryLink.dataset.categoryFilter === 'all');
        });
        applyFilters();
    });
});
</script>
@endpush

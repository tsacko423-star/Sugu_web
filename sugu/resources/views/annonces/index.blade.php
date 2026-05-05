<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des annonces</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>Liste des annonces</h1>
                <p class="text-muted mb-0">Ajouter directement une nouvelle annonce.</p>
            </div>
            <div>
                <a href="{{ route('annonces.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer une annonce
                </a>
            </div>
        </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($annonces->count() > 0)
        <div class="row g-4">
            @foreach($annonces as $annonce)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100">
                    @if(data_get($annonce, 'image_url'))
                        <img src="{{ data_get($annonce, 'image_url') }}" class="card-img-top" alt="{{ $annonce->titre }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            @php $categorieName = strtolower($annonce->categorie->name ?? 'autre'); @endphp
                            <i class="bi bi-{{ $categorieName === 'emploi' ? 'briefcase' : ($categorieName === 'voiture' ? 'car-front' : 'house') }}" style="font-size: 3rem; color: #6c757d;"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $annonce->titre }}</h5>

                        <p class="card-text text-truncate">{{ $annonce->description }}</p>

                        <div class="mt-auto">
                            <p class="h5 text-primary mb-2">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-secondary">{{ ucfirst($annonce->categorie->name ?? 'Annonce') }}</span>
                                </a>
                                <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-info-circle" style="font-size: 3rem; color: #6c757d;"></i>
            <h3 class="mt-3 text-muted">Aucune annonce trouvée</h3>
            <p class="text-muted">Soyez le premier à publier une annonce !</p>
            <a href="{{ route('annonces.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Créer la première annonce
            </a>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
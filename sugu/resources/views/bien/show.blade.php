<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $bien->titre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="mb-0">{{ $bien->titre }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    @if($bien->image_url)
                        <img src="{{ $bien->image_url }}" alt="{{ $bien->titre }}" class="img-fluid mb-3 rounded">
                    @endif

                    <h5 class="text-muted">Description</h5>
                    <p class="card-text">{{ $bien->description }}</p>

                    <h5 class="text-muted mt-4">Prix</h5>
                    <p class="h4 text-primary">{{ number_format($bien->prix, 0, ',', ' ') }} FCFA</p>

                    <h5 class="text-muted mt-4">Détails</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Type:</strong> {{ $bien->type ?? 'Non spécifié' }}</p>
                            <p><strong>Localisation:</strong> {{ $bien->localisation ?? 'Non spécifiée' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Publié par:</strong> {{ $bien->user->name }}</p>
                            <p><strong>Date de publication:</strong> {{ $bien->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('biens.edit', $bien->id) }}" class="btn btn-warning">Modifier</a>

                        <form action="{{ route('biens.destroy', $bien->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bien ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Supprimer</button>
                        </form>

                        <a href="{{ route('annonces.index') }}" class="btn btn-secondary">Retour à la liste</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
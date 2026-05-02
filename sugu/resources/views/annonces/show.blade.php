<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $annonce->titre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="mb-0">{{ $annonce->titre }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="text-muted">Description</h5>
                    <p class="card-text">{{ $annonce->description }}</p>

                    <h5 class="text-muted mt-4">Prix</h5>
                    <p class="h4 text-primary">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</p>

                    <h5 class="text-muted mt-4">Catégorie</h5>
                    <p><span class="badge bg-secondary">{{ $annonce->categorie->name }}</span></p>

                    <h5 class="text-muted mt-4">Publié par</h5>
                    <p>{{ $annonce->user->name }}</p>

                    <h5 class="text-muted mt-4">Date de publication</h5>
                    <p>{{ $annonce->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                <div class="col-md-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn btn-warning">Modifier</a>

                        <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">
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

    @if($annonce->attributs->count() > 0)
    <div class="card shadow mt-4">
        <div class="card-header">
            <h5 class="mb-0">Caractéristiques supplémentaires</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($annonce->attributs as $attribut)
                <div class="col-md-6 mb-3">
                    <strong>{{ $attribut->nom }}:</strong> {{ $attribut->valeur }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $voiture->marque }} {{ $voiture->modele }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header">
            <h2 class="mb-0">{{ $voiture->marque }} {{ $voiture->modele }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    @if($voiture->image)
                        <img src="{{ asset('storage/' . $voiture->image) }}" alt="{{ $voiture->marque }} {{ $voiture->modele }}" class="img-fluid mb-3 rounded">
                    @endif

                    <h5 class="text-muted">Détails</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Marque:</strong> {{ $voiture->marque }}</p>
                            <p><strong>Modèle:</strong> {{ $voiture->modele }}</p>
                            <p><strong>Année:</strong> {{ $voiture->annee }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Prix:</strong> {{ number_format($voiture->prix, 0, ',', ' ') }} FCFA</p>
                            <p><strong>Publié par:</strong> {{ $voiture->user->name }}</p>
                            <p><strong>Date de publication:</strong> {{ $voiture->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('voitures.edit', $voiture->id) }}" class="btn btn-warning">Modifier</a>

                        <form action="{{ route('voitures.destroy', $voiture->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette voiture ?')">
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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un bien</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Modifier un bien</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

<form  enctype="multipart/form-data" action="{{ route('biens.update', $bien->id) }}" method="POST">
    @csrf
    @method('PUT')
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" value="{{ old('titre', $bien->titre) }}" class="form-control" placeholder="Ex: Maison, Terrain..." required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ville</label>
                <input type="text" name="ville" value="{{ old('ville', $bien->ville) }}" class="form-control" placeholder="Ex: Bamako" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix</label>
                <input type="number" name="prix" value="{{ old('prix', $bien->prix) }}" class="form-control" placeholder="Ex: 10000000" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Images</label>
                <input type="file" name="image[]" class="form-control" multiple>
                <small class="text-muted">Vous pouvez sélectionner plusieurs images</small>
            </div>

            <button type="submit" class="btn btn-primary w-100">Modifier</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
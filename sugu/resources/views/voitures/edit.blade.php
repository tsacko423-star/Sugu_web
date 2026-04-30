<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une voiture</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Modifier une voiture</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

       <form enctype="multipart/form-data" action="{{ route('voitures.update', $voiture->id) }}" method="POST">
    @csrf
    @method('PUT')

            <div class="mb-3">
                <label class="form-label">Marque</label>
                <input type="text" name="marque" class="form-control" placeholder="Ex: Toyota" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Modèle</label>
                <input type="text" name="modele" class="form-control" placeholder="Ex: Corolla" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Année</label>
                <input type="number" name="annee" class="form-control" placeholder="Ex: 2020" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Prix</label>
                <input type="number" name="prix" class="form-control" placeholder="Ex: 5000000" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Modifier</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
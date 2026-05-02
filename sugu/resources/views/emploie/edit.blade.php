<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un emploi</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h2 class="text-center mb-4">Modifier un emploi</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

          <form action="{{ route('emplois.update', $emploi->id) }}" method="POST">
    @csrf
    @method('PUT')
            <div class="mb-3">
                <label class="form-label">Titre</label>
                <input type="text" name="titre" value="{{ old('titre', $emploi->titre) }}" class="form-control" placeholder="Ex: Développeur Web" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ville</label>
                <input type="text" name="ville" value="{{ old('ville', $emploi->ville) }}" class="form-control" placeholder="Ex: Bamako" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Décrire le poste..." required>{{ old('description', $emploi->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Salaire</label>
                <input type="number" name="salaire" value="{{ old('salaire', $emploi->salaire) }}" class="form-control" step="0.01" placeholder="Ex: 150000" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Modifié</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
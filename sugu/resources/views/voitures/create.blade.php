<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une voiture</title>
</head>
<body>

<h2>Ajouter une voiture</h2>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form action="{{ route('voitures.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="marque" placeholder="Marque" required><br><br>
    <input type="text" name="modele" placeholder="Modèle" required><br><br>
    <input type="number" name="annee" placeholder="Année" required><br><br>
    <input type="number" name="prix" placeholder="Prix" required><br><br>
    <input type="file" name="image" required><br><br>

    <button type="submit">Ajouter</button>
</form>

</body>
</html>
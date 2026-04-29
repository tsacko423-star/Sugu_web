<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Ajouter un bien</h2>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif

    <form method="POST" enctype="multipart/form-data" action="{{ route('bien.store') }}">
        @csrf

        <input type="text" name="type" placeholder="Type" required><br><br>
        <input type="text" name="ville" placeholder="Ville" required><br><br>
        <input type="number" name="prix" placeholder="Prix" required><br><br>
        <input type="file" name="image" multiple><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
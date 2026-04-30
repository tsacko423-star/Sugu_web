<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des emplois</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .btn-luxe {
            background-color: #000;
            color: #fff;
            border-radius: 20px;
        }
        .btn-luxe:hover {
            background-color: #333;
        }
    </style>
</head>

<body class="bg-light">

<div class="container py-5">
    <h1 class="text-center mb-4">Liste des emplois</h1>
    <h2 class="mb-4">Offres d'emploi</h2>

    <div class="row g-4">
        @foreach($emplois as $emploi)
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $emploi->titre }}</h5>
                    <p class="card-text">
                        {{ $emploi->ville }} <br>
                        <strong>{{ $emploi->salaire }} FCFA</strong>
                    </p>

                    <button class="btn btn-luxe w-100 mb-2">Postuler</button>

                    <!-- Actions -->
                    <a href="{{ route('emplois.edit', $emploi->id) }}" class="btn btn-warning w-100 mb-2">
                        Modifier
                    </a>

                    <form action="{{ route('emplois.destroy', $emploi->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            Supprimer
                        </button>
                    </form>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
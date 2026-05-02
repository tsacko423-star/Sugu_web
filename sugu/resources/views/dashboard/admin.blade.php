<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap -->
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

        .card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Dashboard</span>
        <span class="text-white">👤 {{ Auth::user()->name }}</span>
    </div>
</nav>

<div class="container py-5">

    <h2 class="mb-4">Bienvenue 👋</h2>

    <!-- UTILISATEURS -->
    <div class="mb-5">
        <h3>Utilisateurs</h3>
        @foreach($users as $user)
            <span class="badge bg-primary me-2">{{ $user->name }}</span>
        @endforeach
    </div>

    <!-- BIENS -->
    <h3 class="mb-3">🏠 Biens immobiliers</h3>
    <div class="row g-4 mb-5">
        @foreach($biens as $bien)
        <div class="col-md-4">
            <div class="card shadow-sm h-100">

                @if($bien->image)
                    <img src="{{ asset('storage/' . $bien->image) }}" class="card-img-top">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5>{{ $bien->titre }}</h5>
                    <p><strong>{{ $bien->prix }} FCFA</strong><br>{{ $bien->ville }}</p>

                    <a href="{{ route('biens.edit', $bien->id) }}" class="btn btn-warning w-100 mb-2">
                        Modifier
                    </a>

                    <form action="{{ route('biens.destroy', $bien->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger w-100">Supprimer</button>
                    </form>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <!-- VOITURES -->
    <h3 class="mb-3">🚗 Voitures</h3>
    <div class="row g-4 mb-5">
        @foreach($voitures as $voiture)
        <div class="col-md-4">
            <div class="card shadow-sm h-100">

                @if($voiture->image)
                    <img src="{{ asset('storage/' . $voiture->image) }}" class="card-img-top">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5>{{ $voiture->marque }} {{ $voiture->modele }}</h5>
                    <p><strong>{{ $voiture->prix }} FCFA</strong></p>

                    <a href="{{ route('voitures.edit', $voiture->id) }}" class="btn btn-warning w-100 mb-2">
                        Modifier
                    </a>

                    <form action="{{ route('voitures.destroy', $voiture->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger w-100">Supprimer</button>
                    </form>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <!-- EMPLOIS -->
    <h3 class="mb-3">💼 Offres d'emploi</h3>
    <div class="row g-4">
        @foreach($emplois as $emploi)
        <div class="col-md-4">
            <div class="card shadow-sm h-100 p-3">
                <h5>{{ $emploi->titre }}</h5>
                <p>{{ $emploi->ville }} - <strong>{{ $emploi->salaire }} FCFA</strong></p>

                <a href="{{ route('emplois.edit', $emploi->id) }}" class="btn btn-warning w-100 mb-2">
                    Modifier
                </a>

                <form action="{{ route('emplois.destroy', $emploi->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-100">Supprimer</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
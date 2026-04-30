<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des voitures</title>

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

        .card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>

<body class="bg-light">

<div class="container py-5">
    <h1 class="text-center mb-4">Liste des voitures</h1>
    <h2 class="mb-4">Voitures disponibles</h2>

    <div class="row g-4">
        @foreach($voitures as $voiture)
        <div class="col-md-4">
            <div class="card shadow-sm h-100">

                @if($voiture->image)
                    <img src="{{ asset('storage/' . $voiture->image) }}" 
                         class="card-img-top" 
                         alt="{{ $voiture->marque }} {{ $voiture->modele }}">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        {{ $voiture->marque }} {{ $voiture->modele }}
                    </h5>

                    <p class="card-text">
                        <strong>{{ $voiture->prix }} FCFA</strong>
                    </p>

                    <button class="btn btn-luxe w-100 mb-2">
                        Contacter
                    </button>

                    <!-- Actions -->
                    <a href="{{ route('voitures.edit', $voiture->id) }}" 
                       class="btn btn-warning w-100 mb-2">
                        Modifier
                    </a>

                    <form action="{{ route('voitures.destroy', $voiture->id) }}" method="POST">
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
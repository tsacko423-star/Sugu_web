<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biens immobiliers</title>

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

<div class="container py-5">
    <h1 class="text-center mb-4">Liste des biens</h1>
    <h2 class="mb-4">Biens immobiliers</h2>

    <div class="row g-4">
        @foreach($biens as $bien)
        <div class="col-md-4">
            <div class="card shadow-sm h-100">

                @php
                    $bienImage = $bien->image;
                    $bienImageArray = json_decode($bienImage, true);
                    $imagePath = is_array($bienImageArray) ? ($bienImageArray[0] ?? null) : $bienImage;
                @endphp
                @if($imagePath)
                    <img src="{{ asset('storage/' . $imagePath) }}" 
                         class="card-img-top"
                         alt="{{ $bien->titre }}">
                @endif

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $bien->titre }}</h5>

                    <p class="card-text">
                        <strong>{{ $bien->prix }} FCFA</strong><br>
                        {{ $bien->ville }}
                    </p>

                    <button class="btn btn-luxe w-100 mb-2">
                        Contacter
                    </button>

                    <!-- Actions -->
                    <a href="{{ route('biens.edit', $bien->id) }}" 
                       class="btn btn-warning w-100 mb-2">
                        Modifier
                    </a>

                    <form action="{{ route('biens.destroy', $bien->id) }}" method="POST">
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
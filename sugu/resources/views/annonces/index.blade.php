<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"><style></style></style>
</head>
<body>
   
<div class="container py-5">
    <h2 class="text-center mb-5">Publier une annonce</h2>

    <div class="row g-4">

        <!-- Voiture -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h1>🚗</h1>
                    <h5 class="card-title">Voiture</h5>
                    <p class="card-text">Publiez votre véhicule rapidement</p>
                    <a href="{{ route('voitures.create') }}" class="btn btn-primary">
                        Publier
                    </a>
                </div>
            </div>
        </div>

        <!-- Immobilier -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h1>🏠</h1>
                    <h5 class="card-title">Immobilier</h5>
                    <p class="card-text">Vente ou location de biens</p>
                    <a href="{{ route('bien.create') }}" class="btn btn-success">
                        Publier
                    </a>
                </div>
            </div>
        </div>

        <!-- Service -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body">
                    <h1>💼</h1>
                    <h5 class="card-title">Service / Emploi</h5>
                    <p class="card-text">Proposez vos services ou offres</p>
                    <a href="{{ route('emploie.create') }}" class="btn btn-warning">
                        Publier
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
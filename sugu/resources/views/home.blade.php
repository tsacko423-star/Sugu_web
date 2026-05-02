<!DOCTYPE html><html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sugu Web </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"><style>
body {
    background: #262222;
    color: #f5f5f3;
    font-family: 'Poppins', sans-serif;
}

h1, h2, h3, h5 {
    font-family: 'Playfair Display', serif;
}

.navbar {
    background: rgba(0,0,0,0.85);
    backdrop-filter: blur(10px);
}

.nav-link {
    color: #fff !important;
    transition: 0.3s;
}

.nav-link:hover {
    color: gold !important;
}

.hero {
    height: 100vh;
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c') center/cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.hero h1 {
    font-size: 60px;
    font-weight: 700;
}

.hero p {
    font-size: 18px;
    color: #ccc;
}

.btn-luxe {
    background: gold;
    color: #000;
    border-radius: 30px;
    padding: 10px 25px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-luxe:hover {
    background: #fff;
}

.section {
    padding: 80px 0;
}

.section h2 {
    border-left: 5px solid gold;
    padding-left: 15px;
    margin-bottom: 40px;
}

.card {
    background: #111;
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: 0.4s;
    box-shadow: 0 0 15px rgba(255,215,0,0.1);
}

.card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 0 25px rgba(255,215,0,0.3);
}

.card img {
    width: 100%;
    height: 230px;
    object-fit: cover;
}

.card-body h5 {
    font-size: 20px;
}

.card-body p {
    color: #bbb;
}

footer {
    background: #000;
    padding: 40px;
    text-align: center;
    color: #aaa;
}
</style></head><body><nav class="navbar navbar-expand-lg fixed-top">
<div class="container">
<a class="navbar-brand text-white fw-bold" href="#">Sugu Web</a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
<span class="navbar-toggler-icon" style="filter: invert(1);"></span>
</button><div class="collapse navbar-collapse" id="menu">
<ul class="navbar-nav ms-auto">
<li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
<li class="nav-item"><a class="nav-link" href="#immobilier">Immobilier</a></li>
<li class="nav-item"><a class="nav-link" href="#voitures">Voitures</a></li>
<li class="nav-item"><a class="nav-link" href="#emploi">Emplois</a></li>
<div class="dropdown">
  <button class="btn btn-dark rounded-circle" type="button" data-bs-toggle="dropdown">
    <i class="bi bi-person"></i>
  </button>

  <ul class="dropdown-menu dropdown-menu-end">
     <li ><a href="{{ route('register') }}"class="dropdown-item">Register</a></li>
     <li ><a href="{{ route('login') }}"class="dropdown-item">Login</a></li>
 </ul>
</div>
   <a href="{{ route('annonces.index') }}"
    class="btn btn-dark rounded-pill d-flex align-items-center px-3 py-2">
    <i class="bi bi-plus" style="font-size: 24px; color: white;"></i>
    <span class="ms-1">Publier</span>
</a>
</ul>
</div>
</div>
</nav><section class="hero">
<div>
<h1>Sugu Web</h1>
<p>Plateforme moderne pour acheter, vendre et trouver un emploi</p>
<a href="#immobilier" class="btn btn-luxe mt-3">Explorer</a>
</div>
</section><section id="immobilier" class="section container">
<h2>Immobilier</h2>
<div class="row g-4">
@foreach($biens as $bien)
<div class="col-md-4">
    <div class="card">
        @if($bien->image_url)
            <img src="{{ $bien->image_url }}" alt="{{ $bien->titre }}">
        @endif
        <div class="card-body">
            <h5>{{ $bien->titre }}</h5>
            <p>{{ $bien->prix }} FCFA - {{ $bien->ville }}</p>
            <button class="btn btn-luxe">Contacter</button>
        </div>
    </div>
</div>
@endforeach
</div>
<button class="btn btn-luxe">Contacter</button>
</div>
</div>
</div></div>
</section><section id="voitures" class="section container">
<h2>Voitures</h2>
<div class="row g-4">
@foreach($voitures as $voiture)
<div class="col-md-4">
    <div class="card">
        @if($voiture->image)
            <img src="{{ asset('storage/' . $voiture->image) }}" alt="{{ $voiture->marque }} {{ $voiture->modele }}">
        @endif
        <div class="card-body">
            <h5>{{ $voiture->marque }} {{ $voiture->modele }}</h5>
            <p>{{ $voiture->prix }} FCFA</p>
            <button class="btn btn-luxe">Contacter</button>
        </div>
    </div>
</div>
@endforeach
</div>
<button class="btn btn-luxe">Contacter</button>
</div>
</div>
</div></div>
</section><section id="emploi" class="section container">
<h2>Offres d'emploi</h2>
<div class="row g-4">
@foreach($emplois as $emploi)
<div class="col-md-4">
    <div class="card p-3">
        <h5>{{ $emploi->titre }}</h5>
        <p>{{ $emploi->ville }} - {{ $emploi->salaire }} FCFA</p>
        <button class="btn btn-luxe">Postuler</button>
    </div>
</div>
@endforeach
</div>
<button class="btn btn-luxe">Postuler</button>
</div>
</div></div>
</section><footer>
<p>© 2026 Sugu Web |</p>
</footer><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script></body>
</html>
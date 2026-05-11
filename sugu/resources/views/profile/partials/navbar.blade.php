<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">Sugu Web</a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('annonces.index') }}">Annonces</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#voitures">Voitures</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#emploi">Emplois</a></li>
            </ul>
        </div>
    </div>
</nav>

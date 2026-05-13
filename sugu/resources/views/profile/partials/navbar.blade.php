
<nav class="navbar navbar-expand-lg fixed-top sugu-navbar">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">Sugu Web</a>
         <div class="navbar-actions">
                <a href="{{ route('annonces.create') }}" class="d-flex align-items-center navbar-action navbar-action-primary" title="Publier une annonce">
                    <i class="bi bi-plus-circle"></i>
                    <span>Publier</span>
                </a>

                @guest
                    <a href="{{ route('login') }}" class="d-flex align-items-center navbar-action" title="Se connecter">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="d-flex align-items-center navbar-action" title="Créer un compte">
                        <i class="bi bi-person-plus"></i>
                        <span>Inscription</span>
                    </a>
                @endguest

                @auth
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center navbar-action" title="Tableau de bord">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="d-flex align-items-center navbar-action" title="Se déconnecter">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                @endauth
            </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav mx-lg-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('annonces.index') }}">Annonces</a>
                </li>
            </ul>

           
        </div>
    </div>
</nav>



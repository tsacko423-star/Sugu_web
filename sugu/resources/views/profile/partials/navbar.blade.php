
<nav class="navbar navbar-expand-lg fixed-top sugu-navbar">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ route('home') }}">Sugu Web</a>

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
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messages.inbox') }}">Messages reçus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messages.sent') }}">Messages envoyés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#contactAdminModal">Contacter Admin</a>
                    </li>
                @endauth
            </ul>

            <div class="navbar-actions ms-lg-auto">
                <a href="{{ route('annonces.create') }}" class="navbar-action navbar-action-primary" title="Publier une annonce">
                    <i class="bi bi-plus-circle me-2"></i>
                    <span>Publier</span>
                </a>

                @guest
                    <a href="{{ route('login') }}" class="navbar-action navbar-action-secondary" title="Se connecter">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        <span>Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="navbar-action navbar-action-secondary" title="Créer un compte">
                        <i class="bi bi-person-plus me-2"></i>
                        <span>Inscription</span>
                    </a>
                @endguest

                @auth
                    <a href="{{ route('messages.inbox') }}" class="navbar-action navbar-action-secondary" title="Messages reçus">
                        <i class="bi bi-chat-dots me-2"></i>
                        <span>Messages</span>
                    </a>
                    <a href="{{ route('dashboard') }}" class="navbar-action navbar-action-secondary" title="Tableau de bord">
                        <i class="bi bi-speedometer2 me-2"></i>
                        <span>Dashboard</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 d-inline">
                        @csrf
                        <button type="submit" class="navbar-action navbar-action-danger" title="Se déconnecter">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Contact Admin Modal -->
@auth
<div class="modal fade" id="contactAdminModal" tabindex="-1" aria-labelledby="contactAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactAdminModalLabel">Contacter l'Administrateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('message.send-to-admin') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Votre message</label>
                        <textarea name="contenu" class="form-control" id="contenu" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth


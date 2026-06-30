<nav class="navbar fixed-top sugu-navbar">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="brand-icon"><i class="bi bi-bag-check-fill"></i></span>
            <span class="brand-text">Sugu<span class="brand-accent">Web</span></span>
        </a>

        {{-- Navigation Content --}}
        <div class="navbar-content">
            {{-- All Navigation Items in One Row --}}
            <div class="nav-actions">
                {{-- Navigation Links as Buttons --}}
                <a href="{{ route('home') }}" class="nav-btn nav-btn-secondary {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Accueil</span>
                </a>
                <a href="{{ route('annonces.index') }}" class="nav-btn nav-btn-secondary {{ request()->routeIs('annonces.*') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i>
                    <span>Annonces</span>
                </a>

                @auth
                    {{-- Messages Dropdown --}}
                    <div class="dropdown">
                        <button class="nav-btn nav-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-chat-left-text"></i>
                            <span>Messages</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item" href="{{ route('messages.inbox') }}">
                                    <i class="bi bi-inbox"></i> Reçus
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('messages.sent') }}">
                                    <i class="bi bi-send"></i> Envoyés
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#contactAdminModal">
                                    <i class="bi bi-headset"></i> Contacter Admin
                                </a>
                            </li>
                        </ul>
                    </div>
                @endauth

                {{-- Publish Button --}}
                <a href="{{ route('annonces.create') }}" class="nav-btn nav-btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    <span>Publier</span>
                </a>

                @guest
                    {{-- Guest Actions --}}
                    <a href="{{ route('login') }}" class="nav-btn nav-btn-secondary">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="nav-btn nav-btn-secondary d-none d-sm-inline-flex">
                        <i class="bi bi-person-plus"></i>
                        <span>Inscription</span>
                    </a>
                @endguest

                @auth
                    {{-- User Dropdown --}}
                    <div class="dropdown">
                        <button class="nav-user-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-user-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <span class="nav-user-name d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear"></i> Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

{{-- Contact Admin Modal --}}
@auth
<div class="modal fade" id="contactAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-headset me-2"></i>Contacter l'Administrateur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('message.send-to-admin') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contenu" class="form-label">Votre message</label>
                        <textarea name="contenu" class="form-control" id="contenu" rows="4" required
                                  placeholder="Décrivez votre problème ou votre demande..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i> Envoyer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth

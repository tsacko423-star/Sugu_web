<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="{{ url('/') }}">Sugu Web</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#immobilier">Immobilier</a></li>
                <li class="nav-item"><a class="nav-link" href="#voitures">Voitures</a></li>
                <li class="nav-item"><a class="nav-link" href="#emploi">Emplois</a></li>
                <li class="nav-item">
                    <a href="{{ route('annonces.index') }}" class="btn btn-dark rounded-pill d-flex align-items-center px-3 py-2 ms-3">
                        <i class="bi bi-plus" style="font-size: 24px; color: white;"></i>
                        <span class="ms-1">Publier</span>
                    </a>
                </li>
                <li class="nav-item dropdown ms-3">
                    <button class="btn btn-dark rounded-circle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if (Auth::check())
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        @else
                            <li><a href="{{ route('register') }}" class="dropdown-item">Register</a></li>
                            <li><a href="{{ route('login') }}" class="dropdown-item">Login</a></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

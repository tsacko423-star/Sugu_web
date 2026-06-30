<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'SUGU-WEB'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/sugu-style.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-logo">S</div>
            <div class="sidebar-brand-text">SUGU<span>-WEB</span></div>
        </div>

        <div class="sidebar-user">
            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=f97316&color=fff&size=80' }}" alt="Avatar" class="sidebar-user-avatar">
            <div class="sidebar-user-name">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
            <div class="sidebar-user-email">{{ auth()->user()->email ?? 'user@email.com' }}</div>
        </div>

        <nav class="sidebar-nav">
            @hasSection('sidebar_nav')
                @yield('sidebar_nav')
            @else
                <div class="nav-section-title">Navigation</div>
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    <span>Accueil</span>
                </a>
                <a href="{{ route('annonces.index') }}" class="nav-link {{ request()->routeIs('annonces.*') ? 'active' : '' }}">
                    <i class="bi bi-megaphone-fill"></i>
                    <span>Mes annonces</span>
                </a>
                <a href="{{ route('annonces.create') }}" class="nav-link {{ request()->routeIs('annonces.create') ? 'active' : '' }}">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Ajouter une annonce</span>
                </a>

                <div class="nav-section-title mt-3">Compte</div>
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="bi bi-person-fill"></i>
                    <span>Mon profil</span>
                </a>
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i>
                    <span>Déconnexion</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            @endif
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="search-box d-none d-md-block">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Rechercher...">
                    </div>
                </div>

                <div class="navbar-actions">
                    <button class="navbar-btn" title="Messages" onclick="location.href='{{ route('messages.inbox') }}'">
                        <i class="bi bi-chat-dots"></i>
                        <span class="notification-badge">{{ $unreadMessages ?? 0 }}</span>
                    </button>
                    <button class="navbar-btn" title="Notifications" onclick="location.href='{{ route('dashboard') }}'">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">{{ $unreadNotifications ?? 0 }}</span>
                    </button>
                    <div class="dropdown">
                        <div class="user-profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=f97316&color=fff' }}" alt="Avatar" class="user-avatar-sm">
                            <span class="user-name-sm d-none d-sm-inline">{{ auth()->user()->name ?? 'Utilisateur' }}</span>
                            <i class="bi bi-chevron-down" style="font-size:0.7rem; color:var(--sugu-text-muted);"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end" style="background: var(--sugu-bg-card); border-color: var(--sugu-border);">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}" style="color: var(--sugu-text-muted);"><i class="bi bi-person me-2"></i>Mon profil</a></li>
                            <li><hr class="dropdown-divider" style="border-color: var(--sugu-border);"></li>
                            <li>
                                <a class="dropdown-item" href="#" style="color: var(--sugu-danger);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-left me-2"></i>Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="page-content">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });

        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

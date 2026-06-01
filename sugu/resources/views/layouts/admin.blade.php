
        <style>
        .custom-table thead th {
            .custom-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }
        }
        </style>

        @stack('styles')
    </head>
    <body>
        @extends('layouts.dashboard')

        @section('title', 'Admin - ' . config('app.name', 'SUGU-WEB'))

        @section('content')
            @yield('content')
        @endsection

        @stack('scripts')
    </body>
    </html>
        <style>
        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .activity-icon.new-user {
            background: rgba(59, 130, 246, 0.2);
            color: var(--sugu-info);
        }

        .activity-icon.new-annonce {
            background: rgba(16, 185, 129, 0.2);
            color: var(--sugu-success);
        }

        .activity-icon.payment {
            background: rgba(249, 115, 22, 0.2);
            color: var(--sugu-accent);
        }

        .activity-content h6 {
            font-size: 0.9375rem;
            font-weight: 500;
            color: var(--sugu-text);
            margin-bottom: 0.25rem;
        }

        .activity-content p {
            font-size: 0.8125rem;
            color: var(--sugu-text-muted);
            margin-bottom: 0;
        }

        .activity-time {
            font-size: 0.75rem;
            color: var(--sugu-text-muted);
            margin-left: auto;
            flex-shrink: 0;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action.edit {
            background: rgba(59, 130, 246, 0.2);
            color: var(--sugu-info);
        }

        .btn-action.edit:hover {
            background: var(--sugu-info);
            color: white;
        }

        .btn-action.delete {
            background: rgba(239, 68, 68, 0.2);
            color: var(--sugu-danger);
        }

        .btn-action.delete:hover {
            background: var(--sugu-danger);
            color: white;
        }

        .btn-action.view {
            background: rgba(16, 185, 129, 0.2);
            color: var(--sugu-success);
        }

        .btn-action.view:hover {
            background: var(--sugu-success);
            color: white;
        }

        .btn-primary-custom {
            background: var(--sugu-accent);
            border: none;
            color: white;
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background: var(--sugu-accent-hover);
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--sugu-border);
            color: var(--sugu-text-muted);
            padding: 0.625rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-outline-custom:hover {
            border-color: var(--sugu-accent);
            color: var(--sugu-accent);
        }

        .sidebar-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            color: var(--sugu-text-muted);
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 230px;
                width: calc(100% - 260px);
                padding: 20px;
            }

            .sidebar-toggle {
                display: flex;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 575.98px) {
            .page-content {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .admin-info {
                display: none;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--sugu-bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--sugu-border);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--sugu-secondary);
        }

        .chart-container {
            position: relative;
            height: 300px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-logo">S</div>
            <div class="sidebar-brand-text">SUGU<span>-WEB</span></div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Menu Principal</div>

            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-collection-fill"></i>
                <span>Gestion des catégories</span>
            </a>

            <a href="{{ route('annonces.index') }}" class="nav-link {{ request()->routeIs('annonces.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill"></i>
                <span>Gestion des annonces</span>
            </a>

            <a href="{{ route('messages.inbox') }}" class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-fill"></i>
                <span>Messages reçus</span>
            </a>

            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <i class="bi bi-people-fill"></i>
                <span>Utilisateurs</span>
            </a>

            <div class="nav-section-title mt-4">Configuration</div>

            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i>
                <span>Déconnexion</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>
    </aside>

    <div class="main-content">
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
                    <a href="{{ route('messages.inbox') }}" class="navbar-btn" title="Messages" aria-label="Messages">
                        <i class="bi bi-envelope"></i>
                        <span class="notification-badge">3</span>
                    </a>

                    <a href="{{ route('admin.dashboard') }}" class="navbar-btn" title="Notifications" aria-label="Notifications">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">5</span>
                    </a>

                    <div class="dropdown">
                        <div class="admin-profile" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('images/admin-avatar.jpg') }}" alt="Admin" class="admin-avatar" onerror="this.src='https://ui-avatars.com/api/?name=Admin&background=f97316&color=fff'">
                            <div class="admin-info">
                                <span class="admin-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <span class="admin-role">Administrateur</span>
                            </div>
                            <i class="bi bi-chevron-down ms-2" style="font-size: 0.75rem; color: var(--sugu-text-muted);"></i>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end" style="background: var(--sugu-bg-card); border-color: var(--sugu-border);">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}" style="color: var(--sugu-text-muted);"><i class="bi bi-person me-2"></i>Mon profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}" style="color: var(--sugu-text-muted);"><i class="bi bi-gear me-2"></i>Paramètres</a></li>
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

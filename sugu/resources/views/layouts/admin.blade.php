<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SUGU-WEB Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --sugu-primary: #1e3a5f;
            --sugu-primary-dark: #0f1f33;
            --sugu-secondary: #2d5a87;
            --sugu-accent: #f97316;
            --sugu-accent-hover: #ea580c;
            --sugu-bg-dark: #0a0f1a;
            --sugu-bg-card: #111827;
            --sugu-bg-sidebar: #0d1421;
            --sugu-border: #1f2937;
            --sugu-text: #f8fafc;
            --sugu-text-muted: #94a3b8;
            --sugu-success: #10b981;
            --sugu-warning: #f59e0b;
            --sugu-danger: #ef4444;
            --sugu-info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--sugu-bg-dark);
            color: var(--sugu-text);
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: var(--sugu-bg-sidebar);
            border-right: 1px solid var(--sugu-border);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid var(--sugu-border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--sugu-accent), var(--sugu-accent-hover));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            color: white;
        }

        .sidebar-brand-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--sugu-text);
        }

        .sidebar-brand-text span {
            color: var(--sugu-accent);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section-title {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--sugu-text-muted);
            letter-spacing: 0.05em;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1.5rem;
            color: var(--sugu-text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            font-size: 0.9375rem;
        }

        .sidebar-nav .nav-link:hover {
            color: var(--sugu-text);
            background: rgba(249, 115, 22, 0.1);
            border-left-color: var(--sugu-accent);
        }

        .sidebar-nav .nav-link.active {
            color: var(--sugu-accent);
            background: rgba(249, 115, 22, 0.15);
            border-left-color: var(--sugu-accent);
            font-weight: 500;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .top-navbar {
            position: sticky;
            top: 0;
            z-index: 999;
            background: rgba(10, 15, 26, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--sugu-border);
            padding: 0.75rem 1.5rem;
        }

        .search-box {
            position: relative;
            max-width: 400px;
        }

        .search-box input {
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            border-radius: 10px;
            padding: 0.625rem 1rem 0.625rem 2.75rem;
            color: var(--sugu-text);
            width: 100%;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--sugu-accent);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }

        .search-box input::placeholder {
            color: var(--sugu-text-muted);
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--sugu-text-muted);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-btn {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            color: var(--sugu-text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .navbar-btn:hover {
            background: var(--sugu-secondary);
            color: var(--sugu-text);
            border-color: var(--sugu-secondary);
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 18px;
            height: 18px;
            background: var(--sugu-accent);
            border-radius: 50%;
            font-size: 0.625rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .admin-profile:hover {
            border-color: var(--sugu-accent);
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            object-fit: cover;
        }

        .admin-info {
            display: flex;
            flex-direction: column;
        }

        .admin-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--sugu-text);
        }

        .admin-role {
            font-size: 0.75rem;
            color: var(--sugu-text-muted);
        }

        .page-content {
            padding: 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--sugu-text);
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            color: var(--sugu-text-muted);
            font-size: 0.9375rem;
        }

        .stat-card {
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--sugu-accent);
            box-shadow: 0 10px 40px rgba(249, 115, 22, 0.1);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-icon.primary {
            background: rgba(59, 130, 246, 0.2);
            color: var(--sugu-info);
        }

        .stat-icon.success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--sugu-success);
        }

        .stat-icon.warning {
            background: rgba(249, 115, 22, 0.2);
            color: var(--sugu-accent);
        }

        .stat-icon.danger {
            background: rgba(239, 68, 68, 0.2);
            color: var(--sugu-danger);
        }

        .stat-trend {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: 500;
        }

        .stat-trend.up {
            background: rgba(16, 185, 129, 0.2);
            color: var(--sugu-success);
        }

        .stat-trend.down {
            background: rgba(239, 68, 68, 0.2);
            color: var(--sugu-danger);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--sugu-text);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: var(--sugu-text-muted);
            font-size: 0.875rem;
        }

        .dashboard-card {
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            border-radius: 16px;
            overflow: hidden;
        }

        .dashboard-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--sugu-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--sugu-text);
        }

        .dashboard-card-body {
            padding: 1.5rem;
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table thead th {
            background: rgba(31, 41, 55, 0.5);
            padding: 1rem 1.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--sugu-text-muted);
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--sugu-border);
        }

        .custom-table thead th:first-child {
            border-radius: 10px 0 0 0;
        }

        .custom-table thead th:last-child {
            border-radius: 0 10px 0 0;
        }

        .custom-table tbody td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--sugu-border);
            vertical-align: middle;
        }

        .custom-table tbody tr {
            transition: all 0.2s ease;
        }

        .custom-table tbody tr:hover {
            background: rgba(249, 115, 22, 0.05);
        }

        .custom-table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge-status {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-status.active {
            background: rgba(16, 185, 129, 0.2);
            color: var(--sugu-success);
        }

        .badge-status.pending {
            background: rgba(245, 158, 11, 0.2);
            color: var(--sugu-warning);
        }

        .badge-status.inactive {
            background: rgba(239, 68, 68, 0.2);
            color: var(--sugu-danger);
        }

        .user-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
        }

        .user-info h6 {
            font-size: 0.9375rem;
            font-weight: 600;
            color: var(--sugu-text);
            margin-bottom: 0.125rem;
        }

        .user-info small {
            color: var(--sugu-text-muted);
            font-size: 0.8125rem;
        }

        .activity-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--sugu-border);
        }

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
                margin-left: 0;
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

            <a href="#" class="nav-link">
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
                    <button class="navbar-btn" title="Messages">
                        <i class="bi bi-envelope"></i>
                        <span class="notification-badge">3</span>
                    </button>

                    <button class="navbar-btn" title="Notifications">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">5</span>
                    </button>

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
                            <li><a class="dropdown-item" href="#" style="color: var(--sugu-text-muted);"><i class="bi bi-person me-2"></i>Mon profil</a></li>
                            <li><a class="dropdown-item" href="#" style="color: var(--sugu-text-muted);"><i class="bi bi-gear me-2"></i>Paramètres</a></li>
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

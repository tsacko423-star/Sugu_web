<!DOCTYPE html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mon Espace') - SUGU-WEB</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100vh;
            background: var(--sugu-bg-sidebar);
            border-right: 1px solid var(--sugu-border);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 1.25rem;
            border-bottom: 1px solid var(--sugu-border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-brand-logo {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--sugu-accent), var(--sugu-accent-hover));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.125rem;
            color: white;
        }

        .sidebar-brand-text {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--sugu-text);
        }

        .sidebar-brand-text span {
            color: var(--sugu-accent);
        }

        /* User Profile Section */
        .sidebar-user {
            padding: 1.25rem;
            border-bottom: 1px solid var(--sugu-border);
            text-align: center;
        }

        .sidebar-user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            object-fit: cover;
            margin-bottom: 0.75rem;
            border: 3px solid var(--sugu-accent);
        }

        .sidebar-user-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--sugu-text);
            margin-bottom: 0.25rem;
        }

        .sidebar-user-email {
            font-size: 0.8125rem;
            color: var(--sugu-text-muted);
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-section-title {
            padding: 0.75rem 1.25rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--sugu-text-muted);
            letter-spacing: 0.05em;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            color: var(--sugu-text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            font-size: 0.875rem;
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
            font-size: 1.125rem;
            width: 22px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Navbar */
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
            max-width: 350px;
        }

        .search-box input {
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            border-radius: 10px;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            color: var(--sugu-text);
            width: 100%;
            font-size: 0.875rem;
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
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--sugu-text-muted);
            font-size: 0.9375rem;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-btn {
            width: 40px;
            height: 40px;
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
            width: 16px;
            height: 16px;
            background: var(--sugu-accent);
            border-radius: 50%;
            font-size: 0.6rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .user-profile-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.375rem 0.75rem;
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-profile-btn:hover {
            border-color: var(--sugu-accent);
        }

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            object-fit: cover;
        }

        .user-name-sm {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--sugu-text);
        }

        /* Page Content */
        .page-content {
            padding: 1.5rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--sugu-text);
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            color: var(--sugu-text-muted);
            font-size: 0.875rem;
        }

        /* Stats Cards */
        .stat-card {
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            border-radius: 14px;
            padding: 1.25rem;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: var(--sugu-accent);
            box-shadow: 0 8px 30px rgba(249, 115, 22, 0.1);
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
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

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--sugu-text);
            margin-bottom: 0.125rem;
        }

        .stat-label {
            color: var(--sugu-text-muted);
            font-size: 0.8125rem;
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            border-radius: 14px;
            overflow: hidden;
        }

        .dashboard-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--sugu-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--sugu-text);
        }

        .dashboard-card-body {
            padding: 1.25rem;
        }

        /* Tables */
        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table thead th {
            background: rgba(31, 41, 55, 0.5);
            padding: 0.875rem 1rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--sugu-text-muted);
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--sugu-border);
        }

        .custom-table thead th:first-child {
            border-radius: 8px 0 0 0;
        }

        .custom-table thead th:last-child {
            border-radius: 0 8px 0 0;
        }

        .custom-table tbody td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid var(--sugu-border);
            vertical-align: middle;
            font-size: 0.875rem;
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

        /* Badges */
        .badge-status {
            padding: 0.3rem 0.625rem;
            border-radius: 6px;
            font-size: 0.7rem;
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

        /* Annonce Item */
        .annonce-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .annonce-img {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            object-fit: cover;
        }

        .annonce-info h6 {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--sugu-text);
            margin-bottom: 0.125rem;
        }

        .annonce-info small {
            color: var(--sugu-text-muted);
            font-size: 0.75rem;
        }

        /* Activity Item */
        .activity-item {
            display: flex;
            gap: 0.875rem;
            padding: 0.875rem 0;
            border-bottom: 1px solid var(--sugu-border);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.9375rem;
        }

        .activity-icon.view {
            background: rgba(59, 130, 246, 0.2);
            color: var(--sugu-info);
        }

        .activity-icon.message {
            background: rgba(16, 185, 129, 0.2);
            color: var(--sugu-success);
        }

        .activity-icon.favorite {
            background: rgba(239, 68, 68, 0.2);
            color: var(--sugu-danger);
        }

        .activity-content h6 {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--sugu-text);
            margin-bottom: 0.125rem;
        }

        .activity-content p {
            font-size: 0.75rem;
            color: var(--sugu-text-muted);
            margin-bottom: 0;
        }

        .activity-time {
            font-size: 0.7rem;
            color: var(--sugu-text-muted);
            margin-left: auto;
            flex-shrink: 0;
        }

        /* Action Buttons */
        .btn-action {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.875rem;
            text-decoration: none;
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

        /* Custom Buttons */
        .btn-primary-custom {
            background: var(--sugu-accent);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary-custom:hover {
            background: var(--sugu-accent-hover);
            color: white;
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-outline-custom {
            background: transparent;
            border: 1px solid var(--sugu-border);
            color: var(--sugu-text-muted);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .btn-outline-custom:hover {
            border-color: var(--sugu-accent);
            color: var(--sugu-accent);
            text-decoration: none;
        }

        /* Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--sugu-bg-card);
            border: 1px solid var(--sugu-border);
            color: var(--sugu-text-muted);
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        /* Responsive */
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

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.4s ease forwards;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--sugu-bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--sugu-border);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--sugu-secondary);
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
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
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
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
                        <input type="text" placeholder="Rechercher vos annonces...">
                    </div>
                </div>

                <div class="navbar-actions">
                    <button class="navbar-btn" title="Messages" onclick="location.href='#'">
                        <i class="bi bi-chat-dots"></i>
                        <span class="notification-badge">{{ $unreadMessages ?? 0 }}</span>
                    </button>
                    
                    <button class="navbar-btn" title="Notifications" onclick="location.href='#'">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">{{ $unreadNotifications ?? 0 }}</span>
                    </button>
                    
                    <div class="dropdown">
                        <div class="user-profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name ?? 'User') . '&background=f97316&color=fff' }}" alt="Avatar" class="user-avatar-sm">
                            <span class="user-name-sm d-none d-sm-inline">{{ auth()->user()->name ?? 'Utilisateur' }}</span>
                            <i class="bi bi-chevron-down" style="font-size: 0.7rem; color: var(--sugu-text-muted);"></i>
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
            <div class="page-header">
                <div>
                    <h1 class="page-title">Bienvenue, {{ auth()->user()->name ?? 'Utilisateur' }} !</h1>
                    <p class="page-subtitle">Gérez vos annonces et suivez leur performance</p>
                </div>
                <a href="{{ route('annonces.create') }}" class="btn-primary-custom">
                    <i class="bi bi-plus-lg"></i>
                    Nouvelle annonce
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="stat-card animate-fadeInUp delay-1">
                        <div class="stat-card-header">
                            <div class="stat-icon primary">
                                <i class="bi bi-megaphone-fill"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $totalAnnonces ?? 0 }}</div>
                        <div class="stat-label">Annonces publiées</div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="stat-card animate-fadeInUp delay-2">
                        <div class="stat-card-header">
                            <div class="stat-icon success">
                                <i class="bi bi-eye-fill"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ number_format($totalViews ?? 0) }}</div>
                        <div class="stat-label">Vues totales</div>
                    </div>
                </div>
                
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="stat-card animate-fadeInUp delay-3">
                        <div class="stat-card-header">
                            <div class="stat-icon warning">
                                <i class="bi bi-chat-dots-fill"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $totalMessages ?? 0 }}</div>
                        <div class="stat-label">Messages reçus</div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="row g-4">
                <div class="col-12 col-xl-8">
                    <!-- My Annonces -->
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <h5 class="dashboard-card-title">Mes Annonces</h5>
                            <a href="{{ route('annonces.index') }}" class="btn-outline-custom btn-sm">
                                Voir tout
                            </a>
                        </div>
                        <div class="dashboard-card-body p-0">
                            <div class="table-responsive">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>Annonce</th>
                                            <th>Catégorie</th>
                                            <th>Prix</th>
                                            <th>Vues</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($userAnnonces as $annonce)
                                        <tr>
                                            <td>
                                                <div class="annonce-item">
                                                    <img src="https://via.placeholder.com/48?text={{ substr($annonce->titre, 0, 3) }}" alt="" class="annonce-img">
                                                    <div class="annonce-info">
                                                        <h6>{{ $annonce->titre }}</h6>
                                                        <small>{{ $annonce->created_at->format('d/m/Y') }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge-status pending">{{ $annonce->categorie->nom ?? 'Non classé' }}</span></td>
                                            <td class="fw-semibold">{{ number_format($annonce->prix, 0, ',', ' ') }}€</td>
                                            <td style="color: var(--sugu-text-muted);">{{ rand(10, 500) }}</td>
                                            <td>
                                                <span class="badge-status active">Actif</span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('annonces.show', $annonce) }}" class="btn-action view" title="Voir"><i class="bi bi-eye"></i></a>
                                                    <a href="{{ route('annonces.edit', $annonce) }}" class="btn-action edit" title="Modifier"><i class="bi bi-pencil"></i></a>
                                                    <button class="btn-action delete" title="Supprimer" onclick="if(confirm('Êtes-vous sûr?')) { document.getElementById('delete-form-{{ $annonce->id }}').submit(); }"><i class="bi bi-trash"></i></button>
                                                    <form id="delete-form-{{ $annonce->id }}" action="{{ route('annonces.destroy', $annonce) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <p style="color: var(--sugu-text-muted);">Aucune annonce publiée pour le moment</p>
                                                <a href="{{ route('annonces.create') }}" class="btn-primary-custom mt-2">
                                                    <i class="bi bi-plus-lg"></i> Créer une annonce
                                                </a>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-xl-4">
                    <!-- Recent Activity -->
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <h5 class="dashboard-card-title">Activité Récente</h5>
                        </div>
                        <div class="dashboard-card-body">
                            @forelse($recentActivities as $activity)
                            <div class="activity-item">
                                <div class="activity-icon {{ $activity['type'] }}">
                                    <i class="bi bi-{{ $activity['icon'] }}"></i>
                                </div>
                                <div class="activity-content flex-grow-1">
                                    <h6>{{ $activity['title'] }}</h6>
                                    <p>{{ $activity['description'] }}</p>
                                </div>
                                <span class="activity-time">{{ $activity['time'] }}</span>
                            </div>
                            @empty
                            <div style="text-align: center; padding: 2rem 0; color: var(--sugu-text-muted);">
                                <p>Aucune activité récente</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="dashboard-card mt-4">
                        <div class="dashboard-card-header">
                            <h5 class="dashboard-card-title">Actions Rapides</h5>
                        </div>
                        <div class="dashboard-card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('annonces.create') }}" class="btn-primary-custom justify-content-center">
                                    <i class="bi bi-plus-lg"></i>
                                    Publier une annonce
                                </a>
                                <a href="{{ route('profile.edit') }}" class="btn-outline-custom text-center d-block">
                                    <i class="bi bi-person me-2"></i>
                                    Modifier mon profil
                                </a>
                                <a href="#" class="btn-outline-custom text-center d-block">
                                    <i class="bi bi-chat-dots me-2"></i>
                                    Voir mes messages
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle
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

        // Close sidebar on window resize (desktop)
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    </script>
</body>
</html>

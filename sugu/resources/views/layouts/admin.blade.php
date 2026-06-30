@extends('layouts.dashboard')

@section('title', 'Admin - ' . config('app.name', 'SUGU-WEB'))

@push('styles')
<style>
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
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

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease forwards;
    }

    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

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

    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@section('sidebar_nav')
    <div class="nav-section-title">Menu Principal</div>

    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <i class="bi bi-collection-fill"></i>
        <span>Gestion des catégories</span>
    </a>

    <a href="{{ route('attributs.index') }}" class="nav-link {{ request()->routeIs('attributs.*') ? 'active' : '' }}">
        <i class="bi bi-tags-fill"></i>
        <span>Gestion des attributs</span>
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

    <div class="nav-section-title mt-3">Compte</div>
    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-left"></i>
        <span>Déconnexion</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
@endsection


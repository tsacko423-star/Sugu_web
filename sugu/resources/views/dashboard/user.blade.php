@extends('layouts.dashboard')

@section('title', 'Mon Espace')

@section('content')
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
                    <a href="{{ route('annonces.index') }}" class="btn-outline-custom btn-sm">Voir tout</a>
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
                                    <td><span class="badge-status active">Actif</span></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('annonces.show', $annonce) }}" class="btn-action view" title="Voir"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('annonces.edit', $annonce) }}" class="btn-action edit" title="Modifier"><i class="bi bi-pencil"></i></a>
                                            <button class="btn-action delete" title="Supprimer" onclick="if(confirm('Êtes-vous sûr?')) { document.getElementById('delete-form-{{ $annonce->id }}').submit(); }"><i class="bi bi-trash"></i></button>
                                            <form id="delete-form-{{ $annonce->id }}" action="{{ route('annonces.destroy', $annonce) }}" method="POST" style="display: none;">@csrf @method('DELETE')</form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <p style="color: var(--sugu-text-muted);">Aucune annonce publiée pour le moment</p>
                                        <a href="{{ route('annonces.create') }}" class="btn-primary-custom mt-2"><i class="bi bi-plus-lg"></i> Créer une annonce</a>
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
                        <a href="{{ route('annonces.create') }}" class="btn-primary-custom justify-content-center"><i class="bi bi-plus-lg"></i> Publier une annonce</a>
                        <a href="{{ route('profile.edit') }}" class="btn-outline-custom text-center d-block"><i class="bi bi-person me-2"></i> Modifier mon profil</a>
                        <a href="{{ route('messages.inbox') }}" class="btn-outline-custom text-center d-block"><i class="bi bi-chat-dots me-2"></i> Voir mes messages</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Bienvenue sur votre tableau de bord SUGU-WEB</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card animate-fadeInUp delay-1">
            <div class="stat-card-header">
                <div class="stat-icon primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="stat-trend up">
                    <i class="bi bi-arrow-up"></i> 12%
                </span>
            </div>
            <div class="stat-value">{{ number_format($totalUsers ?? 0) }}</div>
            <div class="stat-label">Total Utilisateurs</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card animate-fadeInUp delay-2">
            <div class="stat-card-header">
                <div class="stat-icon success">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
                <span class="stat-trend up">
                    <i class="bi bi-arrow-up"></i> 8%
                </span>
            </div>
            <div class="stat-value">{{ number_format($totalAnnonces ?? 0) }}</div>
            <div class="stat-label">Annonces Publiées</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card animate-fadeInUp delay-3">
            <div class="stat-card-header">
                <div class="stat-icon warning">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <span class="stat-trend up">
                    <i class="bi bi-arrow-up"></i> 23%
                </span>
            </div>
            <div class="stat-value">{{ number_format($totalRevenue ?? 0, 0, ',', ' ') }}€</div>
            <div class="stat-label">Revenus Totaux</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card animate-fadeInUp delay-4">
            <div class="stat-card-header">
                <div class="stat-icon danger">
                    <i class="bi bi-collection-fill"></i>
                </div>
                <span class="stat-trend down">
                    <i class="bi bi-arrow-down"></i> 2%
                </span>
            </div>
            <div class="stat-value">{{ $totalCategories ?? 0 }}</div>
            <div class="stat-label">Catégories</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-xl-8">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h5 class="dashboard-card-title">Annonces Publiées</h5>
                <div class="d-flex gap-2">
                    <button class="btn-outline-custom btn-sm" data-period="week">Semaine</button>
                    <button class="btn-primary-custom btn-sm" data-period="month">Mois</button>
                    <button class="btn-outline-custom btn-sm" data-period="year">Année</button>
                </div>
            </div>
            <div class="dashboard-card-body">
                <div class="chart-container">
                    <canvas id="annoncesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="dashboard-card h-100">
            <div class="dashboard-card-header">
                <h5 class="dashboard-card-title">Répartition par Catégorie</h5>
            </div>
            <div class="dashboard-card-body">
                <div class="chart-container">
                    <canvas id="categoriesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-xl-8">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h5 class="dashboard-card-title">Annonces Récentes</h5>
                <a href="{{ route('annonces.index') }}" class="btn-outline-custom btn-sm">
                    Voir tout <i class="bi bi-arrow-right ms-1"></i>
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
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAnnonces as $annonce)
                            <tr>
                                <td>
                                    <div class="user-item">
                                        <img src="{{ $annonce->image ?? 'https://via.placeholder.com/40' }}" alt="" class="user-avatar">
                                        <div class="user-info">
                                            <h6>{{ $annonce->titre }}</h6>
                                            <small>{{ $annonce->user->name ?? 'Utilisateur' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge-status pending">{{ $annonce->categorie->name ?? 'Non classé' }}</span></td>
                                <td class="fw-semibold">{{ number_format($annonce->prix ?? 0, 0, ',', ' ') }}FCFA</td>
                                <td>
                                    <span class="badge-status {{ ($annonce->status ?? 'pending') === 'active' ? 'active' : (($annonce->status ?? 'pending') === 'pending' ? 'pending' : 'inactive') }}">
                                        {{ ucfirst($annonce->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td style="color: var(--sugu-text-muted);">{{ optional($annonce->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn-action view" title="Voir"><i class="bi bi-eye"></i></button>
                                        <button class="btn-action edit" title="Modifier"><i class="bi bi-pencil"></i></button>
                                        <button class="btn-action delete" title="Supprimer"><i class="bi bi-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4" style="color: var(--sugu-text-muted);">Aucune annonce récente.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-4">
        <div class="dashboard-card mb-4">
            <div class="dashboard-card-header">
                <h5 class="dashboard-card-title">Utilisateurs Récents</h5>
            </div>
            <div class="dashboard-card-body">
                @forelse($recentUsers as $user)
                <div class="user-item mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="" class="user-avatar">
                    <div class="user-info flex-grow-1">
                        <h6>{{ $user->name }}</h6>
                        <small>{{ $user->email }}</small>
                    </div>
                    <span class="badge-status active">Actif</span>
                </div>
                @empty
                <div class="user-item mb-3">
                    <img src="https://ui-avatars.com/api/?name=Jean+Dupont&background=3b82f6&color=fff" alt="" class="user-avatar">
                    <div class="user-info flex-grow-1">
                        <h6>Jean Dupont</h6>
                        <small>jean.dupont@email.com</small>
                    </div>
                    <span class="badge-status active">Actif</span>
                </div>
                @endforelse
            </div>
        </div>

        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h5 class="dashboard-card-title">Activités Récentes</h5>
            </div>
            <div class="dashboard-card-body">
                @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon {{ $activity->type }}">
                        <i class="bi bi-{{ $activity->icon }}"></i>
                    </div>
                    <div class="activity-content flex-grow-1">
                        <h6>{{ $activity->title }}</h6>
                        <p>{{ $activity->description }}</p>
                    </div>
                    <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <div class="activity-item">
                    <div class="activity-icon new-user">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div class="activity-content flex-grow-1">
                        <h6>Nouvel utilisateur</h6>
                        <p>Jean Dupont s'est inscrit</p>
                    </div>
                    <span class="activity-time">Il y a 5 min</span>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
/* global Chart */
document.addEventListener('DOMContentLoaded', function() {
    const annoncesCtx = document.getElementById('annoncesChart').getContext('2d');
    const annoncesChart = new Chart(annoncesCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Annonces publiées',
                data: [120, 150, 180, 220, 280, 320, 350, 310, 290, 340, 380, 420],
                borderColor: '#f97316',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#f97316',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#f8fafc',
                    bodyColor: '#94a3b8',
                    borderColor: '#1f2937',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        title: function(context) {
                            return context[0].label + ' 2026';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(31, 41, 55, 0.5)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94a3b8'
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(31, 41, 55, 0.5)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94a3b8'
                    },
                    beginAtZero: true
                }
            }
        }
    });

    // eslint-disable-next-line no-undef
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    const categoriesChart = new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Immobilier', 'Automobile', 'Électronique', 'Mode', 'Mobilier', 'Autres'],
            datasets: [{
                data: [30, 25, 20, 12, 8, 5],
                backgroundColor: ['#3b82f6', '#10b981', '#f97316', '#8b5cf6', '#f59e0b', '#6b7280'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#94a3b8',
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#f8fafc',
                    bodyColor: '#94a3b8',
                    borderColor: '#1f2937',
                    borderWidth: 1,
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%';
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });

    document.querySelectorAll('[data-period]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('[data-period]').forEach(b => {
                b.classList.remove('btn-primary-custom');
                b.classList.add('btn-outline-custom');
            });
            this.classList.remove('btn-outline-custom');
            this.classList.add('btn-primary-custom');
            console.log('Selected period:', this.dataset.period);
        });
    });
});
</script>
@endpush

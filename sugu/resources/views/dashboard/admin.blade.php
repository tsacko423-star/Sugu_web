@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="page-header">
    <h1 class="page-title">Tableau de bord</h1>
    <p class="page-subtitle">Bienvenue sur votre tableau de bord SUGU-WEB</p>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card animate-fadeInUp delay-1">
            <div class="stat-card-header">
                <div class="stat-icon primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <span class="stat-trend {{ ($usersTrend ?? 0) >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ ($usersTrend ?? 0) >= 0 ? 'up' : 'down' }}"></i> {{ abs($usersTrend ?? 0) }}%
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
                <span class="stat-trend {{ ($annoncesTrend ?? 0) >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ ($annoncesTrend ?? 0) >= 0 ? 'up' : 'down' }}"></i> {{ abs($annoncesTrend ?? 0) }}%
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
                    <i class="bi bi-chat-dots-fill"></i>
                </div>
                <span class="stat-trend {{ ($messagesTrend ?? 0) >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ ($messagesTrend ?? 0) >= 0 ? 'up' : 'down' }}"></i> {{ abs($messagesTrend ?? 0) }}%
                </span>
            </div>
            <div class="stat-value">{{ number_format($totalMessages ?? 0) }}</div>
            <div class="stat-label">Messages Totaux</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card animate-fadeInUp delay-4">
            <div class="stat-card-header">
                <div class="stat-icon danger">
                    <i class="bi bi-collection-fill"></i>
                </div>
                <span class="stat-trend {{ ($categoriesTrend ?? 0) >= 0 ? 'up' : 'down' }}">
                    <i class="bi bi-arrow-{{ ($categoriesTrend ?? 0) >= 0 ? 'up' : 'down' }}"></i> {{ abs($categoriesTrend ?? 0) }}%
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
                <span class="badge-status active">{{ now()->year }}</span>
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

<div class="row g-4 mb-4">
    <div class="col-12 col-xl-6">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h5 class="dashboard-card-title">Repartition des Utilisateurs</h5>
            </div>
            <div class="dashboard-card-body">
                <div class="chart-container">
                    <canvas id="usersPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="dashboard-card">
            <div class="dashboard-card-header">
                <h5 class="dashboard-card-title">Etat des Commandes</h5>
            </div>
            <div class="dashboard-card-body">
                <div class="chart-container">
                    <canvas id="ordersDoughnutChart"></canvas>
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
                            @php
                                $firstImage = is_array($annonce->images) && count($annonce->images) > 0
                                    ? $annonce->images[0]
                                    : null;
                            @endphp
                            <tr>
                                <td>
                                    <div class="user-item">
                                        <img src="{{ $firstImage ? asset('storage/' . $firstImage) : 'https://ui-avatars.com/api/?name=' . urlencode($annonce->titre) . '&background=f97316&color=fff' }}" alt="{{ $annonce->titre }}" class="user-avatar">
                                        <div class="user-info">
                                            <h6>{{ $annonce->titre }}</h6>
                                            <small>{{ $annonce->user->name ?? 'Utilisateur' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge-status pending">{{ $annonce->categorie->name ?? 'Non classé' }}</span></td>
                                <td class="fw-semibold">{{ number_format($annonce->prix ?? 0, 0, ',', ' ') }}FCFA</td>
                                <td>
                                    <span class="badge-status active">Publiée</span>
                                </td>
                                <td style="color: var(--sugu-text-muted);">{{ optional($annonce->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('annonces.show', $annonce) }}" class="btn-action view" title="Voir" aria-label="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('annonces.edit', $annonce) }}" class="btn-action edit" title="Modifier" aria-label="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('annonces.destroy', $annonce) }}" method="POST" class="m-0" onsubmit="return confirm('Supprimer cette annonce ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete" title="Supprimer" aria-label="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
                <p class="mb-0" style="color: var(--sugu-text-muted);">Aucun utilisateur récent.</p>
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
                <p class="mb-0" style="color: var(--sugu-text-muted);">Aucune activité récente.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
/* global Chart */
document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart === 'undefined') {
        return;
    }

    const annoncesLabels = @json($monthLabels ?? []);
    const annoncesData = @json($annoncesChartData ?? []);
    const categoryLabels = @json($categorySalesLabels ?? []);
    const categoryData = @json($categorySalesData ?? []);
    const userRoleLabels = @json($userRoleLabels ?? []);
    const userRoleData = @json($userRoleData ?? []);
    const orderStatusLabels = @json($orderStatusLabels ?? []);
    const orderStatusData = @json($orderStatusData ?? []);

    const chartColors = {
        accent: '#f97316',
        accentSoft: 'rgba(249, 115, 22, 0.15)',
        info: '#3b82f6',
        success: '#10b981',
        warning: '#f59e0b',
        danger: '#ef4444',
        muted: '#94a3b8',
        border: 'rgba(31, 41, 55, 0.65)',
        card: '#111827',
        text: '#f8fafc'
    };

    Chart.defaults.global.defaultFontColor = chartColors.muted;
    Chart.defaults.global.defaultFontFamily = "'Inter', 'Poppins', sans-serif";

    const sharedTooltip = {
        backgroundColor: chartColors.card,
        titleFontColor: chartColors.text,
        bodyFontColor: chartColors.muted,
        borderColor: '#1f2937',
        borderWidth: 1,
        xPadding: 12,
        yPadding: 12
    };

    const axisOptions = {
        gridLines: {
            color: chartColors.border,
            zeroLineColor: chartColors.border,
            drawBorder: false
        },
        ticks: {
            beginAtZero: true,
            precision: 0,
            fontColor: chartColors.muted
        }
    };

    const annoncesCtx = document.getElementById('annoncesChart').getContext('2d');
    new Chart(annoncesCtx, {
        type: 'line',
        data: {
            labels: annoncesLabels,
            datasets: [{
                label: 'Annonces publiees',
                data: annoncesData,
                borderColor: chartColors.accent,
                backgroundColor: chartColors.accentSoft,
                borderWidth: 3,
                fill: true,
                lineTension: 0.35,
                pointBackgroundColor: chartColors.accent,
                pointBorderColor: chartColors.text,
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: sharedTooltip,
            scales: {
                xAxes: [axisOptions],
                yAxes: [axisOptions]
            }
        }
    });

    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'bar',
        data: {
            labels: categoryLabels,
            datasets: [{
                label: 'Ventes par categorie',
                data: categoryData,
                backgroundColor: chartColors.info,
                borderColor: chartColors.info,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: sharedTooltip,
            scales: {
                xAxes: [axisOptions],
                yAxes: [axisOptions]
            }
        }
    });

    new Chart(document.getElementById('usersPieChart'), {
        type: 'pie',
        data: {
            labels: userRoleLabels,
            datasets: [{
                data: userRoleData,
                backgroundColor: [chartColors.danger, chartColors.success, chartColors.warning],
                borderColor: '#0a0f1a',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } },
            tooltips: sharedTooltip
        }
    });

    new Chart(document.getElementById('ordersDoughnutChart'), {
        type: 'doughnut',
        data: {
            labels: orderStatusLabels,
            datasets: [{
                data: orderStatusData,
                backgroundColor: [chartColors.success, chartColors.warning, chartColors.danger],
                borderColor: '#0a0f1a',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 62,
            legend: { position: 'bottom', labels: { usePointStyle: true, padding: 16 } },
            tooltips: sharedTooltip
        }
    });
});
</script>
@endpush

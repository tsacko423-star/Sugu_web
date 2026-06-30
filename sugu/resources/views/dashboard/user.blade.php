@extends('layouts.dashboard')

@section('title', 'Mon Espace')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Bienvenue, {{ auth()->user()->name ?? 'Utilisateur' }} !</h1>
            <p class="page-subtitle">Gerez vos annonces et vos messages</p>
        </div>
        <a href="{{ route('annonces.create') }}" class="btn-primary-custom">
            <i class="bi bi-plus-lg"></i>
            Nouvelle annonce
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="stat-card animate-fadeInUp delay-1">
                <div class="stat-card-header">
                    <div class="stat-icon primary">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalAnnonces ?? 0) }}</div>
                <div class="stat-label">Annonces publiees</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="stat-card animate-fadeInUp delay-2">
                <div class="stat-card-header">
                    <div class="stat-icon success">
                        <i class="bi bi-envelope-open-fill"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($unreadMessages ?? 0) }}</div>
                <div class="stat-label">Messages non lus</div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="stat-card animate-fadeInUp delay-3">
                <div class="stat-card-header">
                    <div class="stat-icon warning">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                </div>
                <div class="stat-value">{{ number_format($totalMessages ?? 0) }}</div>
                <div class="stat-label">Messages recus</div>
            </div>
        </div>
    </div>

    <div class="dashboard-card mb-4">
        <div class="dashboard-card-header">
            <h5 class="dashboard-card-title">Statistiques</h5>
            <span class="badge-status active">{{ now()->year }}</span>
        </div>
        <div class="dashboard-card-body">
            <div class="row g-4">
                <div class="col-12 col-xl-6">
                    <div class="chart-container">
                        <canvas id="userAnnoncesLineChart"></canvas>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="chart-container">
                        <canvas id="userCategorySalesBarChart"></canvas>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="chart-container">
                        <canvas id="userRolesPieChart"></canvas>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="chart-container">
                        <canvas id="userOrdersDoughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-xl-8">
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
                                    <th>Categorie</th>
                                    <th>Prix</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($userAnnonces as $annonce)
                                <tr>
                                    <td>
                                        @php
                                            $firstImage = is_array($annonce->images) && count($annonce->images) > 0
                                                ? $annonce->images[0]
                                                : null;
                                        @endphp
                                        <div class="annonce-item">
                                            @if($firstImage)
                                                <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $annonce->titre }}" class="annonce-img">
                                            @else
                                                <div class="annonce-img annonce-img-placeholder">
                                                    <i class="bi bi-{{ $annonce->categorie->icon ?? 'tag' }}"></i>
                                                </div>
                                            @endif
                                            <div class="annonce-info">
                                                <h6>{{ $annonce->titre }}</h6>
                                                <small>{{ optional($annonce->created_at)->format('d/m/Y') }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge-status pending">{{ $annonce->categorie->name ?? 'Non classe' }}</span></td>
                                    <td class="fw-semibold">{{ number_format($annonce->prix, 0, ',', ' ') }}FCFA</td>
                                    <td><span class="badge-status active">Actif</span></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('annonces.show', $annonce) }}" class="btn-action view" title="Voir"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('annonces.edit', $annonce) }}" class="btn-action edit" title="Modifier"><i class="bi bi-pencil"></i></a>
                                            <button class="btn-action delete" title="Supprimer" onclick="if(confirm('Supprimer cette annonce ?')) { document.getElementById('delete-form-{{ $annonce->id }}').submit(); }"><i class="bi bi-trash"></i></button>
                                            <form id="delete-form-{{ $annonce->id }}" action="{{ route('annonces.destroy', $annonce) }}" method="POST" style="display: none;">@csrf @method('DELETE')</form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p style="color: var(--sugu-text-muted);">Aucune annonce publiee pour le moment</p>
                                        <a href="{{ route('annonces.create') }}" class="btn-primary-custom mt-2"><i class="bi bi-plus-lg"></i> Creer une annonce</a>
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
            <div class="dashboard-card">
                <div class="dashboard-card-header">
                    <h5 class="dashboard-card-title">Activite recente</h5>
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
                        <p>Aucune activite recente</p>
                    </div>
                    @endforelse
                </div>
            </div>

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

@push('styles')
<style>
    .annonce-img-placeholder {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--sugu-bg-sidebar, #0d1421);
        color: var(--sugu-text-muted, #94a3b8);
        border: 1px solid var(--sugu-border, #1f2937);
    }

    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') {
        return;
    }

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

    const charts = @json($statsCharts ?? []);

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

    new Chart(document.getElementById('userAnnoncesLineChart'), {
        type: 'line',
        data: {
            labels: charts.annoncesLabels || [],
            datasets: [{
                label: 'Evolution des annonces',
                data: charts.annoncesData || [],
                borderColor: chartColors.accent,
                backgroundColor: chartColors.accentSoft,
                borderWidth: 3,
                pointBackgroundColor: chartColors.accent,
                pointBorderColor: chartColors.text,
                pointBorderWidth: 2,
                pointRadius: 4,
                lineTension: 0.35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: sharedTooltip,
            scales: { xAxes: [axisOptions], yAxes: [axisOptions] }
        }
    });

    new Chart(document.getElementById('userCategorySalesBarChart'), {
        type: 'bar',
        data: {
            labels: charts.salesLabels || [],
            datasets: [{
                label: 'Ventes par categorie',
                data: charts.salesData || [],
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
            scales: { xAxes: [axisOptions], yAxes: [axisOptions] }
        }
    });

    new Chart(document.getElementById('userRolesPieChart'), {
        type: 'pie',
        data: {
            labels: charts.userRoleLabels || [],
            datasets: [{
                data: charts.userRoleData || [],
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

    new Chart(document.getElementById('userOrdersDoughnutChart'), {
        type: 'doughnut',
        data: {
            labels: charts.orderStatusLabels || [],
            datasets: [{
                data: charts.orderStatusData || [],
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

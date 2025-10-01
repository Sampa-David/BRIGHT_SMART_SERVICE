<!-- Section Tableau de bord -->
<section id="section-dashboard">
    <div class="page-header">
        <h1 class="page-title">Tableau de bord</h1>
        <div class="breadcrumb">Tableau de bord/Accueil</div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card border-left-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-card-title">Demandes en attente</div>
                        <div class="stat-card-value">{{ $stats['pending_requests'] }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card border-left-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-card-title">Total des services</div>
                        <div class="stat-card-value">{{ $stats['total_services'] }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card border-left-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-card-title">Nouveaux messages</div>
                        <div class="stat-card-value">{{ $stats['new_messages'] }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card border-left-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-card-title">Clients actifs</div>
                        <div class="stat-card-value">{{ $stats['active_clients'] }}</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activités récentes -->
    <div class="recent-activities">
        <!-- Table des dernières demandes -->
        @include('dashboards.sections.partials.recent-requests')
    </div>
</section>
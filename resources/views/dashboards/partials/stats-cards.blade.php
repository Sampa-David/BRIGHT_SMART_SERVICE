<!-- Stats Cards Row -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card border-left-primary shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: 0.25rem;">
                            Demandes en attente
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                            {{ $stats['pending_requests'] }}
                        </div>
                    </div>
                    <div>
                        <i class="bi bi-clock-history" style="font-size: 2rem; color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-success shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--success); text-transform: uppercase; margin-bottom: 0.25rem;">
                            Total des services
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                            {{ $stats['total_services'] }}
                        </div>
                    </div>
                    <div>
                        <i class="bi bi-gear-fill" style="font-size: 2rem; color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-info shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--info); text-transform: uppercase; margin-bottom: 0.25rem;">
                            Nouveaux messages
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                            {{ $stats['new_messages'] }}
                        </div>
                    </div>
                    <div>
                        <i class="bi bi-envelope-fill" style="font-size: 2rem; color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card border-left-warning shadow h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: var(--warning); text-transform: uppercase; margin-bottom: 0.25rem;">
                            Clients actifs
                        </div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--gray-dark);">
                            {{ $stats['active_clients'] }}
                        </div>
                    </div>
                    <div>
                        <i class="bi bi-people-fill" style="font-size: 2rem; color: #dddfeb;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
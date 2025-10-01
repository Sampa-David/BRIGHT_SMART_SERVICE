<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Statistiques - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #FF6B6B;
            --secondary-color: #4ECDC4;
            --dark-color: #2C3E50;
            --light-color: #F7F9FC;
            --success-color: #2ECC71;
            --warning-color: #F1C40F;
            --danger-color: #E74C3C;
            --info-color: #3498DB;
            --gray-color: #95A5A6;
            --gray-light-color: #ECF0F1;
            --chart-colors: #FF6B6B, #4ECDC4, #2ECC71, #F1C40F, #E74C3C,
                          #3498DB, #9B59B6, #1ABC9C, #E67E22, #34495E;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
        }

        /* Navigation */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 1rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }

        /* Container */
        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        /* Cards */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -1rem;
        }

        .col-xl-8 {
            flex: 0 0 66.666667%;
            max-width: 66.666667%;
            padding: 1rem;
        }

        .col-xl-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
            padding: 1rem;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            background: white;
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-light-color);
        }

        .card-header h6 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Charts */
        .chart-area, .chart-pie {
            position: relative;
            height: 300px;
            margin: 1rem 0;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
            border-radius: 10px;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        .table th {
            background: var(--light-color);
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: var(--dark-color);
            border-bottom: 2px solid var(--gray-light-color);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid var(--gray-light-color);
        }

        .table tbody tr:hover {
            background: rgba(78,205,196,0.05);
        }

        /* Progress Bar */
        .progress {
            height: 20px;
            background-color: var(--gray-light-color);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(135deg, var(--success-color), #27ae60);
            border-radius: 10px;
            transition: width 0.3s ease;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            gap: 0.5rem;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .col-xl-8, .col-xl-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .navbar-container {
                flex-direction: column;
                gap: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .chart-area, .chart-pie {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('welcome') }}" class="navbar-brand">
                <i class="bi bi-lightning-charge-fill"></i>
                {{ config('app.name') }}
            </a>
            <div class="navbar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('services.manage') }}" class="nav-link">
                    <i class="bi bi-gear"></i> Services
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-link">
                    <i class="bi bi-person"></i> Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer;">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </nav>
<div class="container-fluid">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Statistiques détaillées</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour au tableau de bord
        </a>
    </div>

    <!-- Graphiques -->
    <div class="row">
        <!-- Demandes mensuelles -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Évolution des demandes</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="monthlyRequestsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services les plus demandés -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Services</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="topServicesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des services -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Performance des services</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Demandes</th>
                            <th>Taux de satisfaction</th>
                            <th>Revenus générés</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service_stats as $service)
                        <tr>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->requests_count }}</td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" 
                                         role="progressbar" 
                                         style="width: {{ $service->satisfaction_rate ?? 0 }}%">
                                        {{ $service->satisfaction_rate ?? 0 }}%
                                    </div>
                                </div>
                            </td>
                            <td>{{ number_format($service->revenue ?? 0, 2) }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration CSRF pour les requêtes AJAX
            let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Couleurs personnalisées pour les graphiques
            const chartColors = [
                'rgba(255, 107, 107, 0.8)',
                'rgba(78, 205, 196, 0.8)',
                'rgba(46, 204, 113, 0.8)',
                'rgba(241, 196, 15, 0.8)',
                'rgba(231, 76, 60, 0.8)',
                'rgba(52, 152, 219, 0.8)',
                'rgba(155, 89, 182, 0.8)',
                'rgba(26, 188, 156, 0.8)',
                'rgba(230, 126, 34, 0.8)',
                'rgba(52, 73, 94, 0.8)'
            ];

            // Données pour le graphique mensuel
            const monthlyData = @json($monthly_stats);
            
            // Configuration du graphique mensuel
            new Chart(document.getElementById('monthlyRequestsChart'), {
                type: 'line',
                data: {
                    labels: monthlyData.map(item => {
                        const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
                        return months[item.month - 1];
                    }),
                    datasets: [{
                        label: 'Demandes de service',
                        data: monthlyData.map(item => item.total),
                        borderColor: 'rgba(255, 107, 107, 1)',
                        backgroundColor: 'rgba(255, 107, 107, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: 'white',
                        pointBorderColor: 'rgba(255, 107, 107, 1)',
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
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    family: 'Montserrat',
                                    weight: '500'
                                },
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#2C3E50',
                            bodyColor: '#2C3E50',
                            bodyFont: {
                                family: 'Montserrat'
                            },
                            borderColor: '#e0e0e0',
                            borderWidth: 1,
                            padding: 10,
                            boxPadding: 5
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    family: 'Montserrat'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: 'Montserrat'
                                }
                            }
                        }
                    }
                }
            });

            // Configuration du graphique des services
            new Chart(document.getElementById('topServicesChart'), {
                type: 'doughnut',
                data: {
                    labels: @json($service_stats->pluck('title')),
                    datasets: [{
                        data: @json($service_stats->pluck('requests_count')),
                        backgroundColor: chartColors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Montserrat',
                                    size: 12
                                },
                                padding: 15
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#2C3E50',
                            bodyColor: '#2C3E50',
                            bodyFont: {
                                family: 'Montserrat'
                            },
                            borderColor: '#e0e0e0',
                            borderWidth: 1,
                            padding: 10
                        }
                    },
                    cutout: '70%'
                }
            });

            // Animations des cartes
            document.querySelectorAll('.card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Animation des barres de progression
            document.querySelectorAll('.progress-bar').forEach(bar => {
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = bar.getAttribute('aria-valuenow') + '%';
                }, 100);
            });
        });
    </script>
</body>
</html>
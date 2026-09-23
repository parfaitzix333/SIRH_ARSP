@extends($layout ?? 'dg.base')

@section('content')
    @php
        $routes = $routes ?? [
            'utilisateurs' => 'les_utilisateurs',
            'employes' => 'les_employes',
            'affectations' => 'les_affectations',
            'demandes_conge' => 'les_demandes_conge',
            'services' => 'les_services',
            'annees' => 'les_annees',
        ];

        // ============================================================
        // Préparation des données en haut de la vue (plus lisible)
        // ============================================================

        // Cartes statistiques principales (mutualisées pour éviter la répétition)
        $cartes = [
            [
                'label' => 'Utilisateurs',
                'value' => $les_utilisateurs,
                'color' => '#2274a5',
                'icon' => 'fa-users',
                'route' => $routes['utilisateurs'],
                'cta' => 'Voir les utilisateurs',
            ],
            [
                'label' => 'Employés de la société',
                'value' => $les_employes,
                'color' => '#6b46c1',
                'icon' => 'fa-id-card',
                'route' => $routes['employes'],
                'cta' => 'Voir les employés',
            ],
            [
                'label' => 'Employés affectés',
                'value' => $les_affectations,
                'color' => '#2f855a',
                'icon' => 'fa-user-check',
                'route' => $routes['affectations'],
                'cta' => 'Voir les affectations',
            ],
            [
                'label' => "Demandes de congé en {$annee}",
                'value' => $les_demandes_conges_annee,
                'color' => '#b7791f',
                'icon' => 'fa-calendar-alt',
                'route' => $routes['demandes_conge'],
                'cta' => 'Gérer les demandes',
            ],
        ];

        // Statuts possibles pour le compteur de demandes
        $statuts = [
            'soumise' => 'Soumises',
            'brouillon' => 'Brouillons',
            'refusee' => 'Refusées',
            'annulee' => 'Annulées',
            'validee' => 'Validées',
            'non_renseigne' => 'Sans statut',
        ];

        // S'assurer que les 12 mois sont présents pour le graphique
$presencesParMois = $presencesMensuelles->pluck('presences')->pad(12, 0)->values();
    @endphp

    <style>
        .dashboard-heading {
            margin-bottom: 1.5rem;
        }

        .dashboard-heading h2 {
            color: #17324d;
            font-weight: 700;
            margin-bottom: .35rem;
        }

        .dashboard-heading p {
            color: #6b7280;
            margin: 0;
        }

        .dashboard-card {
            border: 0;
            border-left: 4px solid var(--card-color);
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(23, 50, 77, .08);
            height: 100%;
        }

        .dashboard-card .icon {
            align-items: center;
            background: color-mix(in srgb, var(--card-color) 14%, white);
            border-radius: 9px;
            color: var(--card-color);
            display: flex;
            font-size: 1.25rem;
            height: 44px;
            justify-content: center;
            width: 44px;
        }

        .dashboard-card .label {
            color: #6b7280;
            font-size: .82rem;
            margin-top: 1rem;
        }

        .dashboard-card .value {
            color: #17324d;
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
        }

        .dashboard-card a {
            color: var(--card-color);
            font-size: .8rem;
            text-decoration: none;
        }

        .quick-actions {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(23, 50, 77, .08);
        }

        .quick-actions a {
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #17324d;
            display: flex;
            gap: .75rem;
            padding: .85rem 1rem;
            text-decoration: none;
            transition: background-color .2s, border-color .2s;
        }

        .quick-actions a:hover {
            background: #f0f7fc;
            border-color: #8bbbd8;
        }

        .quick-actions i {
            color: #2274a5;
            width: 1.1rem;
        }

        .pending-requests {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(23, 50, 77, .08);
        }

        .pending-requests .table {
            margin-bottom: 0;
        }

        .pending-requests th {
            background: #f0f7fc;
            color: #17324d;
            font-size: .76rem;
            text-transform: uppercase;
        }

        .pending-requests td {
            color: #374151;
            vertical-align: middle;
        }

        .status-badge {
            background: #fff4cc;
            border-radius: 999px;
            color: #8a5a00;
            display: inline-block;
            font-size: .75rem;
            padding: .3rem .6rem;
        }

        .status-count {
            align-items: center;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #374151;
            display: inline-flex;
            font-size: .8rem;
            gap: .4rem;
            padding: .4rem .65rem;
        }

        .status-count strong {
            color: #17324d;
            font-size: .95rem;
        }

        .pending-details {
            border-top: 1px solid #e5e7eb;
            padding-top: .75rem;
        }

        .pending-details summary {
            color: #2274a5;
            cursor: pointer;
            font-size: .85rem;
            font-weight: 600;
            list-style-position: inside;
            margin-bottom: .75rem;
        }

        .pending-details summary::marker {
            color: #2274a5;
        }

        .attendance-chart {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(23, 50, 77, .08);
        }

        .attendance-chart summary {
            color: #17324d;
            cursor: pointer;
            font-weight: 700;
            list-style-position: inside;
        }

        .chart-container {
            height: 340px;
            margin-top: 1rem;
            position: relative;
        }
    </style>

    <div class="container-fluid py-4">
        {{-- En-tête --}}
        <div class="dashboard-heading">
            <h2>Tableau de bord {{ $title ?? 'DP' }}</h2>
            <p>Vue d’ensemble de l’activité pour l’année {{ $annee }}.</p>
        </div>

        {{-- Cartes statistiques --}}
        <div class="row g-4 mb-4">
            @foreach ($cartes as $carte)
                <div class="col-12 col-sm-6 col-xl">
                    <div class="card dashboard-card p-3" style="--card-color: {{ $carte['color'] }};">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="label mt-0">{{ $carte['label'] }}</div>
                                <div class="value">{{ $carte['value'] }}</div>
                            </div>
                            <div class="icon"><i class="fas {{ $carte['icon'] }}"></i></div>
                        </div>
                        <a class="mt-3 d-inline-block" href="{{ route($carte['route']) }}">
                            {{ $carte['cta'] }} <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- 5e carte : demandes du mois (pas de lien, indication différente) --}}
            <div class="col-12 col-sm-6 col-xl">
                <div class="card dashboard-card p-3" style="--card-color: #c53030;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="label mt-0">Demandes ce mois</div>
                            <div class="value">{{ $les_demandes_conges_mois }}</div>
                        </div>
                        <div class="icon"><i class="fas fa-clock"></i></div>
                    </div>
                    <span class="mt-3 d-inline-block text-muted small">
                        {{ $demandes_en_attente }} en attente de traitement
                    </span>
                </div>
            </div>
        </div>

        {{-- Graphique des présences par mois (chargé à l'ouverture) --}}
        <details class="card attendance-chart p-4 mb-4" id="attendanceDetails">
            <summary>Présences par mois comparées à l’effectif</summary>
            <div class="chart-container">
                <canvas id="attendanceChart" role="img"
                    aria-label="Histogramme des présences mensuelles comparées au nombre d’employés"></canvas>
            </div>
        </details>

        {{-- Demandes non validées --}}
        <div class="card pending-requests p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="mb-1">Demandes non validées</h5>
                    <span class="text-muted small">Demandes de congé de l’année {{ $annee }}</span>
                </div>
                <a class="btn btn-sm btn-outline-primary" href="{{ route($routes['demandes_conge']) }}">
                    Voir tout <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <details class="pending-details">
                <summary>Afficher les compteurs et les demandes</summary>

                {{-- Compteurs par statut --}}
                <div class="d-flex flex-wrap gap-2 mb-3">
                    @foreach ($statuts as $statut => $libelle)
                        <span class="status-count">
                            {{ $libelle }} <strong>{{ $demandesParStatut->get($statut, 0) }}</strong>
                        </span>
                    @endforeach
                </div>

                {{-- Tableau des demandes --}}
                @if ($demandesNonValidees->isEmpty())
                    <p class="text-muted mb-0">Aucune demande non validée pour cette année.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <caption class="visually-hidden">
                                Liste des demandes de congé non validées pour l’année {{ $annee }}
                            </caption>
                            <thead>
                                <tr>
                                    <th scope="col">Employé</th>
                                    <th scope="col">Type de congé</th>
                                    <th scope="col">Début</th>
                                    <th scope="col">Fin</th>
                                    <th scope="col">Jours</th>
                                    <th scope="col">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($demandesNonValidees as $demande)
                                    <tr>
                                        <td>{{ $demande->employe?->nom ?? '—' }}</td>
                                        <td>{{ $demande->conge?->designation ?? '—' }}</td>
                                        <td>{{ $demande->date_debut?->format('d/m/Y') ?? '—' }}</td>
                                        <td>{{ $demande->date_fin?->format('d/m/Y') ?? '—' }}</td>
                                        <td>{{ $demande->nombre_jour ?? 0 }}</td>
                                        <td>
                                            <span class="status-badge">
                                                {{ ucfirst($demande->statut ?? 'non renseigné') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </details>
        </div>

        {{-- Accès rapides --}}
        <div class="card quick-actions p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Accès rapides</h5>
                <span class="text-muted small">Gestion administrative</span>
            </div>
            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <a href="{{ route($routes['employes']) }}">
                        <i class="fas fa-id-card"></i><span>Consulter les employés</span>
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route($routes['services']) }}">
                        <i class="fas fa-building"></i><span>Consulter les services</span>
                    </a>
                </div>
                <div class="col-12 col-md-4">
                    <a href="{{ route($routes['annees']) }}">
                        <i class="fas fa-calendar-days"></i><span>Gérer les années</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         Script : Chart.js chargé à la demande (uniquement à l'ouverture
         du <details>), pour ne pas pénaliser le chargement de la page.
         ============================================================ --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const detailsElement = document.getElementById('attendanceDetails');
                const chartElement = document.getElementById('attendanceChart');

                // Sécurité : on sort si les éléments n'existent pas
                if (!detailsElement || !chartElement) {
                    return;
                }

                const monthlyData = @json($presencesParMois);
                const employeeTotal = @json($les_employes);
                let attendanceChart = null;
                let chartJsLoaded = false;

                /**
                 * Charge dynamiquement Chart.js une seule fois.
                 * @returns {Promise<void>}
                 */
                function loadChartJs() {
                    if (chartJsLoaded) {
                        return Promise.resolve();
                    }

                    return new Promise(function(resolve, reject) {
                        const script = document.createElement('script');
                        script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                        script.onload = function() {
                            chartJsLoaded = true;
                            resolve();
                        };
                        script.onerror = reject;
                        document.head.appendChild(script);
                    });
                }

                /**
                 * Crée le graphique une seule fois.
                 */
                function createAttendanceChart() {
                    if (attendanceChart) {
                        return;
                    }

                    const barValuePlugin = {
                        id: 'barValueLabels',
                        afterDatasetsDraw: function(chart) {
                            const context = chart.ctx;

                            chart.data.datasets.forEach(function(dataset, datasetIndex) {
                                const meta = chart.getDatasetMeta(datasetIndex);

                                meta.data.forEach(function(bar, index) {
                                    const value = dataset.data[index];

                                    context.save();
                                    context.fillStyle = datasetIndex === 0 ? '#1b5d85' :
                                        '#8f5d17';
                                    context.font = '600 11px Arial';
                                    context.textAlign = 'center';
                                    context.textBaseline = 'bottom';
                                    context.fillText(value, bar.x, bar.y - 5);
                                    context.restore();
                                });
                            });
                        }
                    };

                    attendanceChart = new Chart(chartElement, {
                        type: 'bar',
                        plugins: [barValuePlugin],
                        data: {
                            labels: [
                                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                            ],
                            datasets: [{
                                    label: 'Employés présents',
                                    data: monthlyData,
                                    backgroundColor: '#2274a5',
                                    borderColor: '#1b5d85',
                                    borderWidth: 1,
                                    borderRadius: 4,
                                },
                                {
                                    label: 'Nombre total d’employés',
                                    data: Array(12).fill(employeeTotal),
                                    backgroundColor: '#b7791f',
                                    borderColor: '#8f5d17',
                                    borderWidth: 1,
                                    borderRadius: 4,
                                }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    },
                                    title: {
                                        display: true,
                                        text: 'Nombre d’employés'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }

                // Déclenchement à l'ouverture du bloc
                detailsElement.addEventListener('toggle', function() {
                    if (!detailsElement.open) {
                        return;
                    }

                    loadChartJs()
                        .then(createAttendanceChart)
                        .catch(function(err) {
                            console.error('Impossible de charger Chart.js :', err);
                        });
                });

                // Si le bloc est déjà ouvert au chargement (ex : navigation retour)
                if (detailsElement.open) {
                    detailsElement.dispatchEvent(new Event('toggle'));
                }
            });
        </script>
    @endpush
@endsection

@extends('cs.base')

@section('content')
    <style>
        .service-dashboard {
            color: #17324d;
        }

        .service-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(23, 50, 77, .08);
        }

        .service-stat {
            border-left: 4px solid var(--stat-color);
        }

        .service-stat .icon {
            color: var(--stat-color);
            font-size: 1.4rem;
        }

        .service-table th {
            color: #526579;
            font-size: .76rem;
            text-transform: uppercase;
        }

        .service-table td {
            vertical-align: middle;
        }

        .empty-state {
            color: #6b7280;
            padding: 2rem 1rem;
            text-align: center;
        }
    </style>

    <main class="container-fluid py-4 service-dashboard">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">Espace Chef de Service</h2>
                <p class="text-muted mb-0">Suivi des employés, des postes et des
                    disciplines{{ $annee ? ' pour l’année ' . $annee->annee : '' }}.</p>
            </div>
            <a href="{{ route('les_employes_CS') }}" class="btn btn-outline-primary">
                <i class="fas fa-users me-1"></i> Voir les employés
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card service-card service-stat h-100 p-3" style="--stat-color:#2274a5;">
                    <div class="d-flex justify-content-between"><span class="text-muted">Employés</span><i
                            class="fas fa-users icon"></i></div>
                    <div class="fs-2 fw-bold mt-2">{{ $employes->count() }}</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card service-card service-stat h-100 p-3" style="--stat-color:#2f855a;">
                    <div class="d-flex justify-content-between"><span class="text-muted">Postes</span><i
                            class="fas fa-briefcase icon"></i></div>
                    <div class="fs-2 fw-bold mt-2">{{ $postes->count() }}</div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card service-card service-stat h-100 p-3" style="--stat-color:#c53030;">
                    <div class="d-flex justify-content-between"><span class="text-muted">Disciplines</span><i
                            class="fas fa-scale-balanced icon"></i></div>
                    <div class="fs-2 fw-bold mt-2">{{ $disciplines->count() }}</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-xl-7">
                <section class="card service-card h-100">
                    <div class="card-header bg-white border-0 p-4 pb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">État général des employés</h5>
                            <p class="text-muted small mb-0">Résumé des effectifs et des affectations.</p>
                        </div>
                        <i class="fas fa-chart-pie text-primary fs-4"></i>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $employesAffectes = $employes
                                ->filter(fn($employe) => $employe->affectations->isNotEmpty())
                                ->count();
                            $employesNonAffectes = $employes->count() - $employesAffectes;
                        @endphp
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-light">
                                    <div class="small text-muted">Effectif total</div>
                                    <div class="fs-3 fw-bold">{{ $employes->count() }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-success-subtle">
                                    <div class="small text-success-emphasis">Employés affectés</div>
                                    <div class="fs-3 fw-bold text-success">{{ $employesAffectes }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-warning-subtle">
                                    <div class="small text-warning-emphasis">Sans affectation</div>
                                    <div class="fs-3 fw-bold text-warning-emphasis">{{ $employesNonAffectes }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                            <p class="text-muted mb-0">Consultez le détail des postes et des affectations dans la table
                                dédiée.</p>
                            <a href="{{ route('les_posts_CS') }}" class="btn btn-primary flex-shrink-0">
                                <i class="fas fa-briefcase me-1"></i> Voir la table des postes
                            </a>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-12 col-xl-5">
                <section class="card service-card h-100">
                    <div class="card-header bg-white border-0 p-4 pb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Postes</h5>
                            <p class="text-muted small mb-0">Postes et affectations.</p>
                        </div>
                        <a href="{{ route('les_posts_CS') }}" class="btn btn-sm btn-outline-primary"
                            title="Voir les postes"><i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="card-body pt-2">
                        @forelse ($postes as $poste)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                <div><strong>{{ $poste->intitule }}</strong>
                                    <div class="small text-muted">{{ $poste->description ?? 'Aucune description' }}</div>
                                </div>
                                <span class="badge text-bg-light">{{ $poste->affectations_count }} affecté(s)</span>
                            </div>
                        @empty
                            <div class="empty-state">Aucun poste enregistré.</div>
                        @endforelse
                    </div>
                </section>
            </div>

            <div class="col-12">
                <section class="card service-card">
                    <div class="card-header bg-white border-0 p-4 pb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">État général des disciplines</h5>
                            <p class="text-muted small mb-0">Résumé des mesures disciplinaires.</p>
                        </div>
                        <a href="{{ route('les_disciplines_CS') }}" class="btn btn-sm btn-outline-primary"
                            title="Voir les disciplines"><i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="card-body p-4">
                        @php
                            $disciplinesDeclarees = $disciplines->where('etat', 'declaree')->count();
                            $disciplinesLevees = $disciplines->where('etat', 'levee')->count();
                        @endphp
                        <div class="row g-3 mb-4">
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-light">
                                    <div class="small text-muted">Total</div>
                                    <div class="fs-3 fw-bold">{{ $disciplines->count() }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-danger-subtle">
                                    <div class="small text-danger-emphasis">Déclarées</div>
                                    <div class="fs-3 fw-bold text-danger">{{ $disciplinesDeclarees }}</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="p-3 rounded-3 bg-success-subtle">
                                    <div class="small text-success-emphasis">Levées</div>
                                    <div class="fs-3 fw-bold text-success">{{ $disciplinesLevees }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                            <p class="text-muted mb-0">Consultez le détail des mesures disciplinaires dans la table dédiée.
                            </p>
                            <a href="{{ route('les_disciplines_CS') }}" class="btn btn-primary flex-shrink-0">
                                <i class="fas fa-scale-balanced me-1"></i> Voir la table des disciplines
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection

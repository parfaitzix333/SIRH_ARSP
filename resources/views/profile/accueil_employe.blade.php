@extends('emp.base')

@section('content')
    @php
        $employe = $user->employe;
        $disciplines = $employe?->disciplines ?? collect();
        $affectation = $employe?->affectations?->sortByDesc('date_debut')->first();
    @endphp

    <style>
        .employee-profile {
            --profile-ink: #17324d;
            --profile-blue: #2274a5;
            --profile-soft: #eef6fb;
            color: var(--profile-ink);
        }

        .profile-hero {
            background: linear-gradient(120deg, #17324d 0%, #2274a5 62%, #57a6c8 100%);
            border-radius: 14px;
            color: #fff;
            overflow: hidden;
            position: relative;
        }

        .profile-hero::after {
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 50%;
            content: '';
            height: 220px;
            position: absolute;
            right: -65px;
            top: -100px;
            width: 220px;
        }

        .profile-avatar {
            align-items: center;
            background: rgba(255, 255, 255, .16);
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            display: flex;
            flex: 0 0 76px;
            font-size: 1.8rem;
            height: 76px;
            justify-content: center;
            width: 76px;
        }

        .profile-panel {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(23, 50, 77, .08);
        }

        .profile-panel h5 {
            color: var(--profile-ink);
        }

        .info-item {
            border-bottom: 1px solid #edf0f2;
            padding: .8rem 0;
        }

        .info-item:last-child {
            border-bottom: 0;
        }

        .info-label {
            color: #6b7280;
            font-size: .78rem;
            text-transform: uppercase;
        }

        .info-value {
            font-weight: 600;
        }

        .quick-link {
            align-items: center;
            background: var(--profile-soft);
            border-radius: 9px;
            color: var(--profile-ink);
            display: flex;
            gap: .7rem;
            padding: .85rem 1rem;
            text-decoration: none;
        }

        .quick-link i {
            color: var(--profile-blue);
        }

        .discipline-item {
            border-left: 3px solid #dc3545;
            padding: .75rem 1rem;
        }
    </style>

    <main class="container-fluid py-4 employee-profile">
        <section class="profile-hero p-4 p-lg-5 mb-4">
            <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3 position-relative" style="z-index: 1;">
                <div class="profile-avatar"><i class="fas fa-user"></i></div>
                <div>
                    <div class="small text-white-50 text-uppercase">Mon espace employé</div>
                    <h1 class="h3 mb-1">{{ $employe?->nom ?? $user->name }}</h1>
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="badge bg-light text-dark">Matricule {{ $employe?->matricule ?? '—' }}</span>
                        <span
                            class="badge bg-white bg-opacity-25">{{ $employe?->service?->nom_service ?? 'Service non défini' }}</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="row g-4">
            <div class="col-12 col-xl-7">
                <section class="card profile-panel h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-1">Informations professionnelles</h5>
                                <p class="text-muted small mb-0">Votre situation au sein de l'organisation.</p>
                            </div>
                            <i class="fas fa-id-card text-primary fs-4"></i>
                        </div>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6 info-item">
                                <div class="info-label">Service</div>
                                <div class="info-value">{{ $employe?->service?->nom_service ?? '—' }}</div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="info-label">Grade</div>
                                <div class="info-value">{{ $employe?->grade?->designation ?? '—' }}</div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="info-label">Date d'engagement</div>
                                <div class="info-value">{{ $employe?->date_engagement?->format('d/m/Y') ?? '—' }}</div>
                            </div>
                            <div class="col-md-6 info-item">
                                <div class="info-label">Affectation</div>
                                <div class="info-value">{{ $affectation?->poste?->designation ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-12 col-xl-5">
                <section class="card profile-panel h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h5 class="mb-1">Informations personnelles</h5>
                                <p class="text-muted small mb-0">Données enregistrées dans votre dossier.</p>
                            </div>
                            <i class="fas fa-address-card text-primary fs-4"></i>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date de naissance</div>
                            <div class="info-value">{{ $employe?->date_naissance?->format('d/m/Y') ?? '—' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Lieu de naissance</div>
                            <div class="info-value">{{ $employe?->lieu_naissance ?? '—' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Adresse e-mail</div>
                            <div class="info-value text-break">{{ $user->email }}</div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-12 col-lg-5">
                <section class="card profile-panel h-100">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Accès rapides</h5>
                        <div class="d-grid gap-2">
                            <a class="quick-link" href="{{ route('mes_conges') }}"><i
                                    class="fas fa-calendar-check"></i><span>Suivre mes congés</span><i
                                    class="fas fa-arrow-right ms-auto"></i></a>
                            <a class="quick-link" href="{{ route('mes_presences') }}"><i
                                    class="fas fa-user-clock"></i><span>Consulter mes présences</span><i
                                    class="fas fa-arrow-right ms-auto"></i></a>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-12 col-lg-7">
                <section class="card profile-panel h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Actions disciplinaires</h5>
                            <span
                                class="badge text-bg-{{ $disciplines->isEmpty() ? 'secondary' : 'danger' }}">{{ $disciplines->count() }}</span>
                        </div>
                        <div class="mt-3">
                            @forelse ($disciplines as $action)
                                <div class="discipline-item mb-2">
                                    <div class="d-flex justify-content-between gap-3">
                                        <strong>{{ $action->type ?? 'Action disciplinaire' }}</strong><small
                                            class="text-muted">{{ $action->date?->format('d/m/Y') ?? '—' }}</small></div>
                                    <div class="small text-muted mt-1">{{ $action->description ?? 'Aucune description' }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted mb-0">Aucune action disciplinaire enregistrée.</p>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection

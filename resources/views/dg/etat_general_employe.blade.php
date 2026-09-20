@extends('dg.base')

@section('content')
    <style>
        .employee-sheet h2,
        .employee-sheet h5 {
            color: #17324d;
        }

        .summary-card,
        .section-card {
            border: 0;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(23, 50, 77, .08);
        }

        .summary-card .label {
            color: #6b7280;
            font-size: .8rem;
        }

        .summary-card .value {
            color: #17324d;
            font-size: 1.7rem;
            font-weight: 700;
        }

        .identity dt {
            color: #6b7280;
            font-size: .78rem;
            font-weight: 600;
        }

        .identity dd {
            color: #17324d;
            font-weight: 600;
            margin-bottom: .8rem;
        }

        .section-card summary {
            color: #17324d;
            cursor: pointer;
            font-weight: 700;
            list-style-position: inside;
        }

        .section-card .table {
            margin-bottom: 0;
        }

        .section-card th {
            background: #f0f7fc;
            color: #17324d;
            font-size: .76rem;
            text-transform: uppercase;
        }

        .section-card td {
            vertical-align: middle;
        }

        .status-badge {
            background: #fff4cc;
            border-radius: 999px;
            color: #8a5a00;
            font-size: .75rem;
            padding: .3rem .6rem;
        }
    </style>

    <div class="container-fluid employee-sheet py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <a href="{{ route('les_employes') }}" class="btn btn-sm btn-outline-secondary mb-3"><i
                        class="fas fa-arrow-left me-1"></i>Retour aux employés</a>
                <h2 class="mb-1">Fiche de {{ $employe->nom }}</h2>
                <p class="text-muted mb-0">État général pour l’année {{ $annee?->annee ?? now()->year }}</p>
            </div>
            <span class="badge bg-primary-subtle text-primary fs-6">{{ $employe->matricule }}</span>
        </div>

        <div class="card section-card p-4 mb-4">
            <h5 class="mb-3">Informations de l’employé</h5>
            <dl class="row identity mb-0">
                <dt class="col-sm-3">Nom</dt>
                <dd class="col-sm-3">{{ $employe->nom }}</dd>
                <dt class="col-sm-3">Date d’engagement</dt>
                <dd class="col-sm-3">{{ $employe->date_engagement?->format('d/m/Y') ?? '—' }}</dd>
                <dt class="col-sm-3">Grade</dt>
                <dd class="col-sm-3">{{ $employe->grade?->designation ?? '—' }}</dd>
                <dt class="col-sm-3">Catégorie</dt>
                <dd class="col-sm-3">{{ $affectation?->categorie?->designation ?? '—' }}</dd>
                <dt class="col-sm-3">Service</dt>
                <dd class="col-sm-3">{{ $affectation?->service?->nom_service ?? ($employe->service?->nom_service ?? '—') }}
                </dd>
                <dt class="col-sm-3">Rôle</dt>
                <dd class="col-sm-3">{{ $audit?->role ?? '—' }}</dd>
                <dt class="col-sm-3">Poste</dt>
                <dd class="col-sm-3">{{ $affectation?->poste?->intitule ?? '—' }}</dd>
                <dt class="col-sm-3">Affectation</dt>
                <dd class="col-sm-3">
                    {{ $affectation?->date_debut ? \Illuminate\Support\Carbon::parse($affectation->date_debut)->format('d/m/Y') : '—' }}{{ $affectation?->date_fin ? ' au ' . \Illuminate\Support\Carbon::parse($affectation->date_fin)->format('d/m/Y') : '' }}
                </dd>
                <dt class="col-sm-3">Année</dt>
                <dd class="col-sm-3">{{ $annee?->annee ?? '—' }}</dd>
            </dl>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card summary-card p-3"><span class="label">Présences annuelles</span><span
                        class="value">{{ $presencesAnnuelles }}</span></div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card summary-card p-3"><span class="label">Absences estimées</span><span
                        class="value">{{ $absencesAnnuelles }}</span></div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card summary-card p-3"><span class="label">Demandes de congé</span><span
                        class="value">{{ $employe->demandesConges->count() }}</span></div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card summary-card p-3"><span class="label">Dossiers d’étude</span><span
                        class="value">{{ $employe->dossiersEtude->count() }}</span></div>
            </div>
        </div>

        <details class="card section-card p-4 mb-4">
            <summary>Présences et absences mensuelles</summary>
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mois</th>
                            <th>Présences</th>
                            <th>Absences estimées</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presencesMensuelles as $ligne)
                            <tr>
                                <td>{{ \Illuminate\Support\Carbon::create()->month($ligne['mois'])->locale('fr')->monthName }}
                                </td>
                                <td>{{ $ligne['presences'] }}</td>
                                <td>{{ $ligne['absences'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </details>

        <details class="card section-card p-4 mb-4">
            <summary>Demandes de congé ({{ $employe->demandesConges->count() }})</summary>
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Jours</th>
                            <th>Statut</th>
                            <th>Année</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employe->demandesConges as $demande)
                            <tr>
                                <td>{{ $demande->conge?->designation ?? '—' }}</td>
                                <td>{{ $demande->date_debut?->format('d/m/Y') }}</td>
                                <td>{{ $demande->date_fin?->format('d/m/Y') }}</td>
                                <td>{{ $demande->nombre_jour }}</td>
                                <td><span class="status-badge">{{ ucfirst($demande->statut ?? '—') }}</span></td>
                                <td>{{ $demande->annee?->annee ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Aucune demande de congé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </details>

        <details class="card section-card p-4 mb-4">
            <summary>Affectations ({{ $employe->affectations->count() }})</summary>
            <div class="table-responsive mt-3">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Catégorie</th>
                            <th>Poste</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Année</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employe->affectations as $item)
                            <tr>
                                <td>{{ $item->service?->nom_service ?? '—' }}</td>
                                <td>{{ $item->categorie?->designation ?? '—' }}</td>
                                <td>{{ $item->poste?->intitule ?? '—' }}</td>
                                <td>{{ $item->date_debut ? \Illuminate\Support\Carbon::parse($item->date_debut)->format('d/m/Y') : '—' }}
                                </td>
                                <td>{{ $item->date_fin ? \Illuminate\Support\Carbon::parse($item->date_fin)->format('d/m/Y') : '—' }}
                                </td>
                                <td>{{ $item->annee?->annee ?? '—' }}</td>
                        </tr>@empty<tr>
                                <td colspan="6" class="text-center text-muted">Aucune affectation.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </details>

        <div class="row g-4 mb-4">
            <div class="col-12 col-xl-6">
                <details class="card section-card p-4 h-100">
                    <summary>Actions disciplinaires ({{ $employe->disciplines->count() }})</summary>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Sanction</th>
                                    <th>État</th>
                                    <th>Contenu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employe->disciplines as $item)
                                    <tr>
                                        <td>{{ $item->DATE ? \Illuminate\Support\Carbon::parse($item->DATE)->format('d/m/Y') : '—' }}
                                        </td>
                                        <td>{{ $item->sanction?->designation ?? '—' }}</td>
                                        <td>{{ $item->etat ?? '—' }}</td>
                                        <td>{{ $item->contenu ?? '—' }}</td>
                                </tr>@empty<tr>
                                        <td colspan="4" class="text-center text-muted">Aucune action disciplinaire.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </details>
            </div>
            <div class="col-12 col-xl-6">
                <details class="card section-card p-4 h-100">
                    <summary>Mouvements ({{ $employe->mouvements->count() }})</summary>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mouvement</th>
                                    <th>Heure</th>
                                    <th>Année</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employe->mouvements as $item)
                                    <tr>
                                        <td>{{ $item->mouvement }}</td>
                                        <td>{{ $item->heure }}</td>
                                        <td>{{ $item->annee?->annee ?? '—' }}</td>
                                </tr>@empty<tr>
                                        <td colspan="3" class="text-center text-muted">Aucun mouvement.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </details>
            </div>
        </div>

        <details class="card section-card p-4 mb-4" open>
            <summary>Dossiers d’étude ({{ $employe->dossiersEtude->count() }})</summary>
            <form action="{{ route('dossiers-etudes.store') }}" method="POST" enctype="multipart/form-data"
                class="row g-3 align-items-end mt-2 mb-4">
                @csrf
                <input type="hidden" name="employe_id" value="{{ $employe->id }}">
                <input type="hidden" name="annee_id" value="{{ $annee?->id }}">
                <div class="col-12 col-md-4"><label class="form-label">Type de document</label><input class="form-control"
                        name="type_document" required></div>
                <div class="col-12 col-md-5"><label class="form-label">Fichier</label><input class="form-control"
                        type="file" name="fichier" required></div>
                <div class="col-12 col-md-3"><button class="btn btn-primary w-100"><i class="fas fa-plus me-1"></i>Ajouter
                        le dossier</button></div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Fichier</th>
                            <th>Année</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employe->dossiersEtude as $item)
                            <tr>
                                <td>{{ $item->type_document }}</td>
                                <td><a href="{{ route('dossiers-etudes.file', ['path' => $item->fichier]) }}"
                                        target="_blank">Ouvrir</a></td>
                                <td>{{ $item->annee?->annee ?? '—' }}</td>
                                <td>{{ $item->created_at?->format('d/m/Y') }}</td>
                        </tr>@empty<tr>
                                <td colspan="4" class="text-center text-muted">Aucun dossier d’étude.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </details>
    </div>
@endsection

</html>

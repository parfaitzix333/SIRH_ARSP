@extends('emp.base')

@section('content')
    @php
        $statuts = [
            'brouillon' => ['label' => 'Brouillon', 'class' => 'secondary'],
            'soumise' => ['label' => 'Soumise', 'class' => 'primary'],
            'validee' => ['label' => 'Validée', 'class' => 'success'],
            'refusee' => ['label' => 'Refusée', 'class' => 'danger'],
            'annulee' => ['label' => 'Annulée', 'class' => 'dark'],
        ];
        $totalDemandes = $mes_conges->count();
        $demandesEnCours = $mes_conges->whereIn('statut', ['brouillon', 'soumise'])->count();
        $demandesValidees = $mes_conges->where('statut', 'validee')->count();
        $joursAccordes = $mes_conges->where('statut', 'validee')->sum('nombre_jour');
    @endphp

    <div class="container-fluid px-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="mb-1 fw-bold text-primary">Mes congés</h2>
                <p class="text-muted mb-0">Suivez vos demandes et leur état de validation.</p>
            </div>
            <div class="d-flex gap-2 w-100 justify-content-md-end">
                <div class="input-group" style="max-width: 360px;">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="search" class="form-control" id="congeSearch" placeholder="Rechercher une demande..."
                        aria-label="Rechercher une demande">
                </div>
                <button type="button" class="btn btn-primary text-nowrap" data-bs-toggle="modal"
                    data-bs-target="#demandeCongeModal">
                    <i class="fas fa-plus me-1"></i> Demander un congé
                </button>
            </div>
        </div>

        <div class="modal fade" id="demandeCongeModal" tabindex="-1" aria-labelledby="demandeCongeLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="demandeCongeLabel">Soumettre une demande de congé</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Fermer"></button>
                    </div>
                    <form method="POST" action="{{ route('mes_conges.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-4">
                                <label class="form-label fw-semibold d-block">Mode de congé</label>
                                <div class="btn-group w-100" role="group" aria-label="Mode de congé">
                                    <input type="radio" class="btn-check" name="mode" id="modeAnnuel" value="annuel"
                                        {{ $demandeAnnuelleBloquee ? 'disabled' : 'checked' }}>
                                    <label class="btn btn-outline-primary {{ $demandeAnnuelleBloquee ? 'disabled' : '' }}"
                                        for="modeAnnuel">
                                        <i class="fas fa-calendar-check me-1"></i> Annuel
                                    </label>
                                    <input type="radio" class="btn-check" name="mode" id="modeCirconstanciel"
                                        value="circonstanciel" {{ $demandeAnnuelleBloquee ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="modeCirconstanciel">
                                        <i class="fas fa-file-pen me-1"></i> Circonstanciel
                                    </label>
                                </div>
                                @if ($demandeAnnuelleBloquee)
                                    <div class="form-text text-danger fw-semibold">Une demande annuelle est déjà soumise ou
                                        validée
                                        pour cette année. Seul le mode circonstanciel est disponible.</div>
                                @else
                                    <div class="form-text" id="modeHelp">Le congé annuel est fixé automatiquement à 30
                                        jours.</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de début <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_debut" id="date_debut" required>
                            </div>

                            <div id="circumstantialFields" class="d-none">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="conge_id" class="form-label">Type de congé <span
                                                class="text-danger">*</span></label>
                                        <select name="conge_id" id="conge_id" class="form-select" disabled>
                                            <option value="">Sélectionner un type</option>
                                            @foreach ($typesConges as $typeConge)
                                                <option value="{{ $typeConge->id }}">{{ $typeConge->designation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="date_fin" class="form-label">Date de fin <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="date_fin" id="date_fin" disabled>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <label for="motif" class="form-label">Motif</label>
                                    <textarea name="motif" id="motif" class="form-control" rows="3" placeholder="Expliquez votre demande"></textarea>
                                </div>
                                <div class="mt-3">
                                    <label for="piece_justificative" class="form-label">Pièce justificative</label>
                                    <input type="file" name="piece_justificative" id="piece_justificative"
                                        class="form-control">
                                    <div class="form-text">Facultative, 10 Mo maximum.</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i>
                                Soumettre</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="small text-muted text-uppercase">Demandes</div>
                        <div class="fs-3 fw-bold text-primary">{{ $totalDemandes }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="small text-muted text-uppercase">En cours</div>
                        <div class="fs-3 fw-bold text-warning">{{ $demandesEnCours }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="small text-muted text-uppercase">Validées</div>
                        <div class="fs-3 fw-bold text-success">{{ $demandesValidees }}</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="small text-muted text-uppercase">Jours accordés</div>
                        <div class="fs-3 fw-bold text-dark">{{ $joursAccordes }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Historique de mes demandes</h5>
                <span class="badge bg-light text-dark">{{ $totalDemandes }} demande(s)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="congesTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Période</th>
                                <th>Durée</th>
                                <th>Motif</th>
                                <th>Statut</th>
                                <th>Validation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mes_conges as $conge)
                                @php
                                    $statut = $statuts[$conge->statut] ?? [
                                        'label' => ucfirst($conge->statut),
                                        'class' => 'secondary',
                                    ];
                                @endphp
                                <tr class="conge-row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $conge->conge?->designation ?? 'Type non précisé' }}
                                        </div>
                                        <small class="text-muted">{{ $conge->annee?->annee ?? '—' }}</small>
                                    </td>
                                    <td class="text-nowrap">
                                        {{ $conge->date_debut?->format('d/m/Y') ?? '—' }}
                                        <span class="text-muted">au</span>
                                        {{ $conge->date_fin?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="text-nowrap">{{ $conge->nombre_jour }} jour(s)</td>
                                    <td class="text-muted" style="min-width: 180px;">{{ $conge->motif ?: '—' }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ $statut['class'] }}">{{ $statut['label'] }}</span>
                                    </td>
                                    <td>
                                        @if ($conge->date_validation)
                                            <div class="small">{{ $conge->date_validation->format('d/m/Y H:i') }}</div>
                                            <div class="small text-muted">
                                                {{ $conge->validePar?->name ?? 'Administration' }}</div>
                                        @else
                                            <span class="text-muted small">En attente</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="fas fa-calendar-xmark fa-2x d-block mb-2"></i>
                                        Aucune demande de congé enregistrée.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('congeSearch');
                const table = document.getElementById('congesTable');
                const annualMode = document.getElementById('modeAnnuel');
                const circumstantialMode = document.getElementById('modeCirconstanciel');
                const circumstantialFields = document.getElementById('circumstantialFields');
                const typeSelect = document.getElementById('conge_id');
                const endDate = document.getElementById('date_fin');
                const modeHelp = document.getElementById('modeHelp');

                function normalize(value) {
                    return value
                        .toLocaleLowerCase('fr-FR')
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '')
                        .trim();
                }

                function updateLeaveMode() {
                    const isCircumstantial = circumstantialMode.checked;
                    circumstantialFields.classList.toggle('d-none', !isCircumstantial);
                    typeSelect.disabled = !isCircumstantial;
                    endDate.disabled = !isCircumstantial;
                    typeSelect.required = isCircumstantial;
                    endDate.required = isCircumstantial;
                    if (modeHelp) {
                        modeHelp.textContent = isCircumstantial ?
                            'Renseignez le type, les dates et les informations utiles à votre demande.' :
                            'Le congé annuel est fixé automatiquement à 30 jours.';
                    }
                }

                annualMode?.addEventListener('change', updateLeaveMode);
                circumstantialMode?.addEventListener('change', updateLeaveMode);
                updateLeaveMode();

                input?.addEventListener('input', function() {
                    const query = normalize(this.value);
                    const rows = table?.querySelectorAll('tbody .conge-row') ?? [];
                    let visibleRows = 0;

                    rows.forEach(row => {
                        const matches = normalize(row.textContent).includes(query);
                        row.style.display = matches ? '' : 'none';
                        visibleRows += matches ? 1 : 0;
                    });

                    let emptyRow = table?.querySelector('.search-empty-row');
                    if (table && visibleRows === 0 && rows.length > 0) {
                        if (!emptyRow) {
                            emptyRow = document.createElement('tr');
                            emptyRow.className = 'search-empty-row';
                            emptyRow.innerHTML =
                                '<td colspan="7" class="text-center text-muted py-4">Aucune demande ne correspond à votre recherche.</td>';
                            table.querySelector('tbody')?.appendChild(emptyRow);
                        }
                        emptyRow.style.display = '';
                    } else if (emptyRow) {
                        emptyRow.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection

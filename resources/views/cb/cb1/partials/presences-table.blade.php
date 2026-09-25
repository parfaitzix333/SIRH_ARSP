@php
    $presences = $presences ?? collect();
    $anneeId = $anneeId ?? null;
    $actions = $actions ?? true;
@endphp

<style>
    .presence-page .presence-card {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 5px 18px rgba(23, 50, 77, .08);
    }

    .presence-page .table th {
        color: #526579;
        font-size: .76rem;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .presence-page .table td {
        vertical-align: middle;
    }
</style>

<main class="container-fluid py-4 presence-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">{{ $titre }}</h2>
            <p class="text-muted mb-0">{{ $description }}</p>
        </div>
        @if ($actions)
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutPresenceModal">
                <i class="fas fa-plus me-1"></i> Ajouter une présence
            </button>
        @endif
    </div>

    <section class="card presence-card">
        <div class="card-header bg-white border-0 p-3">
            <div class="row g-2">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="search" class="form-control" id="presenceSearch"
                            placeholder="Rechercher par matricule ou nom...">
                    </div>
                </div>
                <div class="col-md-5">
                    <select class="form-select" id="presenceFilter" aria-label="Filtrer les présences">
                        <option value="">Toutes les présences</option>
                        <option value="entree">Entrées</option>
                        <option value="sortie">Sorties</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="presencesTable">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Mouvement</th>
                        <th>Heure</th>
                        <th>Date</th>
                        <th>Source</th>
                        @if ($actions)
                            <th class="text-center">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($presences as $presence)
                        <tr class="presence-row" data-mouvement="{{ strtolower($presence->mouvement) }}">
                            <td>{{ $presence->id }}</td>
                            <td>{{ $presence->employe?->matricule ?? '—' }}</td>
                            <td class="fw-semibold">{{ $presence->employe?->nom ?? '—' }}</td>
                            <td><span
                                    class="badge text-bg-{{ $presence->mouvement === 'entree' ? 'success' : 'danger' }}">{{ ucfirst($presence->mouvement) }}</span>
                            </td>
                            <td>{{ $presence->heure }}</td>
                            <td>{{ $presence->DATE?->format('d/m/Y') ?? '—' }}</td>
                            <td>{{ $presence->SOURCE ?? '—' }}</td>
                            @if ($actions)
                                <td class="text-center text-nowrap">
                                    @if ($user->autorisation == 1)
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modifierPresenceModal{{ $presence->id }}"
                                            title="Modifier"><i class="fas fa-pen"></i></button>
                                        <form action="{{ route('presences.destroy', $presence->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Supprimer cette présence ?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Supprimer"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @else
                                        <i class="fa fa-lock text-danger fs-5"></i>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $actions ? 8 : 7 }}" class="text-center text-muted py-5">Aucune présence à
                                afficher.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div id="presenceNoResults" class="text-center text-muted py-5 d-none"><i
                class="fas fa-search fa-2x d-block mb-2"></i>Aucun résultat.</div>
    </section>
</main>

@if ($actions)
    <div class="modal fade" id="ajoutPresenceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('presences.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une présence</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label" for="presence_employe">Employé</label><select
                                class="form-select" id="presence_employe" name="employe_id" required>
                                <option value="">Sélectionner</option>
                                @foreach ($employes as $employe)
                                    <option value="{{ $employe->id }}">{{ $employe->nom }}
                                        ({{ $employe->matricule }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="presence_date">Date</label><input
                                    type="date" class="form-control" id="presence_date" name="DATE"
                                    value="{{ now()->format('Y-m-d') }}" required></div>
                            <div class="col-md-6"><label class="form-label" for="presence_heure">Heure</label><input
                                    type="time" class="form-control" id="presence_heure" name="heure" required>
                            </div>
                        </div>
                        <div class="mt-3"><label class="form-label" for="presence_mouvement">Mouvement</label><select
                                class="form-select" id="presence_mouvement" name="mouvement" required>
                                <option value="entree">Entrée</option>
                                <option value="sortie">Sortie</option>
                            </select></div>
                        <input type="hidden" name="annee_id" value="{{ $anneeId }}"><input type="hidden"
                            name="SOURCE" value="bureau">
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Annuler</button><button
                            class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($presences as $presence)
        <div class="modal fade" id="modifierPresenceModal{{ $presence->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('presences.update', $presence->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier la présence</h5><button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label"
                                    for="edit_presence_employe_{{ $presence->id }}">Employé</label><select
                                    class="form-select" id="edit_presence_employe_{{ $presence->id }}"
                                    name="employe_id" required>
                                    @foreach ($employes as $employe)
                                        <option value="{{ $employe->id }}" @selected($presence->employe_id === $employe->id)>
                                            {{ $employe->nom }} ({{ $employe->matricule }})</option>
                                    @endforeach
                                </select></div>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label"
                                        for="edit_presence_date_{{ $presence->id }}">Date</label><input
                                        type="date" class="form-control"
                                        id="edit_presence_date_{{ $presence->id }}" name="DATE"
                                        value="{{ $presence->DATE?->format('Y-m-d') }}" required></div>
                                <div class="col-md-6"><label class="form-label"
                                        for="edit_presence_heure_{{ $presence->id }}">Heure</label><input
                                        type="time" class="form-control"
                                        id="edit_presence_heure_{{ $presence->id }}" name="heure"
                                        value="{{ substr($presence->heure, 0, 5) }}" required></div>
                            </div>
                            <div class="mt-3"><label class="form-label"
                                    for="edit_presence_mouvement_{{ $presence->id }}">Mouvement</label><select
                                    class="form-select" id="edit_presence_mouvement_{{ $presence->id }}"
                                    name="mouvement" required>
                                    <option value="entree" @selected($presence->mouvement === 'entree')>Entrée</option>
                                    <option value="sortie" @selected($presence->mouvement === 'sortie')>Sortie</option>
                                </select></div>
                            <input type="hidden" name="annee_id"
                                value="{{ $presence->annee_id ?? $anneeId }}"><input type="hidden" name="SOURCE"
                                value="{{ $presence->SOURCE ?? 'bureau' }}">
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Annuler</button><button
                                class="btn btn-primary">Enregistrer</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('presenceSearch');
            const filter = document.getElementById('presenceFilter');
            const rows = document.querySelectorAll('.presence-row');
            const empty = document.getElementById('presenceNoResults');

            function filterRows() {
                const query = (search?.value || '').toLocaleLowerCase('fr-FR').trim();
                const type = filter?.value || '';
                let visible = 0;
                rows.forEach(row => {
                    const matches = row.textContent.toLocaleLowerCase('fr-FR').includes(query) && (!type ||
                        row.dataset.mouvement === type);
                    row.hidden = !matches;
                    if (matches) visible++;
                });
                empty?.classList.toggle('d-none', visible > 0 || (!query && !type));
            }
            search?.addEventListener('input', filterRows);
            filter?.addEventListener('change', filterRows);
        });
    </script>
@endpush

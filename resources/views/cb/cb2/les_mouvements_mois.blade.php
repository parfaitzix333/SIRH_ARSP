@extends('emp.base')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">Mouvements du mois</h2>
                <p class="text-muted mb-0">Gérez les entrées et sorties enregistrées ce mois.</p>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutMouvementModal"
                hidden="true">
                <i class="fas fa-plus me-1"></i> Ajouter un mouvement
            </button>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 p-3">
                <div class="row g-2">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="search" class="form-control" id="mouvementSearch"
                                placeholder="Rechercher par matricule ou nom...">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <select class="form-select" id="mouvementFilter" aria-label="Filtrer par mouvement">
                            <option value="">Tous les mouvements</option>
                            <option value="Entrée">Entrées</option>
                            <option value="Sortie">Sorties</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="mouvementsTable">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Mouvement</th>
                            <th>Heure</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($les_mouvements_mois as $mouvement)
                            <tr class="mouvement-row" data-mouvement="{{ $mouvement->mouvement }}">
                                <td>{{ $mouvement->id }}</td>
                                <td>{{ $mouvement->employe?->matricule ?? '—' }}</td>
                                <td>{{ $mouvement->employe?->nom ?? '—' }}</td>
                                <td>
                                    <span
                                        class="badge text-bg-{{ $mouvement->mouvement === 'Entrée' ? 'success' : 'danger' }}">
                                        {{ $mouvement->mouvement }}
                                    </span>
                                </td>
                                <td>{{ $mouvement->heure }}</td>
                                <td>{{ $mouvement->created_at?->format('d/m/Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">Aucun mouvement aujourd'hui.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajoutMouvementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('mouvements.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un mouvement</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label" for="ajout_employe_id">Employé</label><select
                                class="form-select" id="ajout_employe_id" name="employe_id" required>
                                <option value="">Sélectionner</option>
                                @foreach ($employes as $employe)
                                    <option value="{{ $employe->id }}">{{ $employe->nom }} ({{ $employe->matricule }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3"><label class="form-label" for="ajout_mouvement">Mouvement</label><select
                                class="form-select" id="ajout_mouvement" name="mouvement" required>
                                <option value="">Sélectionner</option>
                                <option value="Entrée">Entrée</option>
                                <option value="Sortie">Sortie</option>
                            </select></div>
                        <div><label class="form-label" for="ajout_heure">Heure</label><input type="time"
                                class="form-control" id="ajout_heure" name="heure" required></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($les_mouvements_mois as $mouvement)
        <div class="modal fade" id="modifierMouvementModal{{ $mouvement->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('mouvements.update', $mouvement->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier le mouvement</h5><button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label"
                                    for="edit_employe_{{ $mouvement->id }}">Employé</label><select class="form-select"
                                    id="edit_employe_{{ $mouvement->id }}" name="employe_id" required>
                                    @foreach ($employes as $employe)
                                        <option value="{{ $employe->id }}" @selected($mouvement->employe_id === $employe->id)>
                                            {{ $employe->nom }} ({{ $employe->matricule }})</option>
                                    @endforeach
                                </select></div>
                            <div class="mb-3"><label class="form-label"
                                    for="edit_mouvement_{{ $mouvement->id }}">Mouvement</label><select
                                    class="form-select" id="edit_mouvement_{{ $mouvement->id }}" name="mouvement"
                                    required>
                                    <option value="Entrée" @selected($mouvement->mouvement === 'Entrée')>Entrée</option>
                                    <option value="Sortie" @selected($mouvement->mouvement === 'Sortie')>Sortie</option>
                                </select></div>
                            <div><label class="form-label" for="edit_heure_{{ $mouvement->id }}">Heure</label><input
                                    type="time" class="form-control" id="edit_heure_{{ $mouvement->id }}"
                                    name="heure" value="{{ substr($mouvement->heure, 0, 5) }}" required></div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Annuler</button><button
                                class="btn btn-primary">Enregistrer</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const search = document.getElementById('mouvementSearch');
                const filter = document.getElementById('mouvementFilter');
                const rows = document.querySelectorAll('.mouvement-row');

                function filterRows() {
                    const query = (search?.value || '').toLocaleLowerCase('fr-FR').trim();
                    const type = filter?.value || '';
                    rows.forEach(row => {
                        const matchesText = row.textContent.toLocaleLowerCase('fr-FR').includes(query);
                        const matchesType = !type || row.dataset.mouvement === type;
                        row.hidden = !(matchesText && matchesType);
                    });
                }

                search?.addEventListener('input', filterRows);
                filter?.addEventListener('change', filterRows);
            });
        </script>
    @endpush
@endsection

@extends('secdg.base')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Demandes de congé</h3>
                <p class="text-muted mb-0">Demandes validées au niveau du Chef Service.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary fs-6">{{ $les_demandes_conge->count() }} demande(s)</span>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 p-3">
                <div class="input-group" style="max-width: 360px;">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                    <input type="search" class="form-control border-start-0" id="demandeSearch" placeholder="Rechercher..."
                        aria-label="Rechercher une demande">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="demandesTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Employé</th>
                            <th>Type</th>
                            <th>Période</th>
                            <th>Durée</th>
                            <th>Chef Service</th>
                            <th>Statut</th>
                            <th>SecDG</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($les_demandes_conge as $demande)
                            @php $modifiable = !$demande->valide_secDg; @endphp
                            <tr class="demande-row">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $demande->employe?->nom ?? '—' }}</div>
                                    <small class="text-muted">{{ $demande->employe?->matricule ?? '—' }}</small>
                                </td>
                                <td>{{ $demande->conge?->designation ?? '—' }}</td>
                                <td class="text-nowrap">{{ $demande->date_debut?->format('d/m/Y') }} au
                                    {{ $demande->date_fin?->format('d/m/Y') }}</td>
                                <td>{{ $demande->nombre_jour }} jour(s)</td>
                                <td><span class="badge text-bg-success">Validée</span></td>
                                <td>
                                    <span
                                        class="badge text-bg-{{ $demande->statut === 'validee' ? 'success' : ($demande->statut === 'refusee' ? 'danger' : 'warning text-dark') }}">
                                        {{ ucfirst($demande->statut) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($demande->valide_secDg)
                                        <span class="badge text-bg-success">Validée</span>
                                    @else
                                        <span class="badge text-bg-secondary">En attente</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($modifiable)
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#decisionModal{{ $demande->id }}" title="Décider">
                                            <i class="fas fa-pen-to-square"></i>
                                        </button>
                                    @elseif (!$demande->valide_national)
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#nationalModal{{ $demande->id }}"
                                            title="Validation nationale">
                                            <i class="fas fa-landmark"></i>
                                        </button>
                                    @endif
                                    @if ($demande->valide_secDg)
                                        <a href="{{ route('fiche_de_demande_conge', $demande->id) }}"
                                            class="btn btn-outline-primary btn-sm" title="Ouvrir la fiche">
                                            <i class="fas fa-file-lines"></i>
                                        </a>
                                    @endif
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editCongeModal{{ $demande->id }}" title="Modifier la demande">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <form action="{{ route('demandes-conges.destroy', $demande->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Supprimer définitivement cette demande ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                            title="Supprimer la demande">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">Aucune demande validée par le Chef
                                    Service.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($les_demandes_conge as $demande)
        <div class="modal fade" id="editCongeModal{{ $demande->id }}" tabindex="-1"
            aria-labelledby="editCongeModalLabel{{ $demande->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('demandes-conges.update', $demande->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="employe_id" value="{{ $demande->employe_id }}">
                        <input type="hidden" name="conge_id" value="{{ $demande->conge_id }}">
                        <input type="hidden" name="nombre_jour" value="{{ $demande->nombre_jour }}">
                        <input type="hidden" name="annee_id" value="{{ $demande->annee_id }}">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCongeModalLabel{{ $demande->id }}">Modifier la demande</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="date_debut_{{ $demande->id }}">Date de début</label>
                                    <input type="date" class="form-control" id="date_debut_{{ $demande->id }}"
                                        name="date_debut" value="{{ $demande->date_debut?->format('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="date_fin_{{ $demande->id }}">Date de fin</label>
                                    <input type="date" class="form-control" id="date_fin_{{ $demande->id }}"
                                        name="date_fin" value="{{ $demande->date_fin?->format('Y-m-d') }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="motif_{{ $demande->id }}">Motif</label>
                                    <textarea class="form-control" id="motif_{{ $demande->id }}" name="motif" rows="3">{{ $demande->motif }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="statut_{{ $demande->id }}">Statut</label>
                                    <select class="form-select" id="statut_{{ $demande->id }}" name="statut">
                                        <option value="brouillon" @selected($demande->statut === 'brouillon')>Brouillon</option>
                                        <option value="soumise" @selected($demande->statut === 'soumise')>Soumise</option>
                                        <option value="validee" @selected($demande->statut === 'validee')>Validée</option>
                                        <option value="refusee" @selected($demande->statut === 'refusee')>Refusée</option>
                                        <option value="annulee" @selected($demande->statut === 'annulee')>Annulée</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if (!$demande->valide_secDg)
            <div class="modal fade" id="decisionModal{{ $demande->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('valider_conge_secdg', $demande->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Décision SecDG</h5><button type="button" class="btn-close"
                                    data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>{{ $demande->employe?->nom }}</strong><br>{{ $demande->conge?->designation }} ·
                                    {{ $demande->nombre_jour }} jour(s)</p>
                                <div class="mb-3">
                                    <label class="form-label">Statut</label>
                                    <select name="statut" class="form-select">
                                        <option value="" selected>Sélectionner un statut</option>
                                        <option value="validee">Valider</option>
                                        <option value="refusee">Refuser</option>
                                    </select>
                                </div>
                                <div class="form-check mb-2"><input class="form-check-input" type="checkbox"
                                        name="valide_secDg" value="1" id="sec_{{ $demande->id }}" checked><label
                                        class="form-check-label" for="sec_{{ $demande->id }}">Validation SecDG</label>
                                </div>
                                <div class="form-check mb-3"><input class="form-check-input" type="checkbox"
                                        name="valide_national" value="1" id="nat_{{ $demande->id }}"><label
                                        class="form-check-label" for="nat_{{ $demande->id }}">Validation Directeur
                                        Général
                                        provincial</label></div>
                                <label class="form-label">Commentaire</label>
                                <textarea name="commentaire_validation" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="modal-footer"><button type="button" class="btn btn-light"
                                    data-bs-dismiss="modal">Annuler</button><button
                                    class="btn btn-primary">Enregistrer</button></div>
                        </form>
                    </div>
                </div>
            </div>
        @elseif (!$demande->valide_national)
            <div class="modal fade" id="nationalModal{{ $demande->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('valider_conge_national', $demande->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Validation nationale</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-3">Enregistrez la réponse reçue par courrier électronique.</p>
                                <label class="form-label" for="statut_national_{{ $demande->id }}">Statut final</label>
                                <select name="statut" id="statut_national_{{ $demande->id }}" class="form-select mb-3"
                                    required>
                                    <option value="validee">Approuvée</option>
                                    <option value="refusee">Refusée</option>
                                </select>
                                <label class="form-label" for="national_{{ $demande->id }}">Réponse nationale</label>
                                <select name="valide_national" id="national_{{ $demande->id }}"
                                    class="form-select mb-3" required>
                                    <option value="1">Approuvée</option>
                                    <option value="0">Refusée</option>
                                </select>
                                <label class="form-label"
                                    for="commentaire_national_{{ $demande->id }}">Commentaire</label>
                                <textarea name="commentaire_validation" id="commentaire_national_{{ $demande->id }}" class="form-control"
                                    rows="3" placeholder="Référence ou commentaire du mail reçu"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer la validation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const input = document.getElementById('demandeSearch');
                const rows = document.querySelectorAll('#demandesTable .demande-row');
                input?.addEventListener('input', () => {
                    const query = input.value.toLocaleLowerCase('fr-FR').trim();
                    rows.forEach(row => row.hidden = !row.textContent.toLocaleLowerCase('fr-FR').includes(
                        query));
                });
            });
        </script>
    @endpush
@endsection

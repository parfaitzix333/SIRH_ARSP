    @extends('cs.base')

    @section('content')
        <div class="container-fluid py-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div>
                    <h3 class="fw-bold mb-1">Demandes de congé</h3>
                    <p class="text-muted mb-0">Examinez les demandes en attente de votre service.</p>
                </div>
                <span class="badge bg-primary-subtle text-primary fs-6">
                    {{ $les_demandes_conge->count() }} demande(s)
                </span>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 p-3">
                    <div class="input-group" style="max-width: 360px;">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                        <input type="search" class="form-control border-start-0" id="demandeSearch"
                            placeholder="Rechercher..." aria-label="Rechercher une demande">
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
                                <th>Motif</th>
                                <th>Statut</th>
                                <th>Chef Service</th>
                                <th>SecDG</th>
                                <th>Validation / commentaire</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($les_demandes_conge as $demande)
                                @php
                                    $enAttente = $demande->statut === 'soumise' && !$demande->valide_secDg;
                                    $statut = match ($demande->statut) {
                                        'soumise' => ['label' => 'En attente', 'class' => 'warning text-dark'],
                                        'validee' => ['label' => 'Validée', 'class' => 'success'],
                                        'refusee' => ['label' => 'Refusée', 'class' => 'danger'],
                                        default => ['label' => ucfirst($demande->statut), 'class' => 'secondary'],
                                    };
                                @endphp
                                <tr class="demande-row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $demande->employe?->nom ?? '—' }}</div>
                                        <small class="text-muted">{{ $demande->employe?->matricule ?? '—' }}</small>
                                    </td>
                                    <td>{{ $demande->conge?->designation ?? '—' }}</td>
                                    <td class="text-nowrap">
                                        {{ $demande->date_debut?->format('d/m/Y') }} au
                                        {{ $demande->date_fin?->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $demande->nombre_jour }} jour(s)</td>
                                    <td class="text-muted">{{ $demande->motif ?: '—' }}</td>
                                    <td><span class="badge text-bg-{{ $statut['class'] }}">{{ $statut['label'] }}</span>
                                    </td>
                                    <td>
                                        @if ($demande->valide_serv)
                                            <span class="badge text-bg-success">Validée</span>
                                        @elseif ($demande->statut === 'soumise')
                                            <span class="badge text-bg-secondary">En attente</span>
                                        @else
                                            <span class="badge text-bg-danger">Rejetée</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($demande->valide_secDg)
                                            <span class="badge text-bg-success"><i
                                                    class="fas fa-check me-1"></i>Traité</span>
                                        @else
                                            <span class="badge text-bg-secondary">En attente</span>
                                        @endif
                                    </td>
                                    <td style="min-width: 220px;">
                                        @if ($demande->date_validation)
                                            <div class="small">{{ $demande->date_validation->format('d/m/Y H:i') }}</div>
                                        @endif
                                        <span class="small text-muted">{{ $demande->commentaire_validation ?: '—' }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($enAttente)
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCongeModal{{ $demande->id }}"
                                                    title="Traiter la demande">
                                                    <i class="fas fa-pen-to-square"></i>
                                                </button>
                                                <form action="{{ route('demandes-conges.destroy', $demande->id) }}"
                                                    method="POST" onsubmit="return confirm('Supprimer cette demande ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-muted small">Verrouillée</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-muted py-5">
                                        <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                        Aucune demande de congé.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @foreach ($les_demandes_conge as $demande)
            @if ($demande->statut === 'soumise' && !$demande->valide_secDg)
                <div class="modal fade" id="editCongeModal{{ $demande->id }}" tabindex="-1"
                    aria-labelledby="editCongeModalLabel{{ $demande->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('valider_conge', $demande->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editCongeModalLabel{{ $demande->id }}">Traiter la demande
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-3">
                                        <strong>{{ $demande->employe?->nom }}</strong><br>
                                        <span class="text-muted">{{ $demande->conge?->designation }} ·
                                            {{ $demande->nombre_jour }} jour(s)</span>
                                    </p>
                                    <label class="form-label fw-semibold d-block">Décision du Chef Service</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input"
                                            id="valide_serv_yes_{{ $demande->id }}" name="valide_serv" value="1"
                                            required>
                                        <label class="form-check-label"
                                            for="valide_serv_yes_{{ $demande->id }}">Valider</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input"
                                            id="valide_serv_no_{{ $demande->id }}" name="valide_serv" value="0"
                                            required>
                                        <label class="form-check-label"
                                            for="valide_serv_no_{{ $demande->id }}">Rejeter</label>
                                    </div>
                                    <div class="mt-3">
                                        <label for="commentaire_{{ $demande->id }}" class="form-label">Commentaire</label>
                                        <textarea name="commentaire_validation" id="commentaire_{{ $demande->id }}" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Enregistrer la décision</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const input = document.getElementById('demandeSearch');
                    const rows = document.querySelectorAll('#demandesTable .demande-row');

                    input?.addEventListener('input', function() {
                        const query = this.value.toLocaleLowerCase('fr-FR').trim();
                        rows.forEach(row => {
                            row.hidden = !row.textContent.toLocaleLowerCase('fr-FR').includes(query);
                        });
                    });
                });
            </script>
        @endpush
    @endsection

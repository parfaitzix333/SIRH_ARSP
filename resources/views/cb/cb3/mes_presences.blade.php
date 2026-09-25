@extends('emp.base')

@section('content')
    @php
        $entrees = $mes_presences->where('mouvement', 'entree')->count();
        $sorties = $mes_presences->where('mouvement', 'sortie')->count();
        $autorisations = $mes_presences->where('autorisation', 'oui')->count();
    @endphp

    <div class="container-fluid px-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="mb-1 fw-bold text-primary">Mes présences</h2>
                <p class="text-muted mb-0">Consultez votre historique de pointage et de mouvements.</p>
            </div>
            <div class="input-group" style="max-width: 360px;">
                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                <input type="search" class="form-control" id="presenceSearch" placeholder="Rechercher une présence..."
                    aria-label="Rechercher une présence">
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total</div>
                            <div class="fs-3 fw-bold text-primary">{{ $mes_presences->count() }}</div>
                        </div>
                        <i class="fas fa-user-clock fs-2 text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Entrées</div>
                            <div class="fs-3 fw-bold text-success">{{ $entrees }}</div>
                        </div>
                        <i class="fas fa-sign-in-alt fs-2 text-success opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Sorties</div>
                            <div class="fs-3 fw-bold text-danger">{{ $sorties }}</div>
                        </div>
                        <i class="fas fa-sign-out-alt fs-2 text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Autorisées</div>
                            <div class="fs-3 fw-bold text-warning">{{ $autorisations }}</div>
                        </div>
                        <i class="fas fa-check-circle fs-2 text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 p-3">
                <h5 class="mb-0 fw-bold">Historique des présences</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="presencesTable">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Mouvement</th>
                            <th>Autorisation</th>
                            <th>Source</th>
                            <th>Synchronisation</th>
                            <th>Année</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mes_presences as $presence)
                            <tr>
                                <td data-label="Date" class="text-nowrap">
                                    {{ $presence->DATE?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td data-label="Heure" class="text-nowrap">
                                    {{ $presence->heure ? \Illuminate\Support\Carbon::parse($presence->heure)->format('H:i') : '-' }}
                                </td>
                                <td data-label="Mouvement">
                                    <span
                                        class="badge {{ $presence->mouvement === 'entree' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                        {{ $presence->mouvement === 'entree' ? 'Entrée' : 'Sortie' }}
                                    </span>
                                </td>
                                <td data-label="Autorisation">
                                    <span
                                        class="badge {{ $presence->autorisation === 'oui' ? 'bg-warning-subtle text-warning-emphasis' : 'bg-secondary-subtle text-secondary' }}">
                                        {{ $presence->autorisation === 'oui' ? 'Oui' : 'Non' }}
                                    </span>
                                </td>
                                <td data-label="Source">{{ $presence->SOURCE ?: '-' }}</td>
                                <td data-label="Synchronisation">
                                    <span
                                        class="badge {{ $presence->synchronise ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                        {{ $presence->synchronise ? 'Synchronisée' : 'En attente' }}
                                    </span>
                                </td>
                                <td data-label="Année">{{ $presence->annee?->annee ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr id="emptyPresencesRow">
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-user-clock text-muted fs-2 mb-3"></i>
                                    <p class="text-muted mb-0">Aucune présence à afficher.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div id="noPresenceMatch" class="text-center text-muted py-4 d-none">
                Aucun résultat pour cette recherche.
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #presencesTable th,
        #presencesTable td {
            white-space: nowrap;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('presenceSearch');
            const rows = Array.from(document.querySelectorAll('#presencesTable tbody tr:not(#emptyPresencesRow)'));
            const noMatch = document.getElementById('noPresenceMatch');

            if (!search) return;

            search.addEventListener('input', function() {
                const query = search.value.trim().toLowerCase();
                let visibleRows = 0;

                rows.forEach(function(row) {
                    const isVisible = row.textContent.toLowerCase().includes(query);
                    row.classList.toggle('d-none', !isVisible);
                    visibleRows += isVisible ? 1 : 0;
                });

                noMatch?.classList.toggle('d-none', visibleRows > 0 || rows.length === 0);
            });
        });
    </script>
@endpush

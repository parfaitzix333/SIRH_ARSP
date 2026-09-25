@extends('emp.base')

@section('content')
    @php
        $disciplinesDeclarees = $mes_disciplines->where('etat', 'declaree')->count();
        $disciplinesLevees = $mes_disciplines->where('etat', 'levee')->count();
    @endphp

    <div class="container-fluid px-0">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="mb-1 fw-bold text-primary">Mes disciplines</h2>
                <p class="text-muted mb-0">Consultez vos dossiers disciplinaires et leur état de suivi.</p>
            </div>
            <div class="input-group" style="max-width: 360px;">
                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                <input type="search" class="form-control" id="disciplineSearch" placeholder="Rechercher une discipline..."
                    aria-label="Rechercher une discipline">
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Total des dossiers</div>
                            <div class="fs-3 fw-bold text-primary">{{ $mes_disciplines->count() }}</div>
                        </div>
                        <i class="fas fa-gavel fs-2 text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Déclarées</div>
                            <div class="fs-3 fw-bold text-warning">{{ $disciplinesDeclarees }}</div>
                        </div>
                        <i class="fas fa-hourglass-half fs-2 text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small">Levées</div>
                            <div class="fs-3 fw-bold text-success">{{ $disciplinesLevees }}</div>
                        </div>
                        <i class="fas fa-check-circle fs-2 text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 p-3">
                <h5 class="mb-0 fw-bold">Historique disciplinaire</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="disciplinesTable">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Sanction</th>
                            <th>État</th>
                            <th>Motif / contenu</th>
                            <th>Année</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mes_disciplines as $discipline)
                            <tr>
                                <td data-label="Date" class="text-nowrap">
                                    {{ $discipline->DATE?->format('d/m/Y') ?? '-' }}
                                </td>
                                <td data-label="Sanction">{{ $discipline->sanction?->designation ?? 'Aucune' }}</td>
                                <td data-label="État">
                                    <span
                                        class="badge {{ $discipline->etat === 'levee' ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis' }}">
                                        {{ $discipline->etat === 'levee' ? 'Levée' : 'Déclarée' }}
                                    </span>
                                </td>
                                <td data-label="Motif / contenu" class="discipline-content">{{ $discipline->contenu }}</td>
                                <td data-label="Année">{{ $discipline->annee?->annee ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr id="emptyDisciplinesRow">
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-gavel text-muted fs-2 mb-3"></i>
                                    <p class="text-muted mb-0">Aucun dossier disciplinaire à afficher.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div id="noDisciplineMatch" class="text-center text-muted py-4 d-none">
                Aucun résultat pour cette recherche.
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .discipline-content {
            min-width: 280px;
            max-width: 520px;
            white-space: normal;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('disciplineSearch');
            const rows = Array.from(document.querySelectorAll(
                '#disciplinesTable tbody tr:not(#emptyDisciplinesRow)'));
            const noMatch = document.getElementById('noDisciplineMatch');

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

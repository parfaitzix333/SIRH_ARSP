@extends('emp.base')

@section('content')
    <style>
        .employees-page .card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(23, 50, 77, .08);
        }

        .employees-page .table th {
            color: #526579;
            font-size: .78rem;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .employees-page .table td {
            vertical-align: middle;
        }
    </style>

    <main class="container-fluid py-4 employees-page">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Liste des employés</h1>
                <p class="text-muted mb-0">Consultez les informations du personnel.</p>
            </div>
            <span class="badge bg-primary-subtle text-primary fs-6 align-self-start align-self-md-center">
                {{ $employes->count() }} employé(s)
            </span>
        </div>

        <section class="card">
            <div class="card-header bg-white border-0 p-3">
                <div class="input-group" style="max-width: 480px;">
                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-search"></i></span>
                    <input type="search" class="form-control border-start-0" id="employeSearch"
                        placeholder="Rechercher par matricule, nom, grade ou service..." aria-label="Rechercher un employé">
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="employesTable">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Fonction</th>
                            <th>Grade</th>
                            <th>Service / Domaine</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employes as $employe)
                            @php $audit = $employe->audits->sortByDesc('created_at')->first(); @endphp
                            <tr class="employe-row">
                                <td>{{ $employe->id }}</td>
                                <td>{{ $employe->matricule ?? '—' }}</td>
                                <td class="fw-semibold">{{ $employe->nom }}</td>
                                <td>{{ $audit?->role ?? '—' }}</td>
                                <td>{{ $employe->grade?->designation ?? '—' }}</td>
                                <td>
                                    {{ $employe->service?->nom_service ?? '—' }}
                                    <span class="badge text-bg-primary ms-1">{{ $employe->service?->domaine ?? '—' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Aucun employé enregistré.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div id="employeNoResults" class="text-center text-muted py-5 d-none">
                <i class="fas fa-search fa-2x d-block mb-2"></i>
                Aucun employé ne correspond à votre recherche.
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const input = document.getElementById('employeSearch');
                const rows = document.querySelectorAll('.employe-row');
                const empty = document.getElementById('employeNoResults');

                input?.addEventListener('input', function() {
                    const query = this.value.toLocaleLowerCase('fr-FR').trim();
                    let visible = 0;
                    rows.forEach(row => {
                        const match = row.textContent.toLocaleLowerCase('fr-FR').includes(query);
                        row.hidden = !match;
                        if (match) visible++;
                    });
                    empty?.classList.toggle('d-none', visible > 0 || query === '');
                });
            });
        </script>
    @endpush
    </div>
@endsection

@extends('secdg.base')

@section('content')
    <style>
        .annees-table th:last-child,
        .annees-table td:last-child {
            width: 150px;
        }

        .table-actions {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            white-space: nowrap;
        }

        .table-actions form {
            display: inline-flex;
            margin: 0;
        }

        .table-actions .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            padding: 0;
            border-radius: 8px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }

        .table-actions .btn-action:hover,
        .table-actions .btn-action:focus-visible {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.14);
        }

        .table-actions .btn-action i {
            font-size: 1rem;
        }

        /* Cartes statistiques */
        .stat-card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border-radius: 14px;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 .75rem 1.5rem rgba(15, 23, 42, .12) !important;
        }

        .stat-icon-wrapper {
            width: 52px;
            height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.4rem;
        }

        /* Table */
        .annees-table thead th {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #64748b;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
            padding-top: .9rem;
            padding-bottom: .9rem;
        }

        .annees-table tbody tr {
            transition: background-color 0.15s ease;
        }

        .annees-table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Badge statut */
        .badge-statut {
            font-weight: 500;
            padding: .45em .8em;
            font-size: .78rem;
            border-radius: 30px;
        }

        /* Empty state */
        .empty-state {
            padding: 3.5rem 1rem;
        }

        .empty-state i {
            font-size: 3.5rem;
            opacity: .35;
        }

        /* Barre de recherche */
        .search-wrapper {
            position: relative;
            max-width: 280px;
            width: 100%;
        }

        .search-wrapper .bi-search {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .search-wrapper input {
            padding-left: 36px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .search-wrapper input:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 .2rem rgba(59, 130, 246, .15);
        }

        .search-wrapper .clear-search {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #94a3b8;
            padding: 4px 6px;
            border-radius: 6px;
            display: none;
            cursor: pointer;
        }

        .search-wrapper .clear-search:hover {
            color: #475569;
            background: #f1f5f9;
        }

        .search-wrapper.has-value .clear-search {
            display: inline-flex;
        }

        /* Animation d'apparition des modals */
        .modal.fade .modal-dialog {
            transition: transform .3s ease-out, opacity .3s ease-out;
        }

        @media (max-width: 576px) {

            .annees-table th:last-child,
            .annees-table td:last-child {
                width: 132px;
            }

            .table-actions {
                gap: 0.25rem;
            }

            .table-actions .btn-action {
                width: 32px;
                height: 32px;
                border-radius: 7px;
            }

            .stat-icon-wrapper {
                width: 44px;
                height: 44px;
                font-size: 1.15rem;
            }

            .search-wrapper {
                max-width: 100%;
            }
        }
    </style>

    <div class="container-fluid py-4">

        {{-- Messages flash --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Veuillez corriger les erreurs suivantes :</strong>
                <ul class="mb-0 mt-2 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
            </div>
        @endif

        {{-- En-tête --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-calendar3 me-2 text-primary"></i>
                    Gestion des années
                </h3>
                <p class="text-muted mb-0">
                    Gestion des années d'exercices / administratives
                </p>
            </div>

            <button type="button" class="btn btn-primary px-3 py-2 shadow-sm" data-bs-toggle="modal"
                data-bs-target="#addModal">
                <i class="fas fa-plus-circle me-1"></i>
                Nouvelle année
            </button>
        </div>

        {{-- Statistiques --}}
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card stat-card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-semibold"
                                    style="font-size:.72rem;letter-spacing:.5px;">
                                    Total des années
                                </small>
                                <h3 class="fw-bold mb-0 mt-1">{{ count($les_annees) }}</h3>
                            </div>
                            <div class="stat-icon-wrapper bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-calendar3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-semibold"
                                    style="font-size:.72rem;letter-spacing:.5px;">
                                    Années actives
                                </small>
                                <h3 class="fw-bold mb-0 mt-1 text-success">
                                    {{ count($les_annees->where('statut', 'active')) }}
                                </h3>
                            </div>
                            <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-semibold"
                                    style="font-size:.72rem;letter-spacing:.5px;">
                                    Années inactives
                                </small>
                                <h3 class="fw-bold mb-0 mt-1 text-secondary">
                                    {{ count($les_annees->where('statut', 'inactive')) }}
                                </h3>
                            </div>
                            <div class="stat-icon-wrapper bg-secondary bg-opacity-10 text-secondary">
                                <i class="bi bi-dash-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Tableau --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white py-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-list-ul me-2 text-muted"></i>
                        Liste des années
                        <span class="badge bg-light text-dark border ms-1" id="resultCount">
                            {{ count($les_annees) }}
                        </span>
                    </h5>

                    <div class="search-wrapper" id="searchWrapper">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Rechercher une année..."
                            autocomplete="off" aria-label="Rechercher une année">
                        <button type="button" class="clear-search" id="clearSearch" aria-label="Effacer la recherche">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 annees-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width:60px;">#</th>
                                <th>Année</th>
                                <th>Statut</th>
                                <th>Date de création</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="anneesTable">
                            @forelse($les_annees as $annee)
                                <tr>
                                    <td class="text-muted fw-semibold">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="fw-bold">
                                        {{ $annee->annee }}
                                    </td>

                                    <td>
                                        @if ($annee->statut === 'active')
                                            <span class="badge bg-success badge-statut">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Actif
                                            </span>
                                        @else
                                            <span class="badge bg-secondary badge-statut">
                                                <i class="bi bi-dash-circle me-1"></i>
                                                Inactif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-muted">
                                        <i class="bi bi-clock me-1 small"></i>
                                        {{ $annee->created_at ? $annee->created_at->format('d/m/Y H:i') : '-' }}
                                    </td>

                                    <td class="text-center">
                                        @if ($user->autorisation == true)
                                            <div class="table-actions"
                                                aria-label="Actions pour l'année {{ $annee->annee }}">

                                                {{-- Modifier --}}
                                                <button type="button" class="btn btn-outline-primary btn-action"
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $annee->id }}"
                                                    title="Modifier" aria-label="Modifier l'année {{ $annee->annee }}"
                                                    data-bs-toggle-tooltip>
                                                    <i class="fas fa-pen"></i>
                                                </button>

                                                {{-- Changer le statut --}}
                                                <form action="{{ route('annees.update', $annee->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="annee" value="{{ $annee->annee }}">
                                                    <input type="hidden" name="statut"
                                                        value="{{ $annee->statut === 'active' ? 'inactive' : 'active' }}">

                                                    <button type="submit" class="btn btn-outline-warning btn-action"
                                                        title="{{ $annee->statut === 'active' ? 'Désactiver' : 'Activer' }}"
                                                        aria-label="{{ $annee->statut === 'active' ? 'Désactiver' : 'Activer' }} l'année {{ $annee->annee }}">
                                                        @if ($annee->statut === 'active')
                                                            <i class="fas fa-toggle-on"></i>
                                                        @else
                                                            <i class="fas fa-toggle-off"></i>
                                                        @endif
                                                    </button>
                                                </form>

                                                {{-- Supprimer --}}
                                                <form action="{{ route('annees.destroy', $annee->id) }}" method="POST"
                                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer l\'année {{ $annee->annee }} ? Cette action est irréversible.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-action"
                                                        title="Supprimer"
                                                        aria-label="Supprimer l'année {{ $annee->annee }}">
                                                        <i class="fas fa-trash-can"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <i class="fa fa-lock fs-3 text-danger"></i>
                                        @endif
                                    </td>
                                </tr>

                                {{-- Modal modification --}}
                                <div class="modal fade" id="editModal{{ $annee->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel{{ $annee->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow">
                                            <form action="{{ route('annees.update', $annee->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-header bg-light">
                                                    <h5 class="modal-title" id="editModalLabel{{ $annee->id }}">
                                                        <i class="fas fa-pen-to-square me-2 text-primary"></i>
                                                        Modifier l'année
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Fermer"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            Année <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="number" name="annee" class="form-control"
                                                            value="{{ $annee->annee }}" min="1900" max="2100"
                                                            required>
                                                        <small class="text-muted">Entre 1900 et 2100</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            Statut <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="statut" class="form-select" required>
                                                            <option value="active"
                                                                {{ $annee->statut === 'active' ? 'selected' : '' }}>
                                                                Actif
                                                            </option>
                                                            <option value="inactive"
                                                                {{ $annee->statut === 'inactive' ? 'selected' : '' }}>
                                                                Inactif
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="modal-footer bg-light">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        <i class="fas fa-xmark me-1"></i> Annuler
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-floppy-disk me-1"></i> Enregistrer
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center empty-state">
                                        <i class="bi bi-calendar-x text-muted d-block mb-3"></i>
                                        <h6 class="fw-semibold text-muted">Aucune année enregistrée</h6>
                                        <p class="text-muted small mb-3">
                                            Commencez par ajouter votre première année d'exercice.
                                        </p>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addModal">
                                            <i class="fas fa-plus-circle me-1"></i>
                                            Ajouter une année
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Message aucun résultat (recherche) --}}
                <div id="noResult" class="text-center py-5 d-none">
                    <i class="bi bi-search fs-1 text-muted d-block mb-3 opacity-50"></i>
                    <p class="text-muted mb-0">Aucun résultat ne correspond à votre recherche.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal ajout --}}
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('annees.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="addModalLabel">
                            <i class="fas fa-plus-circle me-2 text-primary"></i>
                            Nouvelle année
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Année <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="annee" class="form-control" placeholder="Exemple : 2026"
                                min="1900" max="2100" value="{{ old('annee') }}" required>
                            <small class="text-muted">Entre 1900 et 2100</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Statut <span class="text-danger">*</span>
                            </label>
                            <select name="statut" class="form-select" required>
                                <option value="inactive" {{ old('statut') === 'inactive' ? 'selected' : '' }}>
                                    Inactif
                                </option>
                                <option value="active" {{ old('statut') === 'active' ? 'selected' : '' }}>
                                    Actif
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-xmark me-1"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-floppy-disk me-1"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Recherche dynamique --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('anneesTable');
            const searchWrapper = document.getElementById('searchWrapper');
            const clearSearch = document.getElementById('clearSearch');
            const resultCount = document.getElementById('resultCount');
            const noResult = document.getElementById('noResult');

            // Normalisation (supprime les accents)
            const normalize = (str) =>
                str.toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');

            let debounceTimer = null;

            function filterTable() {
                const search = normalize(searchInput.value.trim());
                const rows = tableBody.querySelectorAll('tr:not(.empty-row)');
                let visibleCount = 0;

                // Gestion de l'état "vide" initial (aucune donnée)
                if (rows.length === 0) {
                    return;
                }

                rows.forEach(function(row) {
                    const text = normalize(row.textContent);
                    const match = text.includes(search);

                    row.style.display = match ? '' : 'none';
                    if (match) visibleCount++;
                });

                // Compteur de résultats
                resultCount.textContent = visibleCount;

                // Message "aucun résultat"
                if (visibleCount === 0 && search !== '') {
                    noResult.classList.remove('d-none');
                } else {
                    noResult.classList.add('d-none');
                }

                // Bouton clear
                searchWrapper.classList.toggle('has-value', searchInput.value.length > 0);
            }

            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(filterTable, 150);
            });

            // Effacer la recherche
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.focus();
                filterTable();
            });

            // Raccourci clavier : Ctrl+K ou "/" pour focus la recherche
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    searchInput.focus();
                } else if (e.key === 'Escape' && document.activeElement === searchInput) {
                    searchInput.value = '';
                    filterTable();
                }
            });

            // Réouvrir automatiquement le modal d'ajout si erreurs de validation
            @if ($errors->any() && old('_method') !== 'PUT')
                const addModal = new bootstrap.Modal(document.getElementById('addModal'));
                addModal.show();
            @endif
        });
    </script>
@endsection

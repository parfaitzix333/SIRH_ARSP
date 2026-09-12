@extends('dg.base')

@section('content')
    <style>
        .table-wrapper {
            position: relative;
        }

        .table-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .table-actions .left-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .table-actions .right-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-clear-all {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 0.5rem 1.25rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-clear-all:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-clear-all:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .btn-delete-selected {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 0.5rem 1.25rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: none;
        }

        .btn-delete-selected.show {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-delete-selected:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }

        .selection-info {
            font-size: 0.85rem;
            color: #6b7280;
            display: none;
        }

        .selection-info.show {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }

        .selection-info strong {
            color: #1f2937;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
            transition: transform .15s ease;
        }

        .custom-checkbox:hover {
            transform: scale(1.1);
        }

        #historiqueTable tbody tr.is-selected {
            background: #eef2ff !important;
        }

        #historiqueTable thead th {
            position: sticky;
            top: 0;
            background: #f8fafc;
            z-index: 2;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .4px;
            color: #64748b;
            font-weight: 600;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid transparent;
            background: transparent;
            transition: all .2s ease;
            cursor: pointer;
        }

        .btn-icon.btn-delete {
            color: #ef4444;
            border-color: #fee2e2;
            background: #fef2f2;
        }

        .btn-icon.btn-delete:hover {
            background: #ef4444;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(239, 68, 68, .3);
        }

        .search-wrapper {
            position: relative;
            max-width: 480px;
            width: 100%;
        }

        .search-wrapper .fas.fa-search {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }

        .search-wrapper input {
            padding-left: 40px;
            padding-right: 90px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            height: 44px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .search-wrapper input:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 .2rem rgba(102, 126, 234, .15);
        }

        .search-wrapper .clear-search {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: #94a3b8;
            padding: 4px 8px;
            border-radius: 6px;
            display: none;
            cursor: pointer;
            font-size: .85rem;
        }

        .search-wrapper .clear-search:hover {
            color: #475569;
            background: #f1f5f9;
        }

        .search-wrapper.has-value .clear-search {
            display: inline-flex;
        }

        .search-result-count {
            font-size: .8rem;
            color: #64748b;
            margin-top: .4rem;
            display: block;
        }

        /* IP badge */
        .ip-badge {
            font-family: 'Courier New', monospace;
            font-size: .78rem;
            background: #f1f5f9;
            color: #334155;
            padding: .3em .6em;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }

        /* Année badge */
        .annee-badge {
            font-weight: 600;
            font-size: .78rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: .35em .8em;
            border-radius: 30px;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            padding: 1.5rem 0;
        }

        .pagination-container .pagination {
            margin: 0;
        }

        .pagination-container .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }

        .pagination-container .page-link {
            color: #667eea;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .pagination-container .page-link:hover {
            background: #f3f4f6;
            border-color: #667eea;
        }

        @media (max-width: 768px) {
            .table-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .table-actions .left-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .table-actions .right-actions {
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-clear-all,
            .btn-delete-selected {
                width: 100%;
                justify-content: center;
            }

            .search-wrapper {
                max-width: 100%;
            }
        }
    </style>

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h2>
                        <i class="fas fa-history"></i> Historique des actions
                    </h2>
                    <p>Journal des actions réalisées par les utilisateurs</p>
                </div>
                <div>
                    <span class="badge bg-primary text-white rounded-pill px-3 py-2">
                        <i class="fas fa-list me-1"></i>
                        Total: {{ $historiques->total() }} enregistrement(s)
                    </span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-modern alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-modern alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Barre de recherche --}}
        <div class="search-wrapper mb-3" id="searchInputContainer">
            <i class="fas fa-search"></i>
            <input type="search" id="searchInput" class="form-control"
                placeholder="Rechercher par action, utilisateur, IP, année..." autocomplete="off"
                aria-label="Rechercher dans l'historique">
            <button type="button" class="clear-search" id="clearSearch" aria-label="Effacer la recherche">
                <i class="fas fa-times"></i> Effacer
            </button>
            <small class="search-result-count" id="resultCount" role="status"></small>
        </div>

        {{-- Form de suppression en masse (isolé) --}}
        <form id="deleteForm" action="{{ route('deleteSelected') }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
            <div id="deleteFormInputs"></div>
        </form>

        {{-- Actions du tableau --}}
        <div class="table-actions">
            <div class="left-actions">
                <label class="d-flex align-items-center gap-2 mb-0" for="selectAllCheckbox">
                    <input type="checkbox" id="selectAllCheckbox" class="custom-checkbox" aria-label="Tout sélectionner">
                    <span class="text-muted small mb-0">Tout sélectionner</span>
                </label>
                <span class="selection-info" id="selectionInfo" role="status" aria-live="polite">
                    <i class="fas fa-check-circle text-success"></i>
                    <span id="selectedCount">0</span> sélectionné(s)
                </span>
            </div>
            <div class="right-actions">
                <button type="button" class="btn-delete-selected" id="deleteSelectedBtn">
                    <i class="fas fa-trash-alt"></i> Supprimer sélectionnés
                </button>
                <button type="button" class="btn-clear-all" id="clearAllBtn"
                    {{ $historiques->total() === 0 ? 'disabled' : '' }}>
                    <i class="fas fa-trash"></i> Tout supprimer
                </button>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="table-wrapper">
            <table class="table table-striped align-middle" id="historiqueTable">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;">
                            <input type="checkbox" id="selectAllCheckboxHeader" class="custom-checkbox"
                                aria-label="Tout sélectionner">
                        </th>
                        <th scope="col">#ID</th>
                        <th scope="col">Utilisateur</th>
                        <th scope="col">Action</th>
                        <th scope="col">IP</th>
                        <th scope="col">Année</th>
                        <th scope="col">Date</th>
                        <th scope="col" style="width: 100px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historiques as $h)
                        <tr data-row>
                            <td>
                                <input type="checkbox" name="selected[]" value="{{ $h->id }}"
                                    class="custom-checkbox row-checkbox" form="deleteForm"
                                    aria-label="Sélectionner l'historique #{{ $h->id }}">
                            </td>

                            <td class="fw-bold text-primary">#{{ $h->id }}</td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                                        style="width:32px;height:32px;">
                                        <i class="fas fa-user-circle text-primary"></i>
                                    </div>
                                    <span>{{ $h->user?->name ?? 'Système' }}</span>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    {{ $h->action }}
                                </span>
                            </td>

                            <td>
                                @if ($h->ip)
                                    <span class="ip-badge">
                                        <i class="fas fa-network-wired me-1"></i>{{ $h->ip }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            <td>
                                @if ($h->annee)
                                    <span class="annee-badge">
                                        <i class="fas fa-calendar-alt me-1"></i>{{ $h->annee->annee }}
                                    </span>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>

                            <td class="text-muted">
                                <i class="far fa-clock me-1"></i>
                                {{ $h->created_at?->format('d/m/Y H:i') }}
                            </td>

                            <td class="text-center">
                                <form action="{{ route('historiques.destroy', $h->id) }}" method="POST"
                                    onsubmit="return confirm('Supprimer cet historique ?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" title="Supprimer"
                                        aria-label="Supprimer l'historique #{{ $h->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr data-empty-row>
                            <td colspan="8" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-history"></i>
                                    <h4>Historique vide</h4>
                                    <p class="mb-0">Aucune action enregistrée pour le moment</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Aucun résultat --}}
            <div id="noResult" class="text-center py-5 d-none">
                <i class="fas fa-search fs-1 text-muted opacity-50 d-block mb-3"></i>
                <p class="text-muted mb-0">Aucun résultat ne correspond à votre recherche.</p>
            </div>

            {{-- Pagination --}}
            @if ($historiques->hasPages())
                <div class="pagination-container">
                    {{ $historiques->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const normalize = (str) =>
                (str || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');

            const tableBody = document.querySelector('#historiqueTable tbody');
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const selectAllHeader = document.getElementById('selectAllCheckboxHeader');
            const selectionInfo = document.getElementById('selectionInfo');
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            const selectedCountEl = document.getElementById('selectedCount');
            const searchInput = document.getElementById('searchInput');
            const searchWrapper = document.getElementById('searchInputContainer');
            const clearSearch = document.getElementById('clearSearch');
            const resultCount = document.getElementById('resultCount');
            const noResult = document.getElementById('noResult');

            // ===== SÉLECTION =====
            function getRowCheckboxes() {
                return Array.from(document.querySelectorAll('.row-checkbox'));
            }

            function updateSelectionInfo() {
                const checked = document.querySelectorAll('.row-checkbox:checked');
                const count = checked.length;

                getRowCheckboxes().forEach(cb => {
                    const tr = cb.closest('tr');
                    if (tr) tr.classList.toggle('is-selected', cb.checked);
                });

                if (count > 0) {
                    selectionInfo.classList.add('show');
                    selectedCountEl.textContent = count;
                    deleteBtn.classList.add('show');
                } else {
                    selectionInfo.classList.remove('show');
                    deleteBtn.classList.remove('show');
                }

                const all = getRowCheckboxes();
                const allChecked = all.length > 0 && all.every(cb => cb.checked);
                const someChecked = all.some(cb => cb.checked);

                [selectAllCheckbox, selectAllHeader].forEach(el => {
                    if (!el) return;
                    el.checked = allChecked;
                    el.indeterminate = !allChecked && someChecked;
                });
            }

            if (tableBody) {
                tableBody.addEventListener('change', function(e) {
                    if (e.target.classList.contains('row-checkbox')) {
                        updateSelectionInfo();
                    }
                });
            }

            [selectAllCheckbox, selectAllHeader].forEach(el => {
                if (!el) return;
                el.addEventListener('change', function() {
                    const checked = this.checked;
                    getRowCheckboxes().forEach(cb => cb.checked = checked);
                    updateSelectionInfo();
                });
            });

            // ===== SUPPRESSION SÉLECTIONNÉS =====
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    const checked = document.querySelectorAll('.row-checkbox:checked');
                    if (checked.length === 0) {
                        alert('Veuillez sélectionner au moins un historique à supprimer.');
                        return;
                    }

                    if (!confirm('⚠️ Supprimer les ' + checked.length +
                            ' historiques sélectionnés ? Cette action est irréversible.')) {
                        return;
                    }

                    const container = document.getElementById('deleteFormInputs');
                    container.innerHTML = '';
                    checked.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected[]';
                        input.value = cb.value;
                        container.appendChild(input);
                    });

                    document.getElementById('deleteForm').submit();
                });
            }

            // ===== TOUT SUPPRIMER =====
            const clearAllBtn = document.getElementById('clearAllBtn');
            if (clearAllBtn) {
                clearAllBtn.addEventListener('click', function() {
                    const total = {{ (int) $historiques->total() }};
                    if (total === 0) {
                        alert('Aucun historique à supprimer.');
                        return;
                    }

                    if (confirm('⚠️ Supprimer TOUS les ' + total +
                            ' historiques ? Cette action est irréversible.')) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route('historiques.clearAll') }}';
                        form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            // ===== RECHERCHE =====
            let debounceTimer = null;
            const dataRows = () => Array.from(document.querySelectorAll('#historiqueTable tbody tr[data-row]'));

            function filterTable() {
                const search = normalize(searchInput.value.trim());
                const rows = dataRows();
                let visible = 0;

                rows.forEach(row => {
                    const match = normalize(row.innerText).includes(search);
                    row.style.display = match ? '' : 'none';
                    if (match) visible++;
                });

                if (search === '') {
                    resultCount.textContent = '';
                } else {
                    resultCount.textContent = visible + ' résultat(s) sur ' + rows.length;
                }

                noResult.classList.toggle('d-none', !(visible === 0 && search !== ''));
                searchWrapper.classList.toggle('has-value', searchInput.value.length > 0);
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(filterTable, 150);
                });
            }

            if (clearSearch) {
                clearSearch.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.focus();
                    filterTable();
                });
            }

            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    searchInput?.focus();
                } else if (e.key === 'Escape' && document.activeElement === searchInput) {
                    searchInput.value = '';
                    filterTable();
                }
            });

            // ===== AUTO-FERMETURE DES ALERTES =====
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            updateSelectionInfo();
        });
    </script>
@endsection

@extends('emp.base')

@section('content')
    <style>
        #listeNonLus a.communique-item--unread {
            background-color: #dbe7f3 !important;
            /* bleu très clair, légèrement plus sombre que le blanc */
            border-left: 5px solid #0a4b7a !important;
            transition: background-color 0.2s ease;
        }

        #listeNonLus a.communique-item--unread:hover,
        #listeNonLus a.communique-item--unread:focus {
            background-color: #c9dbee !important;
            /* un peu plus sombre au survol */
        }

        #listeNonLus a.communique-item--unread .text-dark {
            color: #102a43 !important;
        }

        #listeNonLus a.communique-item--unread .text-muted {
            color: #3d5a75 !important;
            /* gris-bleu plus lisible */
        }
    </style>

    @if (View::hasSection('contenu_comm'))
        @yield('contenu_comm')
    @else
        <div class="container-fluid px-0">

            {{-- En-tête --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h2 class="mb-1 fw-bold text-primary">
                        <i class="fas fa-bullhorn me-2"></i>Communiqués
                    </h2>
                    <p class="text-muted mb-0">
                        Consultez les informations et annonces importantes destinées à votre compte.
                    </p>
                </div>
                <div class="w-100 w-md-50" style="max-width: 420px;">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0"
                            placeholder="Rechercher un communiqué..." id="searchInput"
                            aria-label="Rechercher un communiqué">
                    </div>
                </div>
            </div>

            {{-- Statistiques rapides --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                                style="width:48px;height:48px;">
                                <i class="fas fa-envelope text-danger"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold lh-1">{{ $mes_communiques_non_lu->count() }}</div>
                                <div class="small text-muted">Non lus</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                                style="width:48px;height:48px;">
                                <i class="fas fa-envelope-open text-success"></i>
                            </div>
                            <div>
                                <div class="fs-4 fw-bold lh-1">{{ $mes_communiques_lu->count() }}</div>
                                <div class="small text-muted">Déjà lus</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="small text-muted">Total</div>
                                <div class="fs-4 fw-bold lh-1">
                                    {{ $mes_communiques_non_lu->count() + $mes_communiques_lu->count() }}
                                </div>
                            </div>
                            <i class="fas fa-chart-simple fa-2x text-primary opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">

                {{-- Colonne : Non lus --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 d-flex align-items-center gap-2">
                                <span class="badge bg-danger rounded-pill">{{ $mes_communiques_non_lu->count() }}</span>
                                <span>Non lus</span>
                            </h4>
                            @if ($mes_communiques_non_lu->isNotEmpty())
                                <span class="small text-muted">
                                    <i class="fas fa-circle text-danger me-1" style="font-size: 8px;"></i>
                                    À consulter
                                </span>
                            @endif
                        </div>
                        <div class="card-body pt-3">
                            <div class="list-group list-group-flush" id="listeNonLus">
                                @forelse ($mes_communiques_non_lu as $lecture)
                                    <a href="{{ route('lecture', $lecture->id) }}"
                                        class="list-group-item list-group-item-action border-0 rounded-4 mb-2 px-3 py-3 shadow-sm communique-item communique-item--unread"
                                        data-titre="{{ strtolower($lecture->communique->titre) }}"
                                        data-contenu="{{ strtolower($lecture->communique->contenu) }}">
                                        <div class="d-flex justify-content-between gap-3 align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="fw-semibold text-dark mb-1">
                                                    {{ $lecture->communique->titre }}
                                                </div>
                                                <div class="small text-muted">
                                                    {{ Str::limit($lecture->communique->contenu, 90) }}
                                                </div>
                                            </div>
                                            <span class="badge text-bg-primary rounded-pill flex-shrink-0">Nouveau</span>
                                        </div>
                                        <div class="small text-muted mt-2 d-flex align-items-center">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Publié le {{ $lecture->communique->created_at->format('d/m/Y à H:i') }}
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-muted text-center py-5">
                                        <i class="fas fa-inbox fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                        <p class="mb-0">Aucun communiqué non lu.</p>
                                        <small class="text-muted">Vous êtes à jour !</small>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Colonne : Déjà lus --}}
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pb-0 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 d-flex align-items-center gap-2">
                                <span class="badge bg-success rounded-pill">{{ $mes_communiques_lu->count() }}</span>
                                <span>Déjà lus</span>
                            </h4>
                            @if ($mes_communiques_lu->isNotEmpty())
                                <span class="small text-muted">
                                    <i class="fas fa-check-circle text-success me-1"></i>
                                    Archivés
                                </span>
                            @endif
                        </div>
                        <div class="card-body pt-3">
                            <div class="list-group list-group-flush" id="listeLus">
                                @forelse ($mes_communiques_lu as $lecture)
                                    <a href="{{ route('lecture', $lecture->id) }}"
                                        class="list-group-item list-group-item-action border-0 rounded-4 mb-2 px-3 py-3 shadow-sm communique-item"
                                        data-titre="{{ strtolower($lecture->communique->titre) }}"
                                        data-contenu="{{ strtolower($lecture->communique->contenu) }}"
                                        style="border-left: 5px solid #6c757d !important;">
                                        <div class="fw-semibold text-dark mb-1">
                                            {{ $lecture->communique->titre }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ Str::limit($lecture->communique->contenu, 90) }}
                                        </div>
                                        <div class="d-flex flex-wrap gap-3 mt-2">
                                            <div class="small text-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Lu le {{ $lecture->lu_a?->format('d/m/Y à H:i') ?? '—' }}
                                            </div>
                                            <div class="small text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                Publié le {{ $lecture->communique->created_at->format('d/m/Y à H:i') }}
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-muted text-center py-5">
                                        <i
                                            class="fas fa-envelope-open-text fa-3x mb-3 d-block text-secondary opacity-50"></i>
                                        <p class="mb-0">Aucun communiqué lu.</p>
                                        <small class="text-muted">Les communiqués consultés apparaîtront ici.</small>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Message "aucun résultat" pour la recherche --}}
            <div id="noResults" class="text-center py-5 d-none">
                <i class="fas fa-search fa-3x text-muted opacity-50 mb-3"></i>
                <h5 class="text-muted">Aucun communiqué trouvé</h5>
                <p class="text-muted small">Essayez avec d'autres mots-clés.</p>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('searchInput');
                    const items = document.querySelectorAll('.communique-item');
                    const noResults = document.getElementById('noResults');
                    const colonnes = document.querySelectorAll('.col-lg-6');

                    if (!searchInput) return;

                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase().trim();
                        let visibleCount = 0;

                        items.forEach(function(item) {
                            const titre = item.dataset.titre || '';
                            const contenu = item.dataset.contenu || '';
                            const match = titre.includes(query) || contenu.includes(query);

                            item.classList.toggle('d-none', !match);
                            if (match) visibleCount++;
                        });

                        // Masquer les colonnes vides + le message si nécessaire
                        colonnes.forEach(function(col) {
                            const hasVisible = col.querySelector('.communique-item:not(.d-none)');
                            col.classList.toggle('d-none', !hasVisible);
                        });

                        noResults.classList.toggle('d-none', visibleCount > 0 || query === '');
                    });
                });
            </script>
        @endpush
    @endif
@endsection

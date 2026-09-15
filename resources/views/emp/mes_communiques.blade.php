@extends('emp.base')

@section('content')
    @if (View::hasSection('contenu_comm'))
        @yield('contenu_comm')
    @else
        <div class="container-fluid px-0">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <h2 class="mb-1 fw-bold text-primary">Communiqués</h2>
                    <p class="text-muted mb-0">Consultez les informations et annonces importantes destinées à votre compte.</p>
                </div>
                <div class="w-100 w-md-50" style="max-width: 420px;">
                    <input type="text" class="form-control" placeholder="Rechercher un communiqué..." id="searchInput">
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pb-0">
                            <h4 class="mb-0 d-flex align-items-center gap-2">
                                <span class="badge bg-danger rounded-pill">{{ $mes_communiques_non_lu->count() }}</span>
                                <span>Non lus</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @forelse ($mes_communiques_non_lu as $lecture)
                                    <a href="{{ route('lecture', $lecture->id) }}" class="list-group-item list-group-item-action border-0 rounded-4 mb-2 px-3 py-3 shadow-sm" style="border-left: 5px solid #0a4b7a !important;">
                                        <div class="d-flex justify-content-between gap-3 align-items-start">
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $lecture->communique->titre }}</div>
                                                <div class="small text-muted mt-1">{{ Str::limit($lecture->communique->contenu, 90) }}</div>
                                            </div>
                                            <span class="badge text-bg-primary rounded-pill">Nouveau</span>
                                        </div>
                                        <div class="small text-muted mt-2">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Publié le {{ $lecture->communique->created_at->format('d/m/Y à H:i') }}
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-muted text-center py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                        Aucun communiqué non lu.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-0 pb-0">
                            <h4 class="mb-0 d-flex align-items-center gap-2">
                                <span class="badge bg-success rounded-pill">{{ $mes_communiques_lu->count() }}</span>
                                <span>Déjà lus</span>
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @forelse ($mes_communiques_lu as $lecture)
                                    <a href="{{ route('lecture', $lecture->id) }}" class="list-group-item list-group-item-action border-0 rounded-4 mb-2 px-3 py-3 shadow-sm" style="border-left: 5px solid #6c757d !important;">
                                        <div class="fw-semibold text-dark">{{ $lecture->communique->titre }}</div>
                                        <div class="small text-muted mt-1">{{ Str::limit($lecture->communique->contenu, 90) }}</div>
                                        <div class="small text-success mt-2">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Lu le {{ $lecture->lu_a?->format('d/m/Y à H:i') ?? '—' }}
                                        </div>
                                        <div class="small text-muted mt-1">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Publié le {{ $lecture->communique->created_at->format('d/m/Y à H:i') }}
                                        </div>
                                    </a>
                                @empty
                                    <div class="text-muted text-center py-4">
                                        <i class="fas fa-envelope-open-text fa-2x mb-2 d-block text-secondary"></i>
                                        Aucun communiqué lu.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

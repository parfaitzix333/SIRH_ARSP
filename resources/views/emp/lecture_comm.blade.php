@extends('emp.mes_communiques')

@section('contenu_comm')
    @php
        $communique = $lecture->communique;
        $auteur = $communique->user ?? null;
        $pieceJointe = $communique->piece_jointe;
    @endphp

    <style>
        .lecture-meta {
            font-size: 0.78rem;
        }

        .lecture-meta-label {
            font-size: 0.68rem;
        }

        .attachment-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
        }
    </style>

    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('mes_communiques') }}" class="btn btn-outline-primary rounded-pill">
                <i class="fas fa-arrow-left me-2"></i>Retour aux communiqués
            </a>
            @if ($lecture->lu == false)
                <span class="badge bg-danger rounded-pill">Non lu</span>
            @else
                <span class="badge bg-success rounded-pill">Lu</span>
            @endif
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-primary text-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div>
                        <div class="small text-white-50 text-uppercase fw-semibold">Communication</div>
                        <h3 class="mb-0 mt-1 fw-bold">{{ $communique->titre }}</h3>
                    </div>
                    <span class="badge bg-white text-primary rounded-pill px-3 py-2 fw-semibold">
                        {{ $communique->role_cible === 'tous' ? 'Tous' : $communique->role_cible }}
                    </span>
                </div>
            </div>

            <div class="card-body p-4 p-lg-5">
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="small text-muted text-uppercase fw-semibold mb-2">Publié par</div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                style="width: 42px; height: 42px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <div class="fw-semibold text-dark">{{ $auteur?->name ?? 'Administration' }}</div>
                                <div class="small text-muted">{{ $communique->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="small text-muted text-uppercase fw-semibold mb-2">Date de publication</div>
                        <div class="fw-semibold text-dark">
                            <i class="far fa-calendar-alt text-primary me-2"></i>
                            {{ $communique->date_publication ? \Carbon\Carbon::parse($communique->date_publication)->format('d/m/Y') : $communique->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="small text-muted text-uppercase fw-semibold mb-2">Résumé</div>
                    <div class="bg-light rounded-4 p-4 border">
                        <p class="mb-0 text-dark" style="white-space: pre-line; line-height: 1.8;">
                            {{ $communique->contenu }}</p>
                    </div>
                </div>

                @if (filled($pieceJointe))
                    <div class="mb-3">
                        <div class="small text-muted text-uppercase fw-semibold mb-2">Pièce jointe</div>
                        <div
                            class="attachment-card d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 p-3">
                            <div class="d-flex align-items-center gap-3 min-w-0">
                                <i class="fas fa-paperclip text-primary"></i>
                                <span class="small text-dark text-break">{{ basename($pieceJointe) }}</span>
                            </div>
                            <a href="{{ route('communiques.file', ['path' => str_replace('\\', '/', $pieceJointe)]) }}"
                                target="_blank" rel="noopener"
                                class="btn btn-sm btn-outline-primary rounded-pill flex-shrink-0">
                                <i class="fas fa-download me-1"></i> Ouvrir
                            </a>
                        </div>
                    </div>
                @endif

                <div class="border-top pt-4 mt-4">
                    <div class="row g-2 lecture-meta text-muted">
                        <div class="col-md-4">
                            <span class="lecture-meta-label text-uppercase">Statut</span><br>
                            {{ $lecture->lu ? 'Lecture confirmée' : 'À lire' }}
                        </div>
                        <div class="col-md-4">
                            <span class="lecture-meta-label text-uppercase">Lu le</span><br>
                            {{ $lecture->lu_a ? $lecture->lu_a->format('d/m/Y à H:i') : '—' }}
                        </div>
                        <div class="col-md-4">
                            <span class="lecture-meta-label text-uppercase">Année</span><br>
                            {{ $communique->annee->annee ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

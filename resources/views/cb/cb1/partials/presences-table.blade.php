@php
    $presences = $presences ?? collect();
    $anneeId = $anneeId ?? null;
    $actions = $actions ?? true;
@endphp

<style>
    .presence-page .presence-card {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 5px 18px rgba(23, 50, 77, .08);
    }

    .presence-page .table th {
        color: #526579;
        font-size: .76rem;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .presence-page .table td {
        vertical-align: middle;
    }

    .presence-page .presence-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .presence-page .face-api-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #657589;
        font-size: .8rem;
        white-space: nowrap;
    }

    .presence-page .face-api-dot {
        width: 9px;
        height: 9px;
        flex: 0 0 9px;
        border-radius: 50%;
        background: #9aa4ad;
    }

    .presence-page .face-api-status[data-state="online"] .face-api-dot {
        background: #198754;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, .14);
    }

    .presence-page .face-api-status[data-state="offline"] .face-api-dot {
        background: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, .14);
    }

    .presence-face-video {
        display: block;
        width: 100%;
        max-height: min(58vh, 520px);
        aspect-ratio: 4 / 3;
        background: #101a20;
        object-fit: cover;
        transform: scaleX(-1);
    }

    .presence-face-result[data-state="success"] {
        color: #146c43;
    }

    .presence-face-result[data-state="wait"] {
        color: #997404;
    }

    .presence-face-result[data-state="error"] {
        color: #b02a37;
    }

    @media (max-width: 575.98px) {
        .presence-page .presence-actions {
            align-items: stretch;
        }

        .presence-page .presence-actions>button {
            flex: 1 1 auto;
        }
    }
</style>

<main class="container-fluid py-4 presence-page">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">{{ $titre }}</h2>
            <p class="text-muted mb-0">{{ $description }}</p>
        </div>
        @if ($actions)
            <div class="presence-actions">
                <span class="face-api-status" id="faceApiStatus" data-state="checking" role="status"
                    aria-live="polite">
                    <span class="face-api-dot" aria-hidden="true"></span>
                    <span id="faceApiStatusText">Vérification de l’API…</span>
                </span>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#cameraPointageModal" aria-label="Ouvrir le pointage par caméra">
                    <i class="fas fa-camera me-1" aria-hidden="true"></i> Pointer par caméra
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#ajoutPresenceModal">
                    <i class="fas fa-plus me-1" aria-hidden="true"></i> Ajouter une présence
                </button>
            </div>
        @endif
    </div>

    <section class="card presence-card">
        <div class="card-header bg-white border-0 p-3">
            <div class="row g-2">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="search" class="form-control" id="presenceSearch"
                            placeholder="Rechercher par matricule ou nom...">
                    </div>
                </div>
                <div class="col-md-5">
                    <select class="form-select" id="presenceFilter" aria-label="Filtrer les présences">
                        <option value="">Toutes les présences</option>
                        <option value="entree">Entrées</option>
                        <option value="sortie">Sorties</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="presencesTable">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Mouvement</th>
                        <th>Heure</th>
                        <th>Date</th>
                        @if ($actions)
                            <th class="text-center">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($presences as $presence)
                        <tr class="presence-row" data-mouvement="{{ strtolower($presence->mouvement) }}">
                            <td>{{ $presence->id }}</td>
                            <td>{{ $presence->employe?->matricule ?? '—' }}</td>
                            <td class="fw-semibold">{{ $presence->employe?->nom ?? '—' }}</td>
                            <td><span
                                    class="badge text-bg-{{ $presence->mouvement === 'entree' ? 'success' : 'danger' }}">{{ ucfirst($presence->mouvement) }}</span>
                            </td>
                            <td>{{ $presence->heure }}</td>
                            <td>{{ $presence->DATE?->format('d/m/Y') ?? '—' }}</td>

                            @if ($actions)
                                <td class="text-center text-nowrap">
                                    @if ($user->autorisation == 1)
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modifierPresenceModal{{ $presence->id }}"
                                            title="Modifier"><i class="fas fa-pen"></i></button>
                                        <form action="{{ route('presences.destroy', $presence->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Supprimer cette présence ?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Supprimer"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @else
                                        <i class="fa fa-lock text-danger fs-5"></i>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $actions ? 8 : 7 }}" class="text-center text-muted py-5">Aucune présence à
                                afficher.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div id="presenceNoResults" class="text-center text-muted py-5 d-none"><i
                class="fas fa-search fa-2x d-block mb-2"></i>Aucun résultat.</div>
    </section>
</main>

@if ($actions)
    <div class="modal fade" id="cameraPointageModal" tabindex="-1" aria-labelledby="cameraPointageTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="cameraPointageTitle">Pointage par reconnaissance faciale</h5>
                        <div class="face-api-status mt-2" id="faceApiModalStatus" data-state="checking" role="status"
                            aria-live="polite">
                            <span class="face-api-dot" aria-hidden="true"></span>
                            <span>Vérification de l’API…</span>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4 align-items-start">
                        <div class="col-lg-7">
                            <video id="presenceFaceVideo" class="presence-face-video" autoplay playsinline muted
                                aria-label="Aperçu de la caméra"></video>
                            <canvas id="presenceFaceCanvas" class="d-none"></canvas>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <button type="button" class="btn btn-outline-secondary" id="presenceCameraToggle">
                                    <i class="fas fa-video me-1" aria-hidden="true"></i> Activer la caméra
                                </button>
                                <button type="button" class="btn btn-primary" id="presenceCaptureButton" disabled>
                                    <i class="fas fa-camera me-1" aria-hidden="true"></i> Prendre la photo
                                </button>
                            </div>
                            <div class="small text-muted mt-2" id="presenceCameraHint" role="status"
                                aria-live="polite">
                                Autorisez l’accès à la caméra pour commencer.
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="border rounded p-3" aria-live="polite">
                                <div class="small text-uppercase fw-bold text-muted mb-2">Résultat</div>
                                <div id="presenceFaceResult" class="presence-face-result" data-state="idle">
                                    <p id="presenceFaceMessage" class="fw-semibold mb-3">En attente d’une capture.</p>
                                </div>
                                <dl class="row small mb-0">
                                    <dt class="col-5">Employé</dt>
                                    <dd class="col-7" id="presenceFaceName">—</dd>
                                    <dt class="col-5">Matricule</dt>
                                    <dd class="col-7" id="presenceFaceMatricule">—</dd>
                                    <dt class="col-5">Mouvement</dt>
                                    <dd class="col-7" id="presenceFaceMovement">—</dd>
                                    <dt class="col-5">Heure</dt>
                                    <dd class="col-7" id="presenceFaceTime">—</dd>
                                    <dt class="col-5">Score</dt>
                                    <dd class="col-7" id="presenceFaceScore">—</dd>
                                </dl>
                            </div>
                            <div class="small text-muted mt-3" id="presenceFaceBusy" hidden>
                                <span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>
                                Analyse du visage en cours…
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajoutPresenceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('presences.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter une présence</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label" for="presence_employe">Employé</label><select
                                class="form-select" id="presence_employe" name="employe_id" required>
                                <option value="">Sélectionner</option>
                                @foreach ($employes as $employe)
                                    <option value="{{ $employe->id }}">{{ $employe->nom }}
                                        ({{ $employe->matricule }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label" for="presence_date">Date</label><input
                                    type="date" class="form-control" id="presence_date" name="DATE"
                                    value="{{ now()->format('Y-m-d') }}" required></div>
                            <div class="col-md-6"><label class="form-label" for="presence_heure">Heure</label><input
                                    type="time" class="form-control" id="presence_heure" name="heure" required>
                            </div>
                        </div>
                        <div class="mt-3"><label class="form-label"
                                for="presence_mouvement">Mouvement</label><select class="form-select"
                                id="presence_mouvement" name="mouvement" required>
                                <option value="entree">Entrée</option>
                                <option value="sortie">Sortie</option>
                            </select></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Annuler</button><button
                            class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($presences as $presence)
        <div class="modal fade" id="modifierPresenceModal{{ $presence->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('presences.update', $presence->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier la présence</h5><button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label"
                                    for="edit_presence_employe_{{ $presence->id }}">Employé</label><select
                                    class="form-select" id="edit_presence_employe_{{ $presence->id }}"
                                    name="employe_id" required>
                                    @foreach ($employes as $employe)
                                        <option value="{{ $employe->id }}" @selected($presence->employe_id === $employe->id)>
                                            {{ $employe->nom }} ({{ $employe->matricule }})</option>
                                    @endforeach
                                </select></div>
                            <div class="row g-3">
                                <div class="col-md-6"><label class="form-label"
                                        for="edit_presence_date_{{ $presence->id }}">Date</label><input
                                        type="date" class="form-control"
                                        id="edit_presence_date_{{ $presence->id }}" name="DATE"
                                        value="{{ $presence->DATE?->format('Y-m-d') }}" required></div>
                                <div class="col-md-6"><label class="form-label"
                                        for="edit_presence_heure_{{ $presence->id }}">Heure</label><input
                                        type="time" class="form-control"
                                        id="edit_presence_heure_{{ $presence->id }}" name="heure"
                                        value="{{ substr($presence->heure, 0, 5) }}" required></div>
                            </div>
                            <div class="mt-3"><label class="form-label"
                                    for="edit_presence_mouvement_{{ $presence->id }}">Mouvement</label><select
                                    class="form-select" id="edit_presence_mouvement_{{ $presence->id }}"
                                    name="mouvement" required>
                                    <option value="entree" @selected($presence->mouvement === 'entree')>Entrée</option>
                                    <option value="sortie" @selected($presence->mouvement === 'sortie')>Sortie</option>
                                </select></div>

                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Annuler</button><button
                                class="btn btn-primary">Enregistrer</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const search = document.getElementById('presenceSearch');
            const filter = document.getElementById('presenceFilter');
            const rows = document.querySelectorAll('.presence-row');
            const empty = document.getElementById('presenceNoResults');

            function filterRows() {
                const query = (search?.value || '').toLocaleLowerCase('fr-FR').trim();
                const type = filter?.value || '';
                let visible = 0;
                rows.forEach(row => {
                    const matches = row.textContent.toLocaleLowerCase('fr-FR').includes(query) && (!type ||
                        row.dataset.mouvement === type);
                    row.hidden = !matches;
                    if (matches) visible++;
                });
                empty?.classList.toggle('d-none', visible > 0 || (!query && !type));
            }
            search?.addEventListener('input', filterRows);
            filter?.addEventListener('change', filterRows);

            const healthUrl = @json(url('/api/face/health'));
            const pointerUrl = @json(url('/api/face/pointer'));
            const statusElements = [document.getElementById('faceApiStatus'), document.getElementById(
                'faceApiModalStatus')].filter(Boolean);
            const statusText = document.getElementById('faceApiStatusText');
            const cameraModal = document.getElementById('cameraPointageModal');

            function setApiStatus(online) {
                statusElements.forEach((element) => {
                    element.dataset.state = online ? 'online' : 'offline';
                    const text = element.querySelector('span:last-child');
                    if (text) text.textContent = online ? 'API disponible' : 'API indisponible';
                });
                if (statusText) statusText.textContent = online ? 'API disponible' : 'API indisponible';
            }

            async function checkFaceApi() {
                try {
                    const response = await fetch(healthUrl, {
                        headers: {
                            Accept: 'application/json'
                        }
                    });
                    const health = await response.json();
                    setApiStatus(response.ok && health.ok === true);
                } catch (error) {
                    setApiStatus(false);
                }
            }

            checkFaceApi();
            const healthInterval = window.setInterval(checkFaceApi, 15000);

            if (cameraModal) {
                const video = document.getElementById('presenceFaceVideo');
                const canvas = document.getElementById('presenceFaceCanvas');
                const cameraToggle = document.getElementById('presenceCameraToggle');
                const captureButton = document.getElementById('presenceCaptureButton');
                const cameraHint = document.getElementById('presenceCameraHint');
                const busy = document.getElementById('presenceFaceBusy');
                const resultBox = document.getElementById('presenceFaceResult');
                let stream = null;

                function stopCamera() {
                    stream?.getTracks().forEach((track) => track.stop());
                    stream = null;
                    video.srcObject = null;
                    cameraToggle.innerHTML =
                        '<i class="fas fa-video me-1" aria-hidden="true"></i> Activer la caméra';
                    captureButton.disabled = true;
                    cameraHint.textContent = 'Caméra arrêtée.';
                }

                function showFaceResult(result, failed = false) {
                    const state = failed || !result.reconnu ? 'error' : result.mouvement ? 'success' : 'wait';
                    resultBox.dataset.state = state;
                    document.getElementById('presenceFaceMessage').textContent = result.message || result.error ||
                        'Une erreur est survenue pendant le pointage.';
                    document.getElementById('presenceFaceName').textContent = result.nom || '—';
                    document.getElementById('presenceFaceMatricule').textContent = result.matricule || '—';
                    document.getElementById('presenceFaceMovement').textContent = result.mouvement || '—';
                    document.getElementById('presenceFaceTime').textContent = result.heure || '—';
                    document.getElementById('presenceFaceScore').textContent = result.score === null || result
                        .score ===
                        undefined ? '—' : Number(result.score).toFixed(5);
                }

                cameraToggle.addEventListener('click', async () => {
                    if (stream) {
                        stopCamera();
                        return;
                    }
                    if (!navigator.mediaDevices?.getUserMedia) {
                        cameraHint.textContent = 'La caméra nécessite HTTPS ou localhost.';
                        return;
                    }
                    try {
                        stream = await navigator.mediaDevices.getUserMedia({
                            audio: false,
                            video: {
                                facingMode: 'user',
                                width: {
                                    ideal: 1280
                                },
                                height: {
                                    ideal: 800
                                }
                            }
                        });
                        video.srcObject = stream;
                        await video.play();
                        captureButton.disabled = false;
                        cameraToggle.innerHTML =
                            '<i class="fas fa-video-slash me-1" aria-hidden="true"></i> Arrêter la caméra';
                        cameraHint.textContent =
                            'Caméra active. Cadrez votre visage puis prenez la photo.';
                    } catch (error) {
                        stopCamera();
                        cameraHint.textContent = error.name === 'NotAllowedError' ?
                            'Accès caméra refusé. Autorisez la caméra dans votre navigateur.' :
                            'Impossible de démarrer la caméra.';
                    }
                });

                captureButton.addEventListener('click', async () => {
                    if (!stream || !video.videoWidth || captureButton.disabled) return;
                    captureButton.disabled = true;
                    busy.hidden = false;
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const context = canvas.getContext('2d');
                    context.translate(canvas.width, 0);
                    context.scale(-1, 1);
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    try {
                        const image = await new Promise((resolve, reject) => {
                            canvas.toBlob((blob) => blob ? resolve(blob) : reject(new Error(
                                    'Capture impossible.')),
                                'image/jpeg', .88);
                        });
                        const formData = new FormData();
                        formData.append('file', image, 'pointage.jpg');
                        const response = await fetch(pointerUrl, {
                            method: 'POST',
                            headers: {
                                Accept: 'application/json'
                            },
                            body: formData
                        });
                        const result = await response.json();
                        showFaceResult(result, !response.ok || result.ok === false);
                        if (result.ok && result.mouvement) {
                            window.setTimeout(() => window.location.reload(), 1200);
                        }
                    } catch (error) {
                        showFaceResult({
                            message: error.message ||
                                'Impossible de joindre le serveur de pointage.'
                        }, true);
                    } finally {
                        busy.hidden = true;
                        captureButton.disabled = !stream;
                    }
                });

                cameraModal.addEventListener('shown.bs.modal', checkFaceApi);
                cameraModal.addEventListener('hidden.bs.modal', stopCamera);
                window.addEventListener('pagehide', () => {
                    stopCamera();
                    window.clearInterval(healthInterval);
                });
            } else {
                window.clearInterval(healthInterval);
            }
        });
    </script>
@endpush

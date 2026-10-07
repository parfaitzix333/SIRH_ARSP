@extends('emp.base')

@section('content')
    <style>
        .mouvement-api-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #657589;
            font-size: .8rem;
            white-space: nowrap;
        }

        .mouvement-api-status::before {
            width: 9px;
            height: 9px;
            flex: 0 0 9px;
            border-radius: 50%;
            background: #9aa4ad;
            content: '';
        }

        .mouvement-api-status[data-state="online"]::before {
            background: #198754;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, .14);
        }

        .mouvement-api-status[data-state="offline"]::before {
            background: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, .14);
        }

        .mouvement-camera-video {
            display: block;
            width: 100%;
            max-height: min(56vh, 500px);
            aspect-ratio: 4 / 3;
            background: #101a20;
            object-fit: cover;
            transform: scaleX(-1);
        }

        .mouvement-recognition-result[data-state="success"] {
            color: #146c43;
        }

        .mouvement-recognition-result[data-state="error"] {
            color: #b02a37;
        }

        @media (max-width: 575.98px) {
            .mouvement-page-actions {
                width: 100%;
            }

            .mouvement-page-actions>button {
                flex: 1 1 auto;
            }
        }
    </style>
    @include('partials.avertissement_api_test')
    <div class="container-fluid py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="fw-bold mb-1">Mouvements d'aujourd'hui</h2>
                <p class="text-muted mb-0">Gérez les entrées et sorties enregistrées ce jour.</p>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2 mouvement-page-actions">
                <span class="mouvement-api-status" id="mouvementFaceApiStatus" data-state="checking" role="status"
                    aria-live="polite">Vérification de l’API…</span>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#cameraMouvementModal">
                    <i class="fas fa-camera me-1" aria-hidden="true"></i> Reconnaître et préparer
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajoutMouvementModal">
                    <i class="fas fa-plus me-1" aria-hidden="true"></i> Ajouter un mouvement
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 p-3">
                <div class="row g-2">
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="search" class="form-control" id="mouvementSearch"
                                placeholder="Rechercher par matricule ou nom...">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <select class="form-select" id="mouvementFilter" aria-label="Filtrer par mouvement">
                            <option value="">Tous les mouvements</option>
                            <option value="Entrée">Entrées</option>
                            <option value="Sortie">Sorties</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="mouvementsTable">
                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Matricule</th>
                            <th>Nom</th>
                            <th>Mouvement</th>
                            <th>Heure</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($les_mouvements_jour as $mouvement)
                            <tr class="mouvement-row" data-mouvement="{{ $mouvement->mouvement }}">
                                <td>{{ $mouvement->id }}</td>
                                <td>{{ $mouvement->employe?->matricule ?? '—' }}</td>
                                <td>{{ $mouvement->employe?->nom ?? '—' }}</td>
                                <td>
                                    <span
                                        class="badge text-bg-{{ $mouvement->mouvement === 'Entrée' ? 'success' : 'danger' }}">
                                        {{ $mouvement->mouvement }}
                                    </span>
                                </td>
                                <td>{{ $mouvement->heure }}</td>
                                <td>{{ $mouvement->created_at?->format('d/m/Y') ?? '—' }}</td>
                                <td class="text-center text-nowrap">
                                    @if ($user->autorisation == 1)
                                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modifierMouvementModal{{ $mouvement->id }}" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form action="{{ route('mouvements.destroy', $mouvement->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Supprimer ce mouvement ?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Supprimer"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @else
                                        <i class="fas fa-lock text-danger fs-5"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">Aucun mouvement aujourd'hui.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cameraMouvementModal" tabindex="-1" aria-labelledby="cameraMouvementTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title" id="cameraMouvementTitle">Reconnaissance et préparation du mouvement</h5>
                        <span class="mouvement-api-status mt-2" id="mouvementModalApiStatus" data-state="checking"
                            role="status" aria-live="polite">Vérification de l’API…</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <video id="mouvementCameraVideo" class="mouvement-camera-video" autoplay playsinline muted
                                aria-label="Aperçu caméra"></video>
                            <canvas id="mouvementCameraCanvas" class="d-none"></canvas>
                            <div class="d-flex flex-wrap gap-2 mt-3">
                                <button type="button" class="btn btn-outline-secondary" id="mouvementCameraToggle">
                                    <i class="fas fa-video me-1" aria-hidden="true"></i> Activer la caméra
                                </button>
                                <button type="button" class="btn btn-primary" id="mouvementCaptureButton" disabled>
                                    <i class="fas fa-camera me-1" aria-hidden="true"></i> Reconnaître le visage
                                </button>
                            </div>
                            <p class="small text-muted mb-0 mt-2" id="mouvementCameraHint" role="status"
                                aria-live="polite">Autorisez la caméra, puis capturez le visage de l’employé.</p>
                            <p class="small fw-semibold mt-2 mb-0" id="mouvementRecognitionResult" data-state="idle"
                                aria-live="polite">Aucune reconnaissance effectuée.</p>
                        </div>
                        <div class="col-lg-6">
                            <form action="{{ route('mouvements.store') }}" method="POST" id="cameraMouvementForm">
                                @csrf
                                <div class="alert alert-info py-2 small">
                                    La reconnaissance préremplit les champs, mais n’enregistre rien. Vérifiez et modifiez
                                    les informations avant de confirmer.
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="camera_mouvement_employe">Employé</label>
                                    <select class="form-select" id="camera_mouvement_employe" name="employe_id" required>
                                        <option value="">Sélectionner un employé</option>
                                        @foreach ($employes as $employe)
                                            <option value="{{ $employe->id }}">{{ $employe->nom }}
                                                ({{ $employe->matricule }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="camera_mouvement_type">Mouvement</label>
                                    <select class="form-select" id="camera_mouvement_type" name="mouvement" required>
                                        <option value="">Choisir entrée ou sortie</option>
                                        <option value="Entrée">Entrée</option>
                                        <option value="Sortie">Sortie</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="camera_mouvement_heure">Heure</label>
                                    <input type="time" class="form-control" id="camera_mouvement_heure"
                                        name="heure" required>
                                </div>
                                <div class="small text-muted mb-3" id="camera_mouvement_score">Score de reconnaissance : —
                                </div>
                                <button type="submit" class="btn btn-success" id="cameraMouvementSubmit" disabled>
                                    <i class="fas fa-check me-1" aria-hidden="true"></i> Confirmer le mouvement
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajoutMouvementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('mouvements.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un mouvement</h5><button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3"><label class="form-label" for="ajout_employe_id">Employé</label><select
                                class="form-select" id="ajout_employe_id" name="employe_id" required>
                                <option value="">Sélectionner</option>
                                @foreach ($employes as $employe)
                                    <option value="{{ $employe->id }}">{{ $employe->nom }} ({{ $employe->matricule }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3"><label class="form-label" for="ajout_mouvement">Mouvement</label><select
                                class="form-select" id="ajout_mouvement" name="mouvement" required>
                                <option value="">Sélectionner</option>
                                <option value="Entrée">Entrée</option>
                                <option value="Sortie">Sortie</option>
                            </select></div>
                        <div><label class="form-label" for="ajout_heure">Heure</label><input type="time"
                                class="form-control" id="ajout_heure" name="heure" required></div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Annuler</button><button class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($les_mouvements_jour as $mouvement)
        <div class="modal fade" id="modifierMouvementModal{{ $mouvement->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('mouvements.update', $mouvement->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier le mouvement</h5><button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3"><label class="form-label"
                                    for="edit_employe_{{ $mouvement->id }}">Employé</label><select class="form-select"
                                    id="edit_employe_{{ $mouvement->id }}" name="employe_id" required>
                                    @foreach ($employes as $employe)
                                        <option value="{{ $employe->id }}" @selected($mouvement->employe_id === $employe->id)>
                                            {{ $employe->nom }} ({{ $employe->matricule }})</option>
                                    @endforeach
                                </select></div>
                            <div class="mb-3"><label class="form-label"
                                    for="edit_mouvement_{{ $mouvement->id }}">Mouvement</label><select
                                    class="form-select" id="edit_mouvement_{{ $mouvement->id }}" name="mouvement"
                                    required>
                                    <option value="Entrée" @selected($mouvement->mouvement === 'Entrée')>Entrée</option>
                                    <option value="Sortie" @selected($mouvement->mouvement === 'Sortie')>Sortie</option>
                                </select></div>
                            <div><label class="form-label" for="edit_heure_{{ $mouvement->id }}">Heure</label><input
                                    type="time" class="form-control" id="edit_heure_{{ $mouvement->id }}"
                                    name="heure" value="{{ substr($mouvement->heure, 0, 5) }}" required></div>
                        </div>
                        <div class="modal-footer"><button type="button" class="btn btn-light"
                                data-bs-dismiss="modal">Annuler</button><button
                                class="btn btn-primary">Enregistrer</button></div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const search = document.getElementById('mouvementSearch');
                const filter = document.getElementById('mouvementFilter');
                const rows = document.querySelectorAll('.mouvement-row');

                function filterRows() {
                    const query = (search?.value || '').toLocaleLowerCase('fr-FR').trim();
                    const type = filter?.value || '';
                    rows.forEach(row => {
                        const matchesText = row.textContent.toLocaleLowerCase('fr-FR').includes(query);
                        const matchesType = !type || row.dataset.mouvement === type;
                        row.hidden = !(matchesText && matchesType);
                    });
                }

                search?.addEventListener('input', filterRows);
                filter?.addEventListener('change', filterRows);

                const healthUrl = @json(url('/api/face/health'));
                const recognizeUrl = @json(url('/api/face/recognize'));
                const apiStatusElements = [document.getElementById('mouvementFaceApiStatus'), document.getElementById(
                    'mouvementModalApiStatus')].filter(Boolean);

                function setApiStatus(online) {
                    apiStatusElements.forEach((element) => {
                        element.dataset.state = online ? 'online' : 'offline';
                        element.textContent = online ? 'API de reconnaissance disponible' :
                            'API de reconnaissance indisponible';
                    });
                }

                async function checkFaceApi() {
                    try {
                        const response = await fetch(healthUrl, {
                            headers: {
                                Accept: 'application/json'
                            }
                        });
                        const result = await response.json();
                        setApiStatus(response.ok && result.ok === true);
                    } catch (error) {
                        setApiStatus(false);
                    }
                }

                checkFaceApi();
                const healthInterval = window.setInterval(checkFaceApi, 15000);

                const cameraModal = document.getElementById('cameraMouvementModal');
                const video = document.getElementById('mouvementCameraVideo');
                const canvas = document.getElementById('mouvementCameraCanvas');
                const cameraToggle = document.getElementById('mouvementCameraToggle');
                const captureButton = document.getElementById('mouvementCaptureButton');
                const cameraHint = document.getElementById('mouvementCameraHint');
                const recognitionResult = document.getElementById('mouvementRecognitionResult');
                const employeeSelect = document.getElementById('camera_mouvement_employe');
                const movementSelect = document.getElementById('camera_mouvement_type');
                const timeInput = document.getElementById('camera_mouvement_heure');
                const scoreDisplay = document.getElementById('camera_mouvement_score');
                const submitButton = document.getElementById('cameraMouvementSubmit');
                let cameraStream = null;

                function stopCamera() {
                    cameraStream?.getTracks().forEach((track) => track.stop());
                    cameraStream = null;
                    video.srcObject = null;
                    captureButton.disabled = true;
                    cameraToggle.innerHTML = '<i class="fas fa-video me-1" aria-hidden="true"></i> Activer la caméra';
                    cameraHint.textContent = 'Caméra arrêtée.';
                }

                cameraModal.addEventListener('shown.bs.modal', checkFaceApi);
                cameraModal.addEventListener('hidden.bs.modal', stopCamera);

                cameraToggle.addEventListener('click', async () => {
                    if (cameraStream) {
                        stopCamera();
                        return;
                    }
                    if (!navigator.mediaDevices?.getUserMedia) {
                        cameraHint.textContent = 'La caméra nécessite HTTPS ou localhost.';
                        return;
                    }
                    try {
                        cameraStream = await navigator.mediaDevices.getUserMedia({
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
                        video.srcObject = cameraStream;
                        await video.play();
                        captureButton.disabled = false;
                        cameraToggle.innerHTML =
                            '<i class="fas fa-video-slash me-1" aria-hidden="true"></i> Arrêter la caméra';
                        cameraHint.textContent =
                            'Caméra active. Cadrez le visage puis lancez la reconnaissance.';
                    } catch (error) {
                        stopCamera();
                        cameraHint.textContent = error.name === 'NotAllowedError' ?
                            'Accès caméra refusé. Autorisez la caméra dans les paramètres du navigateur.' :
                            'Impossible de démarrer la caméra.';
                    }
                });

                captureButton.addEventListener('click', async () => {
                    if (!cameraStream || !video.videoWidth || captureButton.disabled) return;
                    captureButton.disabled = true;
                    cameraHint.textContent = 'Analyse du visage en cours…';
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
                        formData.append('file', image, 'mouvement.jpg');
                        const response = await fetch(recognizeUrl, {
                            method: 'POST',
                            headers: {
                                Accept: 'application/json'
                            },
                            body: formData
                        });
                        const payload = await response.json();
                        const recognition = payload.data || payload;
                        if (!response.ok || payload.ok === false || !recognition.reconnu || Number(
                                recognition.employe_id) < 1) {
                            recognitionResult.dataset.state = 'error';
                            recognitionResult.textContent = recognition.detail || recognition.error ||
                                (recognition.reconnu ? 'Employé introuvable dans la liste.' :
                                    'Aucun employé reconnu.');
                            return;
                        }

                        const recognizedEmployeeId = String(recognition.employe_id);
                        if (![...employeeSelect.options].some((option) => option.value ===
                                recognizedEmployeeId)) {
                            recognitionResult.dataset.state = 'error';
                            recognitionResult.textContent =
                                'Employé reconnu, mais absent de la liste des employés actifs.';
                            return;
                        }

                        employeeSelect.value = recognizedEmployeeId;
                        movementSelect.value = 'Entrée';
                        timeInput.value = new Date().toLocaleTimeString('fr-FR', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        });
                        scoreDisplay.textContent =
                            `Score de reconnaissance : ${Number(recognition.score).toFixed(5)}`;
                        submitButton.disabled = false;
                        recognitionResult.dataset.state = 'success';
                        recognitionResult.textContent =
                            `Visage reconnu : ${recognition.nom} (${recognition.matricule}). Vérifiez les champs et choisissez Entrée ou Sortie.`;
                        cameraHint.textContent =
                            'Les données sont préremplies. Vous pouvez encore les modifier avant de confirmer.';
                    } catch (error) {
                        recognitionResult.dataset.state = 'error';
                        recognitionResult.textContent = error.message ||
                            'Impossible de contacter l’API de reconnaissance.';
                    } finally {
                        captureButton.disabled = !cameraStream;
                    }
                });

                window.addEventListener('pagehide', () => {
                    stopCamera();
                    window.clearInterval(healthInterval);
                });
            });
        </script>
    @endpush
@endsection

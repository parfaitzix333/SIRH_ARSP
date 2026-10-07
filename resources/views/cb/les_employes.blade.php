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

        .enrollment-api-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #657589;
            font-size: .8rem;
        }

        .enrollment-api-status::before {
            width: 9px;
            height: 9px;
            flex: 0 0 9px;
            border-radius: 50%;
            background: #9aa4ad;
            content: '';
        }

        .enrollment-api-status[data-state="online"]::before {
            background: #198754;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, .14);
        }

        .enrollment-api-status[data-state="offline"]::before {
            background: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, .14);
        }

        .enrollment-camera {
            display: block;
            width: 100%;
            aspect-ratio: 4 / 3;
            max-height: 55vh;
            background: #101a20;
            object-fit: cover;
            transform: scaleX(-1);
        }

        .enrollment-result[data-state="success"] {
            color: #146c43;
        }

        .enrollment-result[data-state="error"] {
            color: #b02a37;
        }

        .enrollment-photo-list {
            max-height: 180px;
            overflow-y: auto;
        }

        .enrollment-photo-preview {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            border: 1px solid #d8e0dd;
            border-radius: 4px;
            background: #f2f5f3;
            object-fit: cover;
        }

        @media (max-width: 575.98px) {
            .enrollment-camera-actions>button {
                flex: 1 1 auto;
            }
        }
    </style>
    @include('partials.avertissement_api_test')

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
                            <th>Genre</th>
                            <th>Fonction</th>
                            <th>Grade</th>
                            <th>Service / Domaine</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employes as $employe)
                            @php $audit = $employe->audits->sortByDesc('created_at')->first(); @endphp
                            <tr class="employe-row">
                                <td>{{ $employe->id }}</td>
                                <td>{{ $employe->matricule ?? '—' }}</td>
                                <td class="fw-semibold">{{ $employe->nom }}</td>
                                <td>{{ $employe->genre ?? '—' }}</td>
                                <td>{{ $audit?->role ?? '—' }}</td>
                                <td>{{ $employe->grade?->designation ?? '—' }}</td>
                                <td>
                                    {{ $employe->service?->nom_service ?? '—' }}
                                    <span class="badge text-bg-primary ms-1">{{ $employe->service?->domaine ?? '—' }}</span>
                                </td>
                                @php
                                    $employe_enrole = App\Models\face_template::where(
                                        'employe_id',
                                        $employe->id,
                                    )->get();
                                    $a_des_templates = $employe_enrole->isNotEmpty();
                                @endphp
                                <td>
                                    @if ($a_des_templates)
                                        <button type="button" class="btn btn-outline-danger btn-sm shadow-lg"
                                            data-bs-toggle="modal" data-bs-target="#enrollementModal"
                                            data-employe-id="{{ $employe->id }}" aria-label="Enrôler {{ $employe->nom }}"
                                            title="Enrôler par reconnaissance faciale">
                                            <i class="fa fa-camera" aria-hidden="true"></i>
                                            <i class="fa fa-id-badge" aria-hidden="true"></i>
                                        </button>
                                        <span class="text-danger ms-1" aria-label="Nombre d’images enrôlées">
                                            {{ $employe_enrole->count() }}
                                        </span>
                                    @else
                                        <button type="button" class="btn btn-outline-primary btn-sm shadow-lg"
                                            data-bs-toggle="modal" data-bs-target="#enrollementModal"
                                            data-employe-id="{{ $employe->id }}" aria-label="Enrôler {{ $employe->nom }}"
                                            title="Enrôler par reconnaissance faciale">
                                            <i class="fa fa-camera" aria-hidden="true"></i>
                                            <i class="fa fa-id-badge" aria-hidden="true"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">Aucun employé enregistré.</td>
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



    <div class="modal fade" id="enrollementModal" tabindex="-1" aria-labelledby="enrollementModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h2 class="modal-title fs-5" id="enrollementModalTitle">Enrôlement facial</h2>
                        <p class="text-muted small mb-0 mt-1">Sélectionnez cinq images nettes du visage du même employé.</p>
                        <span class="enrollment-api-status mt-2" id="enrollmentApiStatus" data-state="checking"
                            role="status" aria-live="polite">Vérification de FastAPI…</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <form id="enrollementForm">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="enrollementEmploye">Employé</label>
                            <select class="form-select" id="enrollementEmploye" name="employe_id" required>
                                <option value="">Sélectionner un employé</option>
                                @foreach ($employes as $employe)
                                    <option value="{{ $employe->id }}">{{ $employe->nom }} ({{ $employe->matricule }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row g-4">
                            <div class="col-lg-6">
                                <video id="enrollementVideo" class="enrollment-camera" autoplay playsinline muted
                                    aria-label="Aperçu de la caméra"></video>
                                <canvas id="enrollementCanvas" class="d-none"></canvas>
                                <div class="row g-2 mt-2">
                                    <div class="col">
                                        <label class="visually-hidden" for="enrollementCameraSelect">Caméra</label>
                                        <select class="form-select" id="enrollementCameraSelect"
                                            aria-label="Sélectionner une caméra">
                                            <option value="">Caméra par défaut</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-outline-secondary"
                                            id="refreshEnrollmentCameras" title="Actualiser la liste des caméras"
                                            aria-label="Actualiser les caméras">
                                            <i class="fas fa-rotate" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap gap-2 mt-2 enrollment-camera-actions">
                                    <button type="button" class="btn btn-outline-secondary" id="toggleEnrollmentCamera">
                                        <i class="fas fa-video me-1" aria-hidden="true"></i> Activer la caméra
                                    </button>
                                    <button type="button" class="btn btn-primary" id="captureEnrollmentPhoto" disabled>
                                        <i class="fas fa-camera me-1" aria-hidden="true"></i> Prendre une photo
                                    </button>
                                </div>
                                <p class="small text-muted mt-2 mb-0" id="enrollementCameraStatus" role="status"
                                    aria-live="polite">La caméra démarre après autorisation du navigateur.</p>
                                <div class="mt-3">
                                    <label class="form-label fw-semibold" for="enrollementUploads">Ou sélectionner des
                                        photos</label>
                                    <input class="form-control" type="file" id="enrollementUploads"
                                        accept="image/jpeg,image/png" multiple>
                                    <div class="form-text">JPEG ou PNG, 15 Mo maximum par photo. Sélectionnez au total 5
                                        photos.</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h3 class="h6 fw-bold mb-0">Photos sélectionnées</h3>
                                    <span class="badge text-bg-secondary" id="enrollementPhotoCount">0 / 5</span>
                                </div>
                                <ul class="list-group enrollment-photo-list" id="enrollementPhotoList"></ul>
                                <div class="alert alert-light border small mt-3 mb-0">
                                    Chaque photo sera envoyée sous le champ multipart <code>files</code>. L’enrôlement
                                    commence uniquement après cinq captures valides.
                                </div>
                                <div class="enrollment-result mt-3" id="enrollementResult" data-state="idle"
                                    role="status" aria-live="polite"></div>
                                <div class="mt-2 small" id="enrollementDetails"></div>
                            </div>
                        </div>

                        <div class="modal-footer px-0 pb-0 mt-4">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success" id="submitEnrollment" disabled>
                                <i class="fas fa-id-badge me-1" aria-hidden="true"></i> Enrôler l’employé
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

                const enrollmentModal = document.getElementById('enrollementModal');
                const enrollmentForm = document.getElementById('enrollementForm');
                const employeeSelect = document.getElementById('enrollementEmploye');
                const video = document.getElementById('enrollementVideo');
                const canvas = document.getElementById('enrollementCanvas');
                const cameraSelect = document.getElementById('enrollementCameraSelect');
                const cameraStatus = document.getElementById('enrollementCameraStatus');
                const cameraToggle = document.getElementById('toggleEnrollmentCamera');
                const captureButton = document.getElementById('captureEnrollmentPhoto');
                const uploadInput = document.getElementById('enrollementUploads');
                const photoList = document.getElementById('enrollementPhotoList');
                const photoCount = document.getElementById('enrollementPhotoCount');
                const submitButton = document.getElementById('submitEnrollment');
                const result = document.getElementById('enrollementResult');
                const details = document.getElementById('enrollementDetails');
                const enrollUrl = @json(url('/api/face/enroll'));
                const healthUrl = @json(url('/api/face/health'));
                const apiStatus = document.getElementById('enrollmentApiStatus');
                const selectedPhotos = [];
                const photoPreviewUrls = new Map();
                let cameraStream = null;
                let isSubmitting = false;
                let healthInterval = null;

                async function checkEnrollmentApi() {
                    apiStatus.dataset.state = 'checking';
                    apiStatus.textContent = 'Vérification de FastAPI…';
                    try {
                        const response = await fetch(healthUrl, {
                            headers: {
                                Accept: 'application/json'
                            },
                            cache: 'no-store'
                        });
                        const payload = await response.json();
                        const online = response.ok && payload.ok === true && payload.data?.status === 'ok';
                        apiStatus.dataset.state = online ? 'online' : 'offline';
                        apiStatus.textContent = online ? 'FastAPI disponible' : 'FastAPI indisponible';
                    } catch (error) {
                        apiStatus.dataset.state = 'offline';
                        apiStatus.textContent = 'FastAPI indisponible';
                    }
                }

                function addSelectedPhoto(photo) {
                    selectedPhotos.push(photo);
                    photoPreviewUrls.set(photo, URL.createObjectURL(photo));
                }

                function releasePhotoPreview(photo) {
                    const previewUrl = photoPreviewUrls.get(photo);
                    if (previewUrl) URL.revokeObjectURL(previewUrl);
                    photoPreviewUrls.delete(photo);
                }

                function clearSelectedPhotos() {
                    selectedPhotos.forEach(releasePhotoPreview);
                    selectedPhotos.splice(0, selectedPhotos.length);
                }

                function updatePhotoList() {
                    photoList.replaceChildren();
                    selectedPhotos.forEach((photo, index) => {
                        const item = document.createElement('li');
                        item.className =
                            'list-group-item d-flex align-items-center justify-content-between gap-2 py-2';
                        const preview = document.createElement('img');
                        preview.className = 'enrollment-photo-preview';
                        preview.src = photoPreviewUrls.get(photo);
                        preview.alt = `Aperçu ${index + 1} : ${photo.name}`;
                        const filename = document.createElement('span');
                        filename.className = 'text-truncate small';
                        filename.textContent = `${index + 1}. ${photo.name}`;
                        const photoInfo = document.createElement('div');
                        photoInfo.className = 'd-flex align-items-center gap-2 min-w-0';
                        photoInfo.append(preview, filename);
                        const remove = document.createElement('button');
                        remove.type = 'button';
                        remove.className = 'btn btn-outline-danger btn-sm flex-shrink-0';
                        remove.setAttribute('aria-label', `Retirer ${photo.name}`);
                        remove.innerHTML = '<i class="fas fa-trash" aria-hidden="true"></i>';
                        remove.addEventListener('click', () => {
                            const [removedPhoto] = selectedPhotos.splice(index, 1);
                            releasePhotoPreview(removedPhoto);
                            updatePhotoList();
                        });
                        item.append(photoInfo, remove);
                        photoList.append(item);
                    });

                    photoCount.textContent = `${selectedPhotos.length} / 5`;
                    photoCount.className =
                        `badge ${selectedPhotos.length === 5 ? 'text-bg-success' : 'text-bg-secondary'}`;
                    captureButton.disabled = !cameraStream || selectedPhotos.length >= 5 || isSubmitting;
                    submitButton.disabled = selectedPhotos.length !== 5 || !employeeSelect.value || isSubmitting;
                }

                function stopCamera() {
                    cameraStream?.getTracks().forEach((track) => track.stop());
                    cameraStream = null;
                    video.srcObject = null;
                    cameraToggle.innerHTML = '<i class="fas fa-video me-1" aria-hidden="true"></i> Activer la caméra';
                    updatePhotoList();
                }

                async function refreshCameras() {
                    if (!navigator.mediaDevices?.enumerateDevices) return;
                    try {
                        const devices = await navigator.mediaDevices.enumerateDevices();
                        const cameras = devices.filter((device) => device.kind === 'videoinput');
                        const selected = cameraSelect.value;
                        cameraSelect.replaceChildren(new Option('Caméra par défaut', ''));
                        cameras.forEach((camera, index) => {
                            cameraSelect.add(new Option(camera.label || `Caméra ${index + 1}`, camera
                                .deviceId));
                        });
                        if (cameras.some((camera) => camera.deviceId === selected)) cameraSelect.value = selected;
                        cameraSelect.disabled = cameras.length < 2;
                        document.getElementById('refreshEnrollmentCameras').disabled = cameras.length === 0;
                        if (cameras.length === 0) cameraStatus.textContent = 'Aucune caméra détectée.';
                    } catch (error) {
                        cameraStatus.textContent = 'Impossible de lire la liste des caméras.';
                    }
                }

                async function startCamera() {
                    if (!navigator.mediaDevices?.getUserMedia) {
                        cameraStatus.textContent = 'La caméra nécessite HTTPS ou localhost.';
                        return;
                    }

                    stopCamera();
                    try {
                        const videoConstraints = cameraSelect.value ? {
                            deviceId: {
                                exact: cameraSelect.value
                            },
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 960
                            }
                        } : {
                            facingMode: 'user',
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 960
                            }
                        };
                        cameraStream = await navigator.mediaDevices.getUserMedia({
                            audio: false,
                            video: videoConstraints
                        });
                        video.srcObject = cameraStream;
                        await video.play();
                        cameraToggle.innerHTML =
                            '<i class="fas fa-video-slash me-1" aria-hidden="true"></i> Arrêter la caméra';
                        cameraStatus.textContent =
                            'Caméra active. Cadrez le visage et prenez cinq photos distinctes.';
                        updatePhotoList();
                        await refreshCameras();
                    } catch (error) {
                        stopCamera();
                        cameraStatus.textContent = error.name === 'NotAllowedError' ?
                            'Accès à la caméra refusé. Autorisez la caméra dans le navigateur.' :
                            'Impossible de démarrer cette caméra. Choisissez-en une autre.';
                    }
                }

                function addPhotos(files) {
                    const imageFiles = [...files];
                    const availableSlots = 5 - selectedPhotos.length;
                    if (imageFiles.length > availableSlots) {
                        cameraStatus.textContent = `Vous pouvez ajouter encore ${availableSlots} photo(s) au maximum.`;
                    }
                    imageFiles.slice(0, availableSlots).forEach((file) => {
                        if (!['image/jpeg', 'image/png'].includes(file.type)) {
                            cameraStatus.textContent = `${file.name} n’est pas un fichier JPEG ou PNG.`;
                            return;
                        }
                        if (file.size > 15 * 1024 * 1024) {
                            cameraStatus.textContent = `${file.name} dépasse la limite de 15 Mo.`;
                            return;
                        }
                        addSelectedPhoto(file);
                    });
                    uploadInput.value = '';
                    updatePhotoList();
                }

                document.querySelectorAll('[data-bs-target="#enrollementModal"]').forEach((button) => {
                    button.addEventListener('click', () => {
                        employeeSelect.value = button.dataset.employeId || '';
                        updatePhotoList();
                    });
                });

                enrollmentModal.addEventListener('shown.bs.modal', refreshCameras);
                enrollmentModal.addEventListener('shown.bs.modal', () => {
                    checkEnrollmentApi();
                    healthInterval = window.setInterval(checkEnrollmentApi, 15000);
                });
                enrollmentModal.addEventListener('hidden.bs.modal', () => {
                    window.clearInterval(healthInterval);
                    healthInterval = null;
                    stopCamera();
                    clearSelectedPhotos();
                    updatePhotoList();
                    enrollmentForm.reset();
                    result.textContent = '';
                    result.replaceChildren();
                    result.dataset.state = 'idle';
                    details.replaceChildren();
                    cameraStatus.textContent = 'La caméra démarre après autorisation du navigateur.';
                });

                cameraToggle.addEventListener('click', () => cameraStream ? stopCamera() : startCamera());
                cameraSelect.addEventListener('change', () => {
                    if (cameraStream) startCamera();
                });
                document.getElementById('refreshEnrollmentCameras').addEventListener('click', refreshCameras);
                captureButton.addEventListener('click', () => {
                    if (!cameraStream || !video.videoWidth || selectedPhotos.length >= 5) return;
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    const context = canvas.getContext('2d');
                    context.translate(canvas.width, 0);
                    context.scale(-1, 1);
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                    canvas.toBlob((blob) => {
                        if (blob) {
                            const sequence = selectedPhotos.length + 1;
                            addSelectedPhoto(new File([blob],
                                `employe-${employeeSelect.value || 'photo'}-${sequence}.jpg`, {
                                    type: 'image/jpeg',
                                    lastModified: Date.now()
                                }));
                            cameraStatus.textContent = `Photo ${selectedPhotos.length} sur 5 capturée.`;
                            updatePhotoList();
                        }
                    }, 'image/jpeg', .9);
                });
                uploadInput.addEventListener('change', () => addPhotos(uploadInput.files));
                employeeSelect.addEventListener('change', updatePhotoList);

                enrollmentForm.addEventListener('submit', async (event) => {
                    event.preventDefault();
                    if (selectedPhotos.length !== 5 || !employeeSelect.value || isSubmitting) return;

                    isSubmitting = true;
                    updatePhotoList();
                    submitButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Enrôlement…';
                    result.dataset.state = 'idle';
                    result.textContent = 'Envoi des cinq images à l’API…';
                    details.replaceChildren();

                    try {
                        const formData = new FormData();
                        formData.append('employe_id', employeeSelect.value);
                        selectedPhotos.forEach((photo) => formData.append('files[]', photo, photo.name));
                        const response = await fetch(enrollUrl, {
                            method: 'POST',
                            headers: {
                                Accept: 'application/json'
                            },
                            body: formData
                        });
                        const payload = await response.json();
                        if (!response.ok || payload.ok !== true) {
                            const errors = payload.errors ? Object.values(payload.errors).flat().join(' ') :
                                '';
                            throw new Error(payload.error || errors || 'L’enrôlement a échoué.');
                        }

                        const enrollment = payload.data || {};
                        result.dataset.state = 'success';
                        result.textContent = enrollment.message || 'Enrôlement réussi.';
                        const summary = document.createElement('p');
                        summary.className = 'small mt-2 mb-2';
                        summary.textContent =
                            `${enrollment.nom || 'Employé'} (${enrollment.matricule || '—'}) · ${enrollment.n_embeddings ?? selectedPhotos.length} embeddings créés.`;
                        details.append(summary);
                        if (Array.isArray(enrollment.details)) {
                            const list = document.createElement('ul');
                            list.className = 'small mb-0 ps-3';
                            enrollment.details.forEach((item) => {
                                const line = document.createElement('li');
                                line.textContent =
                                    `Photo ${item.index}: ${item.source || 'image'} · détection ${Number(item.det_score || 0).toFixed(2)}`;
                                list.append(line);
                            });
                            details.append(list);
                        }
                        clearSelectedPhotos();
                        updatePhotoList();
                    } catch (error) {
                        result.dataset.state = 'error';
                        result.textContent = error.message ||
                            'Impossible de joindre le service d’enrôlement.';
                    } finally {
                        isSubmitting = false;
                        submitButton.innerHTML =
                            '<i class="fas fa-id-badge me-1" aria-hidden="true"></i> Enrôler l’employé';
                        updatePhotoList();
                    }
                });

                window.addEventListener('pagehide', stopCamera);
            });
        </script>
    @endpush
    </div>
@endsection

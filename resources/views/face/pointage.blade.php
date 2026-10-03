<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#102b36">
    <title>Pointage par reconnaissance faciale | ARSP</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #152f39;
            --muted: #62737a;
            --navy: #102b36;
            --blue: #176b7b;
            --gold: #e6b84f;
            --paper: #f2f5f3;
            --line: #d8e0dd;
            --green: #176c47;
            --green-bg: #e7f4ed;
            --orange: #946009;
            --orange-bg: #fff4dc;
            --red: #a43434;
            --red-bg: #ffebeb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
            background: var(--paper);
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        a {
            color: inherit;
        }

        .topbar {
            display: flex;
            min-height: 66px;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px max(20px, calc((100vw - 1180px) / 2));
            background: var(--navy);
            color: white;
        }

        .brand {
            font-size: 15px;
            font-weight: 800;
            letter-spacing: .04em;
        }

        .brand small {
            display: block;
            margin-top: 3px;
            color: #bbd0d3;
            font-size: 11px;
            font-weight: 500;
        }

        .back-link {
            text-decoration: none;
            font-size: 13px;
        }

        .back-link:hover {
            color: var(--gold);
        }

        main {
            width: min(1180px, calc(100% - 40px));
            margin: 42px auto;
        }

        .page-heading {
            margin-bottom: 24px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--blue);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: 30px;
            line-height: 1.2;
        }

        .intro {
            margin: 9px 0 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .workspace {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(280px, .8fr);
            align-items: start;
            gap: 28px;
        }

        .camera-column,
        .result-column {
            min-width: 0;
        }

        .section-heading {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 11px;
        }

        h2 {
            margin: 0;
            font-size: 16px;
        }

        .camera-hint {
            color: var(--muted);
            font-size: 12px;
        }

        .camera-frame {
            position: relative;
            display: grid;
            width: 100%;
            min-height: 240px;
            aspect-ratio: 16 / 10;
            place-items: center;
            overflow: hidden;
            border: 1px solid #223942;
            background: #0c1c22;
        }

        video {
            display: block;
            width: 100%;
            height: 100%;
            min-height: 240px;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            transform: scaleX(-1);
        }

        .camera-placeholder {
            position: absolute;
            max-width: 270px;
            padding: 20px;
            color: #d6e0df;
            font-size: 14px;
            line-height: 1.6;
            text-align: center;
        }

        .camera-frame.is-live .camera-placeholder {
            display: none;
        }

        .camera-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--muted);
            font-size: 12px;
        }

        .camera-status::before {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #839299;
            content: '';
        }

        .camera-status.is-live {
            color: var(--green);
        }

        .camera-status.is-live::before {
            background: #2a9a65;
        }

        .camera-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
        }

        button {
            min-height: 44px;
            border: 1px solid transparent;
            border-radius: 4px;
            cursor: pointer;
            font: inherit;
            font-weight: 700;
        }

        button:focus-visible,
        a:focus-visible {
            outline: 3px solid #e6b84f;
            outline-offset: 3px;
        }

        button:disabled {
            cursor: not-allowed;
            opacity: .48;
        }

        .button-primary {
            padding: 0 19px;
            background: var(--blue);
            color: white;
        }

        .button-primary:hover:not(:disabled) {
            background: #0d5666;
        }

        .button-secondary {
            padding: 0 16px;
            border-color: #9cabad;
            background: transparent;
            color: var(--ink);
        }

        .result-panel {
            min-height: 244px;
            padding: 18px;
            border: 1px solid var(--line);
            background: white;
        }

        .result-panel[data-state="success"] {
            border-color: #9acbb0;
            background: var(--green-bg);
        }

        .result-panel[data-state="wait"] {
            border-color: #e7c779;
            background: var(--orange-bg);
        }

        .result-panel[data-state="error"] {
            border-color: #e6aaaa;
            background: var(--red-bg);
        }

        .result-state {
            margin: 0 0 12px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        [data-state="success"] .result-state {
            color: var(--green);
        }

        [data-state="wait"] .result-state {
            color: var(--orange);
        }

        [data-state="error"] .result-state {
            color: var(--red);
        }

        .result-message {
            margin: 0 0 18px;
            font-size: 18px;
            font-weight: 800;
            line-height: 1.4;
        }

        .result-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px 10px;
            margin: 0;
        }

        .result-details div {
            min-width: 0;
        }

        .result-details dt {
            margin-bottom: 4px;
            color: var(--muted);
            font-size: 11px;
            text-transform: uppercase;
        }

        .result-details dd {
            margin: 0;
            overflow-wrap: anywhere;
            font-size: 14px;
            font-weight: 700;
        }

        .privacy-note {
            margin: 14px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .busy {
            display: none;
            margin-top: 12px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 700;
        }

        .busy.is-visible {
            display: block;
        }

        @media (max-width: 760px) {
            main {
                margin: 28px auto;
            }

            .workspace {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .result-panel {
                min-height: auto;
            }

            h1 {
                font-size: 25px;
            }
        }

        @media (max-width: 440px) {
            .topbar {
                padding-right: 16px;
                padding-left: 16px;
            }

            main {
                width: calc(100% - 28px);
            }

            .camera-frame,
            video {
                min-height: 210px;
            }

            .camera-actions button {
                flex: 1 1 100%;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>
    <header class="topbar">
        <div class="brand">ARSP <small>POINTAGE DU PERSONNEL</small></div>
        <a class="back-link" href="{{ url()->previous() }}">Retour</a>
    </header>

    <main>
        <div class="page-heading">
            <p class="eyebrow">Présences</p>
            <h1>Pointage par reconnaissance faciale</h1>
            <p class="intro">Positionnez votre visage face à la caméra, puis prenez une photo pour enregistrer votre
                entrée ou votre sortie.</p>
        </div>

        <div class="workspace">
            <section class="camera-column" aria-labelledby="cameraTitle">
                <div class="section-heading">
                    <h2 id="cameraTitle">Caméra</h2>
                    <span class="camera-status" id="cameraStatus" aria-live="polite">Caméra arrêtée</span>
                </div>
                <div class="camera-frame" id="cameraFrame">
                    <video id="cameraVideo" autoplay playsinline muted aria-label="Aperçu caméra"></video>
                    <div class="camera-placeholder" id="cameraPlaceholder">Autorisez l’accès à la caméra pour démarrer
                        le pointage.</div>
                </div>
                <canvas id="captureCanvas" hidden></canvas>
                <div class="camera-actions">
                    <button class="button-secondary" type="button" id="cameraButton">Activer la caméra</button>
                    <button class="button-primary" type="button" id="captureButton" disabled>Prendre la photo</button>
                </div>
                <p class="busy" id="busyMessage" role="status">Analyse du visage et enregistrement du pointage…</p>
                <p class="privacy-note">La caméra ne démarre qu’après votre autorisation. La capture est envoyée au
                    serveur pour vérification.</p>
            </section>

            <section class="result-column" aria-labelledby="resultTitle">
                <div class="section-heading">
                    <h2 id="resultTitle">Résultat du pointage</h2>
                </div>
                <div class="result-panel" id="resultPanel" data-state="idle" aria-live="polite">
                    <p class="result-state" id="resultState">En attente</p>
                    <p class="result-message" id="resultMessage">Le résultat apparaîtra ici après la capture.</p>
                    <dl class="result-details">
                        <div>
                            <dt>Employé</dt>
                            <dd id="employeeName">—</dd>
                        </div>
                        <div>
                            <dt>Matricule</dt>
                            <dd id="employeeNumber">—</dd>
                        </div>
                        <div>
                            <dt>Mouvement</dt>
                            <dd id="movement">—</dd>
                        </div>
                        <div>
                            <dt>Heure</dt>
                            <dd id="time">—</dd>
                        </div>
                        <div>
                            <dt>Score</dt>
                            <dd id="score">—</dd>
                        </div>
                    </dl>
                </div>
            </section>
        </div>
    </main>

    <script>
        (() => {
            const video = document.getElementById('cameraVideo');
            const frame = document.getElementById('cameraFrame');
            const cameraButton = document.getElementById('cameraButton');
            const captureButton = document.getElementById('captureButton');
            const canvas = document.getElementById('captureCanvas');
            const busyMessage = document.getElementById('busyMessage');
            const resultPanel = document.getElementById('resultPanel');
            let cameraStream = null;

            function stopCamera() {
                cameraStream?.getTracks().forEach((track) => track.stop());
                cameraStream = null;
                video.srcObject = null;
                frame.classList.remove('is-live');
                captureButton.disabled = true;
                cameraButton.textContent = 'Activer la caméra';
                const status = document.getElementById('cameraStatus');
                status.textContent = 'Caméra arrêtée';
                status.classList.remove('is-live');
            }

            function showResult(result, isError = false) {
                const state = isError || !result.reconnu ?
                    'error' :
                    result.mouvement ?
                    'success' :
                    'wait';
                resultPanel.dataset.state = state;
                document.getElementById('resultState').textContent = {
                    success: 'Pointage enregistré',
                    wait: 'Action requise',
                    error: 'Pointage non enregistré'
                } [state];
                document.getElementById('resultMessage').textContent = result.message || 'Une erreur est survenue.';
                document.getElementById('employeeName').textContent = result.nom || '—';
                document.getElementById('employeeNumber').textContent = result.matricule || '—';
                document.getElementById('movement').textContent = result.mouvement || '—';
                document.getElementById('time').textContent = result.heure || '—';
                document.getElementById('score').textContent = result.score !== null && result.score !== undefined &&
                    Number.isFinite(Number(result.score)) ?
                    Number(result.score).toFixed(5) :
                    '—';
            }

            cameraButton.addEventListener('click', async () => {
                if (cameraStream) {
                    stopCamera();
                    return;
                }

                if (!navigator.mediaDevices?.getUserMedia) {
                    showResult({
                        message: 'La caméra nécessite une connexion sécurisée (HTTPS ou localhost).'
                    }, true);
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
                    frame.classList.add('is-live');
                    captureButton.disabled = false;
                    cameraButton.textContent = 'Arrêter la caméra';
                    const status = document.getElementById('cameraStatus');
                    status.textContent = 'Caméra active';
                    status.classList.add('is-live');
                } catch (error) {
                    stopCamera();
                    showResult({
                        message: error.name === 'NotAllowedError' ?
                            'Accès à la caméra refusé. Autorisez la caméra dans les paramètres du navigateur.' :
                            'Impossible de démarrer la caméra sur cet appareil.'
                    }, true);
                }
            });

            captureButton.addEventListener('click', async () => {
                if (!cameraStream || !video.videoWidth || captureButton.disabled) {
                    return;
                }

                captureButton.disabled = true;
                busyMessage.classList.add('is-visible');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.translate(canvas.width, 0);
                context.scale(-1, 1);
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                try {
                    const image = await new Promise((resolve, reject) => {
                        canvas.toBlob((blob) => blob ? resolve(blob) : reject(new Error(
                            'Capture impossible.')), 'image/jpeg', .88);
                    });
                    const formData = new FormData();
                    formData.append('file', image, 'pointage.jpg');

                    const response = await fetch(@json(url('/api/face/pointer')), {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json'
                        },
                        body: formData
                    });
                    const result = await response.json();
                    if (!response.ok || result.ok === false) {
                        showResult({
                            ...result,
                            message: result.message || result.error ||
                                'Le serveur n’a pas pu traiter la capture.'
                        }, true);
                    } else {
                        showResult(result);
                    }
                } catch (error) {
                    showResult({
                        message: error.message || 'Impossible de joindre le serveur de pointage.'
                    }, true);
                } finally {
                    busyMessage.classList.remove('is-visible');
                    captureButton.disabled = !cameraStream;
                }
            });

            window.addEventListener('pagehide', stopCamera);
        })();
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Autorisation de Congé - ARSP</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Times New Roman', serif;
            background: #f0f4f8;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .autorisation-container {
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
            overflow: visible;
            position: relative;
            z-index: 1;
        }

        /* ===== EN-TÊTE ===== */
        .autorisation-header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 20px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #fbbf24;
            position: relative;
            z-index: 5;
        }

        .autorisation-header .header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .autorisation-header .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #fbbf24;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .autorisation-header .title h1 {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 1px;
        }

        .autorisation-header .title .subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
            margin: 2px 0 0 0;
            font-weight: 300;
        }

        .autorisation-header .badge-status {
            background: #fbbf24;
            color: #0f172a;
            padding: 6px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            position: relative;
            z-index: 10;
        }

        /* ===== CORPS ===== */
        .autorisation-body {
            padding: 25px 35px 20px 35px;
        }

        /* Référence */
        .reference-bar {
            background: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 8px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .reference-bar .ref-label {
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .reference-bar .ref-number {
            color: #0f172a;
            font-weight: 700;
            font-size: 0.95rem;
            font-family: 'Courier New', monospace;
        }

        .reference-bar .ref-date {
            color: #64748b;
            font-size: 0.75rem;
        }

        /* Grille informations */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px 20px;
            margin-bottom: 18px;
        }

        .info-group {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 6px;
        }

        .info-group .label {
            font-size: 0.65rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-group .value {
            font-size: 0.9rem;
            font-weight: 500;
            color: #0f172a;
        }

        .info-group .value.highlight {
            color: #3b82f6;
            font-weight: 600;
        }

        /* Section titre */
        .section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            margin: 16px 0 10px 0;
            padding-bottom: 6px;
            border-bottom: 2px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #3b82f6;
            font-size: 0.9rem;
        }

        /* Détails du congé */
        .conge-details {
            background: #f8fafc;
            border-radius: 10px;
            padding: 12px 18px;
            margin-bottom: 14px;
            border: 1px solid #e2e8f0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 20px;
        }

        .conge-details .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .conge-details .detail-row:last-child {
            border-bottom: none;
        }

        .conge-details .detail-row.full-width {
            grid-column: 1 / -1;
        }

        .conge-details .detail-label {
            color: #64748b;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .conge-details .detail-value {
            color: #0f172a;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .conge-details .detail-value .badge {
            font-size: 0.7rem;
            padding: 2px 10px;
        }

        /* Motif */
        .motif-section {
            background: #fef9e7;
            border-radius: 10px;
            padding: 10px 16px;
            border-left: 4px solid #f59e0b;
            margin-bottom: 14px;
        }

        .motif-section .motif-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: #92400e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .motif-section .motif-text {
            margin-top: 3px;
            color: #78350f;
            font-size: 0.85rem;
            line-height: 1.5;
        }

        /* ===== VALIDATIONS - 3 BOOLÉENS ===== */
        .validations-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin: 14px 0 16px 0;
        }

        .validation-item {
            background: #f8fafc;
            border-radius: 10px;
            padding: 12px 15px;
            text-align: center;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .validation-item.valid {
            border-color: #10b981;
            background: #f0fdf4;
        }

        .validation-item.invalid {
            border-color: #ef4444;
            background: #fef2f2;
        }

        .validation-item .validation-icon {
            font-size: 1.6rem;
            margin-bottom: 2px;
        }

        .validation-item .validation-icon.valid {
            color: #10b981;
        }

        .validation-item .validation-icon.invalid {
            color: #ef4444;
        }

        .validation-item .validation-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
        }

        .validation-item .validation-status {
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 2px;
        }

        .validation-item .validation-status.valid {
            color: #10b981;
        }

        .validation-item .validation-status.invalid {
            color: #ef4444;
        }

        /* ===== PIED DE PAGE ===== */
        .autorisation-footer {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 15px;
        }

        .autorisation-footer .signature-area {
            text-align: center;
            min-width: 160px;
        }

        .autorisation-footer .signature-area .signature-line {
            width: 160px;
            border-bottom: 2px solid #0f172a;
            margin: 25px auto 4px auto;
        }

        .autorisation-footer .signature-area .signature-label {
            font-size: 0.65rem;
            color: #64748b;
            font-weight: 500;
        }

        .autorisation-footer .footer-note {
            font-size: 0.65rem;
            color: #94a3b8;
            text-align: right;
        }

        /* ===== BOUTONS ===== */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 16px 35px 22px 35px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .action-buttons .btn {
            padding: 10px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .action-buttons .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            color: white;
        }

        .action-buttons .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        .action-buttons .btn-secondary {
            background: #e2e8f0;
            border: none;
            color: #475569;
        }

        .action-buttons .btn-secondary:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        /* ===== STYLES POUR L'IMPRESSION ===== */
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
                display: block;
            }

            .autorisation-container {
                box-shadow: none;
                border-radius: 0;
                max-width: 100%;
                height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .autorisation-header {
                background: #0f172a !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                padding: 15px 25px;
            }

            .autorisation-header .logo {
                background: rgba(255, 255, 255, 0.1) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .autorisation-header .badge-status {
                background: #fbbf24 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .action-buttons {
                display: none !important;
            }

            .reference-bar {
                background: #f8fafc !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .conge-details {
                background: #f8fafc !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .motif-section {
                background: #fef9e7 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .validation-item.valid {
                border-color: #10b981 !important;
                background: #f0fdf4 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .validation-item.invalid {
                border-color: #ef4444 !important;
                background: #fef2f2 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .validation-item .validation-icon.valid {
                color: #10b981 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .validation-item .validation-icon.invalid {
                color: #ef4444 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .validation-item .validation-status.valid {
                color: #10b981 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .validation-item .validation-status.invalid {
                color: #ef4444 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .autorisation-body {
                padding: 18px 25px 10px 25px;
                flex: 1;
            }

            .info-grid {
                gap: 8px 16px;
                margin-bottom: 12px;
            }

            .info-group {
                padding-bottom: 4px;
            }

            .info-group .value {
                font-size: 0.85rem;
            }

            .section-title {
                font-size: 0.85rem;
                margin: 12px 0 8px 0;
                padding-bottom: 4px;
            }

            .conge-details {
                padding: 10px 14px;
                margin-bottom: 10px;
                gap: 2px 15px;
            }

            .conge-details .detail-row {
                padding: 3px 0;
            }

            .conge-details .detail-label {
                font-size: 0.75rem;
            }

            .conge-details .detail-value {
                font-size: 0.8rem;
            }

            .motif-section {
                padding: 8px 14px;
                margin-bottom: 10px;
            }

            .motif-section .motif-text {
                font-size: 0.8rem;
            }

            .validations-grid {
                gap: 10px;
                margin: 10px 0 12px 0;
            }

            .validation-item {
                padding: 8px 10px;
            }

            .validation-item .validation-icon {
                font-size: 1.3rem;
            }

            .validation-item .validation-label {
                font-size: 0.7rem;
            }

            .validation-item .validation-status {
                font-size: 0.65rem;
            }

            .autorisation-footer {
                margin-top: 10px;
                padding-top: 10px;
            }

            .autorisation-footer .signature-area .signature-line {
                width: 130px;
                margin: 18px auto 3px auto;
            }

            .autorisation-footer .signature-area .signature-label {
                font-size: 0.6rem;
            }

            .autorisation-footer .footer-note {
                font-size: 0.6rem;
            }

            .badge {
                border: 1px solid #ddd;
                padding: 1px 8px;
                border-radius: 4px;
            }

            .no-print {
                display: none !important;
            }

            /* Éviter les coupures */
            .autorisation-body,
            .autorisation-footer {
                page-break-inside: avoid;
            }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .autorisation-header {
                padding: 15px 20px;
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .autorisation-header .header-left {
                flex-direction: column;
                text-align: center;
            }

            .autorisation-header .title h1 {
                font-size: 1.2rem;
            }

            .autorisation-body {
                padding: 15px 20px;
            }

            .info-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px 12px;
            }

            .validations-grid {
                grid-template-columns: 1fr 1fr;
            }

            .conge-details {
                grid-template-columns: 1fr;
            }

            .reference-bar {
                flex-direction: column;
                text-align: center;
            }

            .autorisation-footer {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .autorisation-footer .footer-note {
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
                padding: 12px 20px;
            }

            .action-buttons .btn {
                justify-content: center;
                padding: 10px 18px;
            }
        }

        @media (max-width: 480px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .validations-grid {
                grid-template-columns: 1fr;
            }

            .autorisation-header .badge-status {
                font-size: 0.7rem;
                padding: 4px 14px;
            }

            .conge-details .detail-row {
                flex-direction: column;
                gap: 2px;
            }

            .autorisation-footer .signature-area .signature-line {
                width: 120px;
            }
        }
    </style>
</head>

<body>

    <div class="autorisation-container" id="autorisation-pdf">
        <!-- ===== EN-TÊTE ===== -->
        <div class="autorisation-header">
            <div class="header-left">
                <div class="logo">
                    <img src="{{ asset('image/logo.png') }}" alt="" width="50px" height="50px">
                </div>
                <div class="title">
                    <h1>ARSP</h1>
                    <div class="subtitle">Autorité de Régulation de la Sous-traitance dans le Secteur Privé</div>
                </div>
            </div>
            <div class="badge-status">
                <i class="fas fa-check-circle me-1"></i>
                {{ ucfirst($mon_conge->statut ?? 'En attente') }}
            </div>
        </div>

        <!-- ===== CORPS ===== -->
        <div class="autorisation-body">
            <!-- Référence -->
            <div class="reference-bar">
                <div>
                    <span class="ref-label">N° Référence</span>
                    <div class="ref-number">
                        ARSP/CONG/{{ date('Y') }}/{{ str_pad($mon_conge->id ?? 1, 4, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div>
                    <span class="ref-label">Date d'émission</span>
                    <div class="ref-date">{{ now()->format('d/m/Y') }}</div>
                </div>
            </div>

            <!-- Informations employé -->
            <div class="info-grid">
                <div class="info-group">
                    <div class="label">Employé</div>
                    <div class="value highlight">{{ $employe->nom ?? 'Non défini' }}</div>
                </div>
                <div class="info-group">
                    <div class="label">Matricule</div>
                    <div class="value">{{ $employe->matricule ?? 'Non défini' }}</div>
                </div>
                <div class="info-group">
                    <div class="label">Service</div>
                    <div class="value">{{ $mon_service->nom_service ?? 'Non défini' }}</div>
                </div>
                <div class="info-group">
                    <div class="label">Catégorie</div>
                    <div class="value">{{ $employe->categorie->categorie ?? 'Non défini' }}</div>
                </div>
                <div class="info-group">
                    <div class="label">Date d'embauche</div>
                    <div class="value">
                        {{ $employe->date_embauche ? \Carbon\Carbon::parse($employe->date_embauche)->format('d/m/Y') : 'Non défini' }}
                    </div>
                </div>
                <div class="info-group">
                    <div class="label">Solde actuel</div>
                    <div class="value">{{ number_format($employe->categorie->sal_journalier ?? 0, 2, ',', ' ') }} €
                    </div>
                </div>
            </div>

            <!-- Détails du congé -->
            <div class="section-title">
                <i class="fas fa-calendar-alt"></i> Détails du congé
            </div>

            <div class="conge-details">
                <div class="detail-row">
                    <span class="detail-label">Type de congé</span>
                    <span class="detail-value">{{ $mon_conge->type_conge ?? 'Non défini' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date de début</span>
                    <span
                        class="detail-value">{{ $mon_conge ? \Carbon\Carbon::parse($mon_conge->date_debut)->format('d/m/Y') : 'Non défini' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date de fin</span>
                    <span
                        class="detail-value">{{ $mon_conge ? \Carbon\Carbon::parse($mon_conge->date_fin)->format('d/m/Y') : 'Non défini' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nombre de jours</span>
                    <span class="detail-value">
                        <strong>{{ $mon_conge ? \Carbon\Carbon::parse($mon_conge->date_debut)->diffInDays(\Carbon\Carbon::parse($mon_conge->date_fin)) + 1 : 0 }}</strong>
                        jour(s)
                    </span>
                </div>
                <div class="detail-row full-width">
                    <span class="detail-label">Solde estimé</span>
                    <span class="detail-value">{{ number_format($mon_conge->solde ?? 0, 2, ',', ' ') }} €</span>
                </div>
            </div>

            <!-- Motif -->
            @if ($mon_conge->motif ?? null)
                <div class="motif-section">
                    <div class="motif-label">
                        <i class="fas fa-file-alt me-1"></i> Motif du congé
                    </div>
                    <div class="motif-text">
                        {{ $mon_conge->motif }}
                    </div>
                </div>
            @endif

            <!-- ===== VALIDATIONS - 3 BOOLÉENS ===== -->
            <div class="section-title">
                <i class="fas fa-check-double"></i> Validations
            </div>

            <div class="validations-grid">
                <!-- Validation Chef de Service -->
                <div class="validation-item {{ $mon_conge->valide_serv ?? false ? 'valid' : 'invalid' }}">
                    <div class="validation-icon {{ $mon_conge->valide_serv ?? false ? 'valid' : 'invalid' }}">
                        <i
                            class="fas {{ $mon_conge->valide_serv ?? false ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                    </div>
                    <div class="validation-label">Chef de Service</div>
                    <div class="validation-status {{ $mon_conge->valide_serv ?? false ? '1' : 'invalid' }}">
                        {{ $mon_conge->valide_serv ?? false ? '✓ Validé' : '✗ En attente' }}
                    </div>
                </div>

                <!-- Validation Direction RH -->
                <div class="validation-item {{ $mon_conge->valide_national ?? false ? 'valid' : 'invalid' }}">
                    <div class="validation-icon {{ $mon_conge->valide_national ?? false ? 'valid' : 'invalid' }}">
                        <i
                            class="fas {{ $mon_conge->valide_national ?? false ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                    </div>
                    <div class="validation-label">Direction RH</div>
                    <div class="validation-status {{ $mon_conge->valide_national ?? false ? 'valid' : 'invalid' }}">
                        {{ $mon_conge->valide_national ?? false ? '✓ Validé' : '✗ En attente' }}
                    </div>
                </div>

                <!-- Validation Chef de Division -->
                <div class="validation-item {{ $mon_conge->valide_secDg ?? false ? 'valid' : 'invalid' }}">
                    <div class="validation-icon {{ $mon_conge->valide_secDg ?? false ? 'valid' : 'invalid' }}">
                        <i
                            class="fas {{ $mon_conge->valide_secDg ?? false ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                    </div>
                    <div class="validation-label">Chef de Division</div>
                    <div class="validation-status {{ $mon_conge->valide_secDg ?? false ? 'valid' : 'invalid' }}">
                        {{ $mon_conge->valide_secDg ?? false ? '✓ Validé' : '✗ En attente' }}
                    </div>
                </div>
            </div>


        </div>

        <!-- ===== PIED DE PAGE ===== -->
        <div class="autorisation-footer" style="padding: 0 35px 20px 35px;">
            <div class="signature-area">
                <div class="signature-line"></div>
                <div class="signature-label">Signature du Chef de Service</div>
            </div>
            <div class="signature-area">
                <div class="signature-line"></div>
                <div class="signature-label">Signature de l'Employé</div>
            </div>
            <div class="footer-note">
                <p>
                    <i class="fas fa-print me-1"></i> Document généré automatiquement<br>
                    <small>ARSP - Système de Gestion des Congés</small>
                </p>
            </div>
        </div>
    </div>

    <!-- ===== BOUTONS D'ACTION ===== -->
    <div class="action-buttons no-print">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Imprimer / PDF
        </button>
        <a href="{{ route('profile_employe') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>
    </div>

    <script>
        // Raccourci Ctrl+P pour imprimer
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                // Le comportement par défaut est conservé
            }
        });

        console.log('Document prêt pour l\'impression');
    </script>
</body>

</html>

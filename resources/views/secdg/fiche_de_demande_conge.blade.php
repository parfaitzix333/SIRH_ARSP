<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fiche de demande de congé</title>
    <style>
        :root {
            --blue: #bfe3ff;
            --blue-dark: #9fd0ef;
            --line: #000000;
            --panel: #eef7ff;
            --text: #1a1a1a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f3f4f6;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--text);
        }

        .sheet {
            width: 1000px;
            margin: 18px auto;
            background: #fff;
            border: 2px solid var(--line);
        }

        .sheet-header {
            background: var(--blue);
            border-bottom: 2px solid var(--line);
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
            padding: 10px 12px;
            font-size: 18px;
            letter-spacing: 0.5px;
        }

        .year-bar {
            text-align: center;
            background: var(--blue);
            border-bottom: 2px solid var(--line);
            padding: 3px 10px 8px;
            font-weight: 700;
            font-size: 18px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid var(--line);
            padding: 6px 8px;
            font-size: 12px;
            vertical-align: top;
        }

        .label {
            background: var(--panel);
            font-weight: 700;
            width: 18%;
        }

        .sub-title {
            background: var(--blue-dark);
            text-align: center;
            font-weight: 700;
            text-transform: uppercase;
            padding: 6px 8px;
            border: 1px solid var(--line);
            border-top: none;
            font-size: 12px;
        }

        .details thead th {
            background: var(--blue);
            color: #000;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
        }

        .details td {
            height: 25px;
            text-align: left;
        }

        .exercise-row td:first-child {
            font-weight: 700;
        }

        .signature-table {
            margin-top: 12px;
        }

        .signature-table th {
            background: var(--blue);
            font-weight: 700;
            text-align: center;
            font-size: 12px;
        }

        .signature-cell {
            height: 120px;
            position: relative;
            background: #fff;
        }

        .signature-name {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 8px;
            text-align: center;
            font-weight: 700;
            font-size: 12px;
        }

        .no-print {
            text-align: center;
            padding: 12px;
        }

        .btn-print {
            border: 1px solid #1d4ed8;
            background: #2563eb;
            color: #fff;
            padding: 8px 14px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            margin: 0 4px;
        }

        .btn-print:hover {
            background: #1d4ed8;
        }

        @media print {
            body {
                background: #fff;
            }

            .sheet {
                width: 100%;
                margin: 0;
                border: none;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    @php
        $employe = $demande->employe;
        $interimaire = $demande->interimaire;
        $audit = $employe?->audits?->where('annee_id', $demande->annee_id)?->sortByDesc('date_debut_service')?->first();
        $audit2 = $interimaire?->audits
            ?->where('annee_id', $demande->annee_id)
            ?->sortByDesc('date_debut_service')
            ?->first();
        $anneeActuelle = $demande->annee?->annee ?? now()->year;
        $conges = [
            [
                'type' => '1. Congé annuel',
                'duree' => '15 jours',
                'date_depart' => $demande->date_debut?->format('d/m/Y') ?? '',
                'date_retour' => $demande->date_fin?->format('d/m/Y') ?? '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '2. Congé de maternité',
                'duree' => '8 semaines',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '3. Congés de circonstance',
                'duree' => 'Max 15 jours/an',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '• Accouchement Épouse',
                'duree' => '2 jours',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '• Mariage de l’agent',
                'duree' => '4 jours',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '• Mariage d’un enfant',
                'duree' => '2 jours',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '• Décès d’1 conjoint/parent 1er degré',
                'duree' => '6 jours',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '• Décès parent 2e degré',
                'duree' => '2 jours',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '• Déménagement',
                'duree' => '2 jours',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
            [
                'type' => '4. Congé sans solde',
                'duree' => '10 jours',
                'date_depart' => '',
                'date_retour' => '',
                'jours_restants' => '',
                'obs' => '',
                'check' => '',
            ],
        ];
    @endphp

    {{-- Boutons (hors du sheet pour ne pas apparaître dans le PDF) --}}
    <div class="no-print">
        <button class="btn-print" onclick="generatePDF()">📄 Générer PDF</button>
        <button class="btn-print" onclick="window.print()">🖨️ Imprimer</button>
    </div>

    <div class="p-4 sheetmarginOut">
        <main class="sheet" id="sheet">
            <div class="sheet-header">Formulaire de demande de congé</div>
            <div class="year-bar">Année {{ $anneeActuelle }}</div>

            <table>
                <tr>
                    <td class="label">Nom :</td>
                    <td>{{ $employe?->nom ?? '—' }}</td>
                    <td>Date d'engagement :</td>
                    <td>{{ $employe?->date_engagement?->format('d/m/Y') ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Fonction :</td>
                    <td>{{ $audit?->role ?? '—' }}</td>
                    <td>Grade(CC,CB,CS,CD) :</td>
                    <td>{{ $employe?->grade?->designation ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Direction :</td>
                    <td>HAUT-KATANGA</td>
                    <td class="label">Matricule :</td>
                    <td>{{ $employe?->matricule ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Employeur :</td>
                    <td colspan="3">ARSP</td>
                </tr>
            </table>

            <div class="sub-title">Interimaire</div>

            <table>
                <tr>
                    <td class="label">Nom :</td>
                    <td>{{ $interimaire?->nom ?? '—' }}</td>
                    <td class="label">Grade(CB,CS,CD) :</td>
                    <td>{{ $interimaire?->grade?->designation ?? '—' }}</td>
                </tr>
                <tr>
                    <td class="label">Fonction :</td>
                    <td>{{ $audit2?->role ?? '—' }}</td>
                    <td class="label">Matricule :</td>
                    <td>{{ $interimaire?->matricule ?? '—' }}</td>
                </tr>
            </table>

            <table class="details" style="margin-top: 0;">
                <thead>
                    <tr>
                        <th style="width: 23%;">Type de Congé</th>
                        <th style="width: 12%;">Durée lég./Contr.</th>
                        <th style="width: 12%;">Date départ</th>
                        <th style="width: 12%;">Date retour</th>
                        <th style="width: 12%;">Jrs Restants</th>
                        <th style="width: 12%;">Observation</th>
                        <th style="width: 9%;">Check HR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($conges as $conge)
                        <tr>
                            <td>{{ $conge['type'] }}</td>
                            <td>{{ $conge['duree'] }}</td>
                            <td>{{ $conge['date_depart'] }}</td>
                            <td>{{ $conge['date_retour'] }}</td>
                            <td>{{ $conge['jours_restants'] }}</td>
                            <td>{{ $conge['obs'] }}</td>
                            <td>{{ $conge['check'] }}</td>
                        </tr>
                        @if ($loop->first)
                            @foreach ($exercices as $exercice)
                                <tr class="exercise-row">
                                    <td>* Exercice {{ $exercice['annee'] }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $exercice['jours'] }} jour(s)</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                            <tr class="exercise-row">
                                <td>* Cumul</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $cumulJours }} jour(s)</td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <table class="signature-table">
                <thead>
                    <tr>
                        <th style="width: 20%;">Agent</th>
                        <th style="width: 20%;">Sup.Hiérarch.</th>
                        <th style="width: 20%;">Directeur</th>
                        <th style="width: 20%;">DRH</th>
                        <th style="width: 20%;">Observations</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="signature-cell">
                            <div class="signature-name">Signature</div>
                        </td>
                        <td class="signature-cell">
                            <div class="signature-name">Signature</div>
                        </td>
                        <td class="signature-cell">
                            <div class="signature-name">Signature</div>
                        </td>
                        <td class="signature-cell">
                            <div class="signature-name">Signature</div>
                        </td>
                        <td class="signature-cell">
                            <div class="signature-name">{{ $demande->commentaire_validation ?: '—' }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
    </div>

    <!-- Bibliothèques -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script>
        async function generatePDF() {
            try {
                const sheet = document.getElementById('sheet');
                if (!sheet) {
                    throw new Error('La fiche à exporter est introuvable.');
                }

                // 1. Capture HTML → Canvas (haute résolution)
                const canvas = await html2canvas(sheet, {
                    scale: 2,
                    logging: false,
                    useCORS: true,
                    backgroundColor: '#ffffff'
                });

                // 2. Préparation du PDF (A4 portrait, mm)
                const {
                    jsPDF
                } = window.jspdf;
                const pdf = new jsPDF("p", "mm", "a4");

                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();

                // 🔒 Marge de protection (en mm) autour du contenu
                const margin = 10;

                // Dimensions utiles (zone imprimable)
                const usableWidth = pageWidth - margin * 2;
                const usableHeight = pageHeight - margin * 2;

                // Dimensions de l'image d'origine
                const imgData = canvas.toDataURL("image/png");
                const imgWidth = canvas.width;
                const imgHeight = canvas.height;

                // Calcul du ratio pour tenir dans la zone imprimable
                const ratioWidth = usableWidth / imgWidth;
                const ratioHeight = usableHeight / imgHeight;
                const ratio = Math.min(ratioWidth, ratioHeight);

                const finalWidth = imgWidth * ratio;
                const finalHeight = imgHeight * ratio;

                // Centrage horizontal
                const offsetX = margin + (usableWidth - finalWidth) / 2;

                if (finalHeight <= usableHeight) {
                    // ✅ Tout tient sur une seule page
                    pdf.addImage(imgData, "PNG", offsetX, margin, finalWidth, finalHeight);
                } else {
                    // 📄 Découpage sur plusieurs pages si nécessaire
                    let remainingHeight = imgHeight;
                    let position = 0;
                    let pageIndex = 0;

                    // Hauteur (en pixels source) correspondant à la zone imprimable
                    const pageContentHeightPx = usableHeight / ratio;

                    while (remainingHeight > 0) {
                        if (pageIndex > 0) pdf.addPage();

                        // Créer un canvas temporaire pour la tranche de cette page
                        const sliceHeightPx = Math.min(pageContentHeightPx, remainingHeight);
                        const sliceCanvas = document.createElement('canvas');
                        sliceCanvas.width = imgWidth;
                        sliceCanvas.height = sliceHeightPx;

                        const ctx = sliceCanvas.getContext('2d');
                        ctx.fillStyle = '#ffffff';
                        ctx.fillRect(0, 0, sliceCanvas.width, sliceCanvas.height);
                        ctx.drawImage(
                            canvas,
                            0, position, imgWidth, sliceHeightPx,
                            0, 0, imgWidth, sliceHeightPx
                        );

                        const sliceData = sliceCanvas.toDataURL('image/png');
                        const sliceFinalHeight = sliceHeightPx * ratio;

                        pdf.addImage(
                            sliceData,
                            'PNG',
                            offsetX,
                            margin,
                            finalWidth,
                            sliceFinalHeight
                        );

                        position += sliceHeightPx;
                        remainingHeight -= sliceHeightPx;
                        pageIndex++;
                    }
                }

                pdf.save("demande-conge-{{ $employe?->nom ?? 'agent' }}-{{ $demande->id }}.pdf");
                console.log("PDF généré avec succès !");
            } catch (error) {
                console.error("Erreur :", error);
                alert("Échec de génération du PDF. Voir la console.");
            }
        }
    </script>
</body>

</html>

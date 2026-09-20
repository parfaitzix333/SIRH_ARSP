<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fiche de demande de congé</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f1f3f5;
            color: #17202a;
        }

        .sheet {
            max-width: 900px;
            margin: 2rem auto;
            background: #fff;
            padding: 3rem;
            box-shadow: 0 4px 18px rgba(0, 0, 0, .12);
        }

        .signature {
            min-height: 180px;
            border: 1px solid #adb5bd;
            padding: 1rem;
        }

        .signature-name {
            margin-top: 7rem;
            font-weight: 600;
        }

        .document-logo {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 50%;
        }

        @media print {
            body {
                background: #fff;
            }

            .sheet {
                margin: 0;
                max-width: none;
                box-shadow: none;
                padding: 1rem;
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
        $audit = $employe?->audits?->where('annee_id', $demande->annee_id)?->sortByDesc('date_debut_service')?->first();
    @endphp

    <main class="sheet p-6">
        <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-4">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('image/logo.jpeg') }}" alt="Logo ARSP" class="document-logo">
                <div>
                    <strong>ARSP</strong><br>
                    <small>Autorité de Régulation de la Sous-traitance dans le Secteur Privé</small>
                </div>
                <h2 class="text-primary">Province du Haut-Katanga</h2>
            </div>

            <div class="text-end"><strong>FICHE DE DEMANDE DE CONGÉ</strong><br><small>Référence :
                    #{{ $demande->id }}</small></div>
        </div>
        <h4 class="text-center mb-4">Demande de congé</h4>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Employé</th>
                    <td>{{ $demande->employe?->nom ?? '—' }}</td>
                    <th>Matricule</th>
                    <td>{{ $demande->employe?->matricule ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Employeur</th>
                    <td colspan="3">Autorité de Régulation de la Sous-traitance dans le Secteur Privé (ARSP)</td>
                </tr>
                <tr>
                    <th>Service</th>
                    <td>{{ $employe?->service?->nom_service ?? '—' }}</td>
                    <th>Grade</th>
                    <td>{{ $employe?->grade?->designation ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Fonction</th>
                    <td colspan="3">{{ $audit?->role ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Type de congé</th>
                    <td>{{ $demande->conge?->designation ?? '—' }}</td>
                    <th>Année</th>
                    <td>{{ $demande->annee?->annee ?? '—' }}</td>
                </tr>
                <tr>
                    <th>Date de début</th>
                    <td>{{ $demande->date_debut?->format('d/m/Y') }}</td>
                    <th>Date de fin</th>
                    <td>{{ $demande->date_fin?->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Durée</th>
                    <td>{{ $demande->nombre_jour }} jour(s)</td>
                    <th>Statut</th>
                    <td>{{ ucfirst($demande->statut) }}</td>
                </tr>
                <tr>
                    <th>Motif</th>
                    <td colspan="3">{{ $demande->motif ?: '—' }}</td>
                </tr>
            </tbody>
        </table>
        <div class="mt-4"><strong>Observations :</strong>
            <p class="border rounded p-3" style="min-height: 80px;">{{ $demande->commentaire_validation ?: '—' }}</p>
        </div>
        <div class="row g-4 mt-5 p-4">
            <div class="col-3">
                <div class="signature">
                    <strong> de l'agent concerné</strong><br>
                    <small>{{ $employe?->nom ?? 'Agent concerné' }}</small>
                    <div class="signature-name">Signature</div>
                </div>
            </div>
            <div class="col-3">
                <div class="signature">
                    <strong> DRH</strong><br>

                    <div class="signature-name">Signature</div>
                </div>
            </div>
            <div class="col-3">
                <div class="signature">
                    <strong> Sup.Hiérarch.</strong><br>
                    <small>Signature et Sceau</small>
                    <div class="signature-name">Sceau</div>
                </div>
            </div>
            <div class="col-3">
                <div class="signature">
                    <strong>Directeur Général Provincial</strong><br>
                    <small>Signature et sceau</small>
                    <div class="signature-name"> Sceau</div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4 no-print"><button class="btn btn-primary" onclick="window.print()"><i
                    class="fas fa-print me-1"></i> Imprimer</button></div>
    </main>
</body>

</html>

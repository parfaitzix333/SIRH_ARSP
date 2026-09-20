@php
    $profil = $profil ?? 'dg';
    $annee = $annee ?? null;
@endphp

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Gestion des intérims</h3>
            <p class="text-muted mb-0">Affectations intérimaires de l’année sélectionnée.</p>
        </div>
        <span class="badge bg-primary-subtle text-primary fs-6">
            {{ $les_interims->count() }} intérim(s)
        </span>
    </div>

    @include('dg.partials.resource-table', [
        'title' => 'Intérims',
        'items' => $les_interims,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé titulaire'],
            ['key' => 'interimaire.nom', 'label' => 'Intérimaire'],
            ['key' => 'date_debut', 'label' => 'Date début', 'type' => 'date'],
            ['key' => 'date_fin', 'label' => 'Date fin', 'type' => 'date'],
        ],
        'resource' => 'interimes',
        'fields' => [
            [
                'key' => 'employe_id',
                'label' => 'Employé titulaire',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            ['key' => 'interimaire_id', 'label' => 'Intérimaire', 'type' => 'select', 'options' => 'employes'],
            ['key' => 'date_debut', 'label' => 'Date début', 'type' => 'date'],
            ['key' => 'date_fin', 'label' => 'Date fin', 'type' => 'date'],
            [
                'key' => 'annee_id',
                'label' => 'Année',
                'type' => 'select',
                'options' => 'annees',
                'required' => true,
            ],
        ],
        'formTitle' => 'Ajouter un intérim',
    ])
</div>

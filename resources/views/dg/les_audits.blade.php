@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Audits',
        'items' => $les_audits,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'role', 'label' => 'Rôle/Tâches'],
            ['key' => 'ordre', 'label' => 'Ordre'],
            ['key' => 'date_debut_service', 'label' => 'Début', 'type' => 'date'],
            ['key' => 'date_fin_service', 'label' => 'Fin', 'type' => 'date'],
        ],
        'resource' => 'audits',
        'fields' => [
            [
                'key' => 'employe_id',
                'label' => 'Employé',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            ['key' => 'role', 'label' => 'Rôle/Tâches', 'required' => false],
            ['key' => 'ordre', 'label' => 'Ordre', 'type' => 'number', 'required' => true],
            ['key' => 'date_debut_service', 'label' => 'Début du service', 'type' => 'date'],
            ['key' => 'date_fin_service', 'label' => 'Fin du service', 'type' => 'date'],
            [
                'key' => 'annee_id',
                'label' => 'Année',
                'type' => 'select',
                'options' => 'annees',
                'required' => true,
            ],
        ],
    ])
@endsection

@extends('cd.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Affectations',
        'items' => $les_affectations,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'service.nom_service', 'label' => 'Service'],
            ['key' => 'poste.intitule', 'label' => 'Poste'],
            ['key' => 'date_debut', 'label' => 'Début', 'type' => 'date'],
            ['key' => 'date_fin', 'label' => 'Fin', 'type' => 'date'],
        ],
        'resource' => 'affectations',
        'fields' => [
            [
                'key' => 'employe_id',
                'label' => 'Employé',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            [
                'key' => 'service_id',
                'label' => 'Service',
                'type' => 'select',
                'options' => 'services',
                'required' => true,
            ],
            ['key' => 'categorie_id', 'label' => 'Catégorie', 'type' => 'select', 'options' => 'categories'],
            ['key' => 'poste_id', 'label' => 'Poste', 'type' => 'select', 'options' => 'postes'],
            ['key' => 'date_debut', 'label' => 'Début', 'type' => 'date'],
            ['key' => 'date_fin', 'label' => 'Fin', 'type' => 'date'],
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

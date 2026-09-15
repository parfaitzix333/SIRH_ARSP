@extends('cd.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Formations des employés',
        'items' => $les_formations_employes,
        'fileRoute' => 'formations-employes.file',
        'columns' => [
            ['key' => 'formation.intitule', 'label' => 'Formation'],
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'statut', 'label' => 'Statut', 'type' => 'status'],
            ['key' => 'resultat', 'label' => 'Résultat'],
            ['key' => 'certificat', 'label' => 'Certificat', 'type' => 'file'],
        ],
        'resource' => 'formations-employes',
        'fields' => [
            [
                'key' => 'formation_id',
                'label' => 'Formation',
                'type' => 'select',
                'options' => 'formations',
                'required' => true,
            ],
            [
                'key' => 'employe_id',
                'label' => 'Employé',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            ['key' => 'statut', 'label' => 'Statut'],
            ['key' => 'resultat', 'label' => 'Résultat'],
            ['key' => 'certificat', 'label' => 'Certificat', 'type' => 'file'],
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

@extends('cs.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Employés',
        'items' => $les_employes,
        'columns' => [
            ['key' => 'matricule', 'label' => 'Matricule'],
            ['key' => 'nom', 'label' => 'Nom'],
            ['key' => 'service.nom_service', 'label' => 'Service'],
            ['key' => 'niveau_etude', 'label' => 'Niveau d’étude'],
        ],
        'resource' => 'employes',
        'fields' => [
            ['key' => 'matricule', 'label' => 'Matricule', 'required' => true],
            ['key' => 'nom', 'label' => 'Nom', 'required' => true],
            ['key' => 'service_id', 'label' => 'Service', 'type' => 'select', 'options' => 'services'],
            ['key' => 'date_naissance', 'label' => 'Date de naissance', 'type' => 'date'],
            ['key' => 'lieu_naissance', 'label' => 'Lieu de naissance'],
            ['key' => 'province_origine', 'label' => 'Province d’origine'],
            ['key' => 'territoire', 'label' => 'Territoire'],
            ['key' => 'localite', 'label' => 'Localité'],
            [
                'key' => 'niveau_etude',
                'label' => 'Niveau d’étude',
                'type' => 'select',
                'options' => [
                    ['value' => "Diplome d'etat", 'label' => "Diplome d'etat"],
                    ['value' => 'Licence(LMD)/Graduat', 'label' => 'Licence(LMD)/Graduat'],
                    ['value' => 'Master/Licence(AS)', 'label' => 'Master/Licence(AS)'],
                    ['value' => 'Doctorat', 'label' => 'Doctorat'],
                    ['value' => 'Autre', 'label' => 'Autre'],
                ],
            ],
            ['key' => 'user_id', 'label' => 'Compte utilisateur', 'type' => 'select', 'options' => 'users'],
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

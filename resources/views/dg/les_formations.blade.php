@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Formations',
        'items' => $les_formations,
        'columns' => [
            ['key' => 'intitule', 'label' => 'Intitulé'],
            ['key' => 'domaine', 'label' => 'Domaine'],
            ['key' => 'date_debut', 'label' => 'Début', 'type' => 'date'],
            ['key' => 'date_fin', 'label' => 'Fin', 'type' => 'date'],
            ['key' => 'nb_jour', 'label' => 'Jours'],
        ],
        'resource' => 'formations',
        'fields' => [
            ['key' => 'domaine', 'label' => 'Domaine'],
            ['key' => 'intitule', 'label' => 'Intitulé', 'required' => true],
            ['key' => 'date_debut', 'label' => 'Début', 'type' => 'date', 'required' => true],
            ['key' => 'date_fin', 'label' => 'Fin', 'type' => 'date', 'required' => true],
            ['key' => 'nb_jour', 'label' => 'Nombre de jours', 'type' => 'number'],
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

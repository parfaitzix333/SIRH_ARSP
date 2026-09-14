@extends('secdg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Services',
        'items' => $les_services,
        'columns' => [['key' => 'nom_service', 'label' => 'Service'], ['key' => 'domaine', 'label' => 'Domaine']],
        'resource' => 'services',
        'fields' => [
            ['key' => 'nom_service', 'label' => 'Nom du service', 'required' => true],
            ['key' => 'domaine', 'label' => 'Domaine'],
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

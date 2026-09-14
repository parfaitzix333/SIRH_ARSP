@extends('secdg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Postes',
        'items' => $les_posts,
        'columns' => [
            ['key' => 'intitule', 'label' => 'Intitulé'],
            ['key' => 'description', 'label' => 'Description'],
        ],
        'resource' => 'postes',
        'fields' => [
            ['key' => 'intitule', 'label' => 'Intitulé', 'required' => true],
            ['key' => 'description', 'label' => 'Description', 'type' => 'textarea'],
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

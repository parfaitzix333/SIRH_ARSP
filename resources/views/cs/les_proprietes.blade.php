@extends('cs.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Propriétés',
        'items' => $les_proprietes,
        'columns' => [['key' => 'titre', 'label' => 'Titre'], ['key' => 'nos_info', 'label' => 'Informations']],
        'resource' => 'proprietes',
        'fields' => [
            ['key' => 'titre', 'label' => 'Titre', 'required' => true],
            ['key' => 'nos_info', 'label' => 'Informations', 'type' => 'textarea'],
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

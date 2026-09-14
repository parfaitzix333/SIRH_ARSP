@extends('secdg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Catégories',
        'items' => $les_categories,
        'columns' => [['key' => 'designation', 'label' => 'Désignation']],
        'resource' => 'categories',
        'fields' => [
            ['key' => 'designation', 'label' => 'Désignation', 'required' => true],
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

@extends('secdg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Sanctions',
        'items' => $les_sanctions,
        'columns' => [['key' => 'designation', 'label' => 'Désignation']],
        'resource' => 'sanctions',
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

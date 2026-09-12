@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Types de congé',
        'items' => $les_conges,
        'columns' => [
            ['key' => 'designation', 'label' => 'Désignation'],
            ['key' => 'TYPE', 'label' => 'Type'],
            ['key' => 'indice', 'label' => 'Indice'],
            ['key' => 'actif', 'label' => 'Actif', 'type' => 'status'],
        ],
        'resource' => 'conges',
        'fields' => [
            ['key' => 'designation', 'label' => 'Désignation', 'required' => true],
            [
                'key' => 'TYPE',
                'label' => 'Type',
                'type' => 'select',
                'options' => [
                    ['value' => 'paye', 'label' => 'Payé'],
                    ['value' => 'non_paye', 'label' => 'Non payé'],
                ],
                'required' => true,
            ],
            [
                'key' => 'indice',
                'label' => 'Indice',
                'type' => 'select',
                'options' => [['value' => '++', 'label' => '++'], ['value' => '--', 'label' => '--']],
                'required' => true,
            ],
            ['key' => 'actif', 'label' => 'Actif', 'type' => 'checkbox'],
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

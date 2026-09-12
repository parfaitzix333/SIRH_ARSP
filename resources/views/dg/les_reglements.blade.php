@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Règlements',
        'items' => $les_reglements,
        'columns' => [
            ['key' => 'numero', 'label' => 'Numéro'],
            ['key' => 'designation', 'label' => 'Désignation'],
        ],
        'resource' => 'reglements',
        'fields' => [
            ['key' => 'numero', 'label' => 'Numéro', 'type' => 'number', 'required' => true],
            ['key' => 'designation', 'label' => 'Désignation', 'type' => 'textarea', 'required' => true],
        ],
    ])
@endsection

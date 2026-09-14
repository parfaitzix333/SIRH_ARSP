@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Règlements',
        'items' => $les_reglements,
        'columns' => [
            ['key' => 'numero', 'label' => 'Numéro'],
            ['key' => 'titre', 'label' => 'Titre'],
            ['key' => 'designation', 'label' => 'Description'],
        ],
        'resource' => 'reglements',
        'fields' => [
            ['key' => 'numero', 'label' => 'Numéro', 'type' => 'number', 'required' => true],
            ['key' => 'titre', 'label' => 'Titre', 'required' => true],
            ['key' => 'designation', 'label' => 'Description', 'type' => 'textarea', 'required' => true],
        ],
    ])
@endsection

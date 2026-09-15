@extends('secdg.base')

@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Grades',
        'items' => $les_grades,
        'columns' => [
            ['key' => 'numero', 'label' => 'Numéro'],
            ['key' => 'designation', 'label' => 'Désignation'],
            ['key' => 'employes_count', 'label' => 'Employés'],
        ],
        'resource' => 'grades',
        'fields' => [
            ['key' => 'numero', 'label' => 'Numéro', 'type' => 'number', 'required' => true],
            ['key' => 'designation', 'label' => 'Désignation', 'required' => true],
        ],
    ])
@endsection

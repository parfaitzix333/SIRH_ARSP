@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Performances',
        'items' => $les_performances,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'periode_debut', 'label' => 'Début', 'type' => 'date'],
            ['key' => 'periode_fin', 'label' => 'Fin', 'type' => 'date'],
            ['key' => 'cote_generale', 'label' => 'Cote générale'],
            ['key' => 'statut', 'label' => 'Statut', 'type' => 'status'],
        ],
    ])
@endsection

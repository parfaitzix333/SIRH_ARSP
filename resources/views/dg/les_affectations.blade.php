@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Affectations',
        'items' => $les_affectations,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'service.nom_service', 'label' => 'Service'],
            ['key' => 'poste.intitule', 'label' => 'Poste'],
            ['key' => 'date_debut', 'label' => 'Début', 'type' => 'date'],
            ['key' => 'date_fin', 'label' => 'Fin', 'type' => 'date'],
        ],
    ])
@endsection

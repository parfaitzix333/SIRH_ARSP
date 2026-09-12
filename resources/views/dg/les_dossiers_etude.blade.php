@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Dossiers d’étude',
        'items' => $les_dossiers_etude,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'titre', 'label' => 'Titre'],
            ['key' => 'description', 'label' => 'Description'],
        ],
    ])
@endsection

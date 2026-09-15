@extends('cd.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Dossiers d’étude',
        'items' => $les_dossiers_etudes,
        'fileRoute' => 'dossiers-etudes.file',
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'type_document', 'label' => 'Type de document'],
            ['key' => 'fichier', 'label' => 'Fichier', 'type' => 'file'],
            ['key' => 'annee.annee', 'label' => 'Année'],
        ],
        'resource' => 'dossiers-etudes',
        'fields' => [
            [
                'key' => 'employe_id',
                'label' => 'Employé',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            ['key' => 'type_document', 'label' => 'Type de document', 'required' => true],
            ['key' => 'fichier', 'label' => 'Fichier', 'type' => 'file', 'required' => true],
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

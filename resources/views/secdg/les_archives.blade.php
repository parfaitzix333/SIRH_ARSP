@extends('secdg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Archives',
        'items' => $les_archives,
        'fileRoute' => 'archives.file',
        'columns' => [
            ['key' => 'type_document', 'label' => 'Type'],
            ['key' => 'titre', 'label' => 'Titre'],
            ['key' => 'fichier', 'label' => 'Fichier', 'type' => 'file'],
            ['key' => 'date_archivage', 'label' => 'Date', 'type' => 'date'],
        ],
        'resource' => 'archives',
        'fields' => [
            ['key' => 'employe_id', 'label' => 'Employé', 'type' => 'select', 'options' => 'employes'],
            ['key' => 'type_document', 'label' => 'Type de document', 'required' => true],
            ['key' => 'titre', 'label' => 'Titre'],
            ['key' => 'fichier', 'label' => 'Fichier', 'type' => 'file', 'required' => true],
            ['key' => 'description', 'label' => 'Description', 'type' => 'textarea'],
            ['key' => 'date_archivage', 'label' => 'Date d’archivage', 'type' => 'date', 'required' => true],
            ['key' => 'archive_par', 'label' => 'Archivé par', 'type' => 'select', 'options' => 'users'],
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

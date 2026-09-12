@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Communiqués',
        'items' => $les_communiques,
        'columns' => [
            ['key' => 'titre', 'label' => 'Titre'],
            ['key' => 'role_cible', 'label' => 'Public cible'],
            ['key' => 'date_publication', 'label' => 'Publication', 'type' => 'date'],
            ['key' => 'contenu', 'label' => 'Contenu'],
        ],
        'resource' => 'communiques',
        'fields' => [
            ['key' => 'titre', 'label' => 'Titre', 'required' => true],
            ['key' => 'role_cible', 'label' => 'Public cible'],
            ['key' => 'date_publication', 'label' => 'Date de publication', 'type' => 'datetime'],
            ['key' => 'contenu', 'label' => 'Contenu', 'type' => 'textarea', 'required' => true, 'full' => true],
            ['key' => 'piece_jointe', 'label' => 'Pièce jointe'],
            ['key' => 'user_id', 'label' => 'Auteur', 'type' => 'select', 'options' => 'users'],
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

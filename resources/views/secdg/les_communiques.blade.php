@php
    $rolesCibles = [
        ['value' => 'tous', 'label' => 'tous'],
        ['value' => 'DG', 'label' => 'DG'],
        ['value' => 'SecDG', 'label' => 'SecDG'],
        ['value' => 'Chef-Division', 'label' => 'Chef-Division'],
        ['value' => 'Chef-Service', 'label' => 'Chef-Service'],
        ['value' => 'Chef-Bureau1', 'label' => 'Chef-Bureau1'],
        ['value' => 'Chef-Bureau2', 'label' => 'Chef-Bureau2'],
        ['value' => 'Chef-Bureau3', 'label' => 'Chef-Bureau3'],
        ['value' => 'Employe', 'label' => 'Employe'],
    ];
@endphp

@extends('secdg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Communiqués',
        'items' => $les_communiques,
        'columns' => [
            ['key' => 'titre', 'label' => 'Titre'],
            ['key' => 'user.role', 'label' => 'Rôle'],
            ['key' => 'user.name', 'label' => 'Auteur'],
            ['key' => 'role_cible', 'label' => 'Public cible'],
            ['key' => 'piece_jointe', 'label' => 'Pièce jointe', 'type' => 'file'],
            ['key' => 'date_publication', 'label' => 'Publication', 'type' => 'date'],
            [
                'key' => 'date_publication',
                'label' => 'Statut',
                'type' => 'computed_status',
            ],
            ['key' => 'contenu', 'label' => 'Contenu'],
        ],
        'resource' => 'communiques',
        'fields' => [
            ['key' => 'titre', 'label' => 'Titre', 'required' => true],
            [
                'key' => 'role_cible',
                'label' => 'Public cible',
                'type' => 'select',
                'options' => $rolesCibles,
                'required' => true,
                'default' => 'Tous',
            ],
            ['key' => 'date_publication', 'label' => 'Date de publication', 'type' => 'datetime'],
            ['key' => 'contenu', 'label' => 'Contenu', 'type' => 'textarea', 'required' => true, 'full' => true],
            ['key' => 'piece_jointe', 'label' => 'Pièce jointe', 'type' => 'file'],
            [
                'key' => 'user_id',
                'label' => 'Auteur',
                'type' => 'select',
                'options' => 'users',
                'required' => true,
                'default' => auth()->id(),
            ],
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

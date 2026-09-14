@extends('cs.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Disciplines',
        'items' => $les_disciplines,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'sanction.designation', 'label' => 'Sanction'],
            ['key' => 'etat', 'label' => 'État', 'type' => 'status'],
            ['key' => 'DATE', 'label' => 'Date', 'type' => 'date'],
            ['key' => 'contenu', 'label' => 'Contenu'],
        ],
        'resource' => 'disciplines',
        'fields' => [
            [
                'key' => 'employe_id',
                'label' => 'Employé',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            ['key' => 'sanction_id', 'label' => 'Sanction', 'type' => 'select', 'options' => 'sanctions'],
            [
                'key' => 'etat',
                'label' => 'État',
                'type' => 'select',
                'options' => [
                    ['value' => 'declaree', 'label' => 'Déclarée'],
                    ['value' => 'levee', 'label' => 'Levée'],
                ],
                'required' => true,
            ],
            ['key' => 'DATE', 'label' => 'Date', 'type' => 'date', 'required' => true],
            ['key' => 'contenu', 'label' => 'Contenu', 'type' => 'textarea', 'required' => true, 'full' => true],
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

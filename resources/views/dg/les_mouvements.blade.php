@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Mouvements',
        'items' => $les_mouvements,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'mouvement', 'label' => 'Mouvement', 'type' => 'status'],
            ['key' => 'heure', 'label' => 'Heure'],
        ],
        'resource' => 'mouvements',
        'fields' => [
            [
                'key' => 'employe_id',
                'label' => 'Employé',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            [
                'key' => 'mouvement',
                'label' => 'Mouvement',
                'type' => 'select',
                'options' => [
                    ['value' => 'Entrée', 'label' => 'Entrée'],
                    ['value' => 'Sortie', 'label' => 'Sortie'],
                ],
                'required' => true,
            ],
            ['key' => 'heure', 'label' => 'Heure', 'type' => 'time', 'required' => true],
        ],
    ])
@endsection

@extends('secdg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Présences',
        'items' => $les_presences,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'DATE', 'label' => 'Date', 'type' => 'date'],
            ['key' => 'heure', 'label' => 'Heure'],
            ['key' => 'mouvement', 'label' => 'Mouvement', 'type' => 'status'],
            ['key' => 'score_reconnaissance', 'label' => 'Score'],
            ['key' => 'autorisation', 'label' => 'Autorisation', 'type' => 'status'],
        ],
        'resource' => 'presences',
        'fields' => [
            [
                'key' => 'employe_id',
                'label' => 'Employé',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            ['key' => 'DATE', 'label' => 'Date', 'type' => 'date', 'required' => true],
            ['key' => 'heure', 'label' => 'Heure', 'type' => 'time', 'required' => true],
            [
                'key' => 'mouvement',
                'label' => 'Mouvement',
                'type' => 'select',
                'options' => collect([
                    ['value' => 'entree', 'label' => 'Entrée'],
                    ['value' => 'sortie', 'label' => 'Sortie'],
                ]),
                'required' => true,
            ],
            [
                'key' => 'score_reconnaissance',
                'label' => 'Score de reconnaissance',
                'type' => 'number',
                'step' => '0.00001',
                'min' => '0',
            ],
            ['key' => 'SOURCE', 'label' => 'Source', 'default' => 'desktop'],
            ['key' => 'synchronise', 'label' => 'Synchronisé', 'type' => 'checkbox', 'default' => false],
            [
                'key' => 'autorisation',
                'label' => 'Autorisation',
                'type' => 'select',
                'options' => collect([['value' => 'oui', 'label' => 'Oui'], ['value' => 'non', 'label' => 'Non']]),
                'default' => 'non',
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

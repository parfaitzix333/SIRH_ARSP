@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Demandes de congé',
        'items' => $les_demandes_conge,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'conge.designation', 'label' => 'Type de congé'],
            ['key' => 'date_debut', 'label' => 'Début', 'type' => 'date'],
            ['key' => 'date_fin', 'label' => 'Fin', 'type' => 'date'],
            ['key' => 'statut', 'label' => 'Statut', 'type' => 'status'],
        ],
        'resource' => 'demandes-conges',
        'fields' => [
            [
                'key' => 'employe_id',
                'label' => 'Employé',
                'type' => 'select',
                'options' => 'employes',
                'required' => true,
            ],
            [
                'key' => 'conge_id',
                'label' => 'Type de congé',
                'type' => 'select',
                'options' => 'conges',
                'required' => true,
            ],
            ['key' => 'date_debut', 'label' => 'Début', 'type' => 'date', 'required' => true],
            ['key' => 'date_fin', 'label' => 'Fin', 'type' => 'date', 'required' => true],
            ['key' => 'nombre_jour', 'label' => 'Nombre de jours', 'type' => 'number', 'required' => true],
            ['key' => 'motif', 'label' => 'Motif', 'type' => 'textarea'],
            [
                'key' => 'statut',
                'label' => 'Statut',
                'type' => 'select',
                'options' => [
                    ['value' => 'brouillon', 'label' => 'Brouillon'],
                    ['value' => 'soumise', 'label' => 'Soumise'],
                    ['value' => 'validee', 'label' => 'Validée'],
                    ['value' => 'refusee', 'label' => 'Refusée'],
                    ['value' => 'annulee', 'label' => 'Annulée'],
                ],
                'required' => true,
            ],
            ['key' => 'valide_par', 'label' => 'Validé par', 'type' => 'select', 'options' => 'users'],
            ['key' => 'date_validation', 'label' => 'Date de validation', 'type' => 'datetime'],
            ['key' => 'commentaire_validation', 'label' => 'Commentaire', 'type' => 'textarea'],
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

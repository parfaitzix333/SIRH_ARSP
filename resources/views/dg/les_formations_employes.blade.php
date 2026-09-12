@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Formations des employés',
        'items' => $les_formations_employes,
        'columns' => [
            ['key' => 'formation.intitule', 'label' => 'Formation'],
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'statut', 'label' => 'Statut', 'type' => 'status'],
            ['key' => 'resultat', 'label' => 'Résultat'],
            ['key' => 'certificat', 'label' => 'Certificat'],
        ],
    ])
@endsection

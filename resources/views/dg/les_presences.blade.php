@extends('dg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Présences',
        'items' => $les_presences,
        'columns' => [
            ['key' => 'employe.nom', 'label' => 'Employé'],
            ['key' => 'DATE', 'label' => 'Date', 'type' => 'date'],
            ['key' => 'heure', 'label' => 'Heure'],
            ['key' => 'mouvement', 'label' => 'Mouvement', 'type' => 'status'],
            ['key' => 'autorisation', 'label' => 'Autorisation', 'type' => 'status'],
        ],
    ])
@endsection

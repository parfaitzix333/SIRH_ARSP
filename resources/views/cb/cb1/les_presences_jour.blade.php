@extends('emp.base')

@section('content')
    @include('cb.cb1.partials.presences-table', [
        'presences' => $les_presences_jour,
        'titre' => 'Présences du jour',
        'description' => 'Consultez et gérez les présences enregistrées aujourd’hui.',
        'anneeId' => $anneeId,
        'actions' => true,
    ])
@endsection

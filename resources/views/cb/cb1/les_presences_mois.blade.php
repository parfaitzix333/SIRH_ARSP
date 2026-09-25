@extends('emp.base')

@section('content')
    @include('cb.cb1.partials.presences-table', [
        'presences' => $les_presences_mois,
        'titre' => 'Présences du mois',
        'description' => 'Consultez les présences enregistrées ce mois-ci.',
        'anneeId' => $anneeId,
        'actions' => false,
    ])
@endsection

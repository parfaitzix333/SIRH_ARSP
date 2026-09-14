@extends('secdg.base')
@section('content')
    @include('dg.partials.resource-table', [
        'title' => 'Contacts',
        'items' => $les_contacts,
        'columns' => [
            ['key' => 'email', 'label' => 'Email'],
            ['key' => 'tel', 'label' => 'Téléphone'],
            ['key' => 'whatsapp', 'label' => 'WhatsApp'],
            ['key' => 'adresse', 'label' => 'Adresse'],
        ],
        'resource' => 'contacts',
        'fields' => [
            ['key' => 'email', 'label' => 'Email', 'type' => 'email'],
            ['key' => 'whatsapp', 'label' => 'WhatsApp'],
            ['key' => 'tel', 'label' => 'Téléphone'],
            ['key' => 'adresse', 'label' => 'Adresse'],
            ['key' => 'longitude', 'label' => 'Longitude', 'type' => 'number', 'step' => 'any'],
            ['key' => 'latitude', 'label' => 'Latitude', 'type' => 'number', 'step' => 'any'],
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

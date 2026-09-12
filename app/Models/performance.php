<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class performance extends Model
{
    protected $fillable = [
        'employe_id',
        'evaluateur_id',
        'periode_debut',
        'periode_fin',
        'objectifs',
        'qualite_travail',
        'productivite',
        'ponctualite',
        'assiduite',
        'comportement',
        'travail_equipe',
        'cote_generale',
        'appreciation',
        'recommandations',
        'statut',
        'annee_id',
    ];

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function evaluateur()
    {
        return $this->belongsTo(User::class, 'evaluateur_id');
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class formation extends Model
{
    protected $fillable = ['domaine', 'intitule', 'date_debut', 'date_fin', 'nb_jour', 'annee_id'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function formationEmployes()
    {
        return $this->hasMany(formation_employe::class);
    }
}

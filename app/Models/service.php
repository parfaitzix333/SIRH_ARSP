<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class service extends Model
{
    protected $fillable = ['nom_service', 'domaine', 'annee_id'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function employes()
    {
        return $this->hasMany(employe::class);
    }

    public function affectations()
    {
        return $this->hasMany(affectation::class);
    }
}

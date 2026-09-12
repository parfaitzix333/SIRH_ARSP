<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class poste extends Model
{
    protected $fillable = ['intitule', 'description', 'annee_id'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function affectations()
    {
        return $this->hasMany(affectation::class);
    }
}

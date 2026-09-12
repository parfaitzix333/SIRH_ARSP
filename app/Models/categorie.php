<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class categorie extends Model
{
    protected $fillable = ['designation', 'annee_id'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function affectations()
    {
        return $this->hasMany(affectation::class);
    }
}

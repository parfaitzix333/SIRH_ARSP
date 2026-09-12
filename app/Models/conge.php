<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class conge extends Model
{
    protected $fillable = ['designation', 'TYPE', 'indice', 'actif', 'annee_id'];

    protected $casts = ['actif' => 'boolean'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function demandesConges()
    {
        return $this->hasMany(demandes_conge::class);
    }
}

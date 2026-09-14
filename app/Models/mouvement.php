<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mouvement extends Model
{
    protected $fillable = ['mouvement', 'employe_id', 'heure', 'annee_id'];

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

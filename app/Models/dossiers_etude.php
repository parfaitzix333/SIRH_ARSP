<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dossiers_etude extends Model
{
    protected $table = 'dossiers_etude';
    protected $fillable = ['designation', 'employe_id', 'annee_id'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }
}

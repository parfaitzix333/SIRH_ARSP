<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dossiers_etude extends Model
{
    protected $table = 'dossiers_etude';
    protected $fillable = [
        'type_document',
        'fichier',
        'annee_id',
        'employe_id',
    ];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }
}

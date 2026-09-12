<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class audit extends Model
{
    protected $fillable = [
        'employe_id',
        'role',
        'ordre',
        'date_debut_service',
        'date_fin_service',
        'annee_id',
    ];

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

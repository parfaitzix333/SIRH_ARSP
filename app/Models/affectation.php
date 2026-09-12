<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class affectation extends Model
{
    protected $fillable = [
        'employe_id',
        'service_id',
        'categorie_id',
        'poste_id',
        'date_debut',
        'date_fin',
        'annee_id',
    ];

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function service()
    {
        return $this->belongsTo(service::class);
    }

    public function categorie()
    {
        return $this->belongsTo(categorie::class);
    }

    public function poste()
    {
        return $this->belongsTo(poste::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

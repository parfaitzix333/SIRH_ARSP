<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class interime extends Model
{
    use HasFactory;

    protected $fillable = [
        'employe_id',
        'interimaire_id',
        'date_debut',
        'date_fin',
        'annee_id',
    ];

    /**
     * Employé titulaire.
     */
    public function employe()
    {
        return $this->belongsTo(employe::class, 'employe_id');
    }

    /**
     * Employé intérimaire.
     */
    public function interimaire()
    {
        return $this->belongsTo(employe::class, 'interimaire_id');
    }

    /**
     * Année de référence.
     */
    public function annee()
    {
        return $this->belongsTo(annee::class, 'annee_id');
    }
}

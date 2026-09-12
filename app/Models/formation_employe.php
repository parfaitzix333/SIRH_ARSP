<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class formation_employe extends Model
{
    protected $fillable = [
        'formation_id',
        'employe_id',
        'statut',
        'resultat',
        'certificat',
        'annee_id',
    ];

    public function formation()
    {
        return $this->belongsTo(formation::class);
    }

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

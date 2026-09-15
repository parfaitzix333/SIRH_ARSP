<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class demandes_conge extends Model
{
    protected $fillable = [
        'employe_id',
        'conge_id',
        'date_debut',
        'date_fin',
        'nombre_jour',
        'motif',
        'statut',
        'valide_par',
        'date_validation',
        'commentaire_validation',
        'annee_id',
        'valide_national',
        'valide_secDg',
        'valide_serv',
        'piece_justificative',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_validation' => 'datetime',
    ];

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function conge()
    {
        return $this->belongsTo(conge::class);
    }

    public function validePar()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

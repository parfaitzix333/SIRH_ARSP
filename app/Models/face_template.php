<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class face_template extends Model
{
    protected $fillable = [
        'employe_id',
        'face_embedding1',
        'face_embedding2',
        'face_embedding3',
        'face_embedding4',
        'face_embedding5',
        'mouvement',
        'heure',
        'DATE',
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

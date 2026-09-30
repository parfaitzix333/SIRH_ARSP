<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class presence extends Model
{
    protected $fillable = [
        'employe_id',
        'DATE',
        'heure',
        'mouvement',
        'score_reconnaissance',
        'annee_id',
    ];

    protected $casts = [
        'DATE' => 'date',
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

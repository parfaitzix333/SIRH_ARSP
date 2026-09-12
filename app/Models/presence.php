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
        'SOURCE',
        'synchronise',
        'synced_at',
        'annee_id',
        'autorisation',
    ];

    protected $casts = [
        'DATE' => 'date',
        'synchronise' => 'boolean',
        'synced_at' => 'datetime',
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

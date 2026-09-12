<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class discipline extends Model
{
    protected $fillable = [
        'employe_id',
        'sanction_id',
        'etat',
        'DATE',
        'contenu',
        'annee_id',
    ];

    protected $casts = ['DATE' => 'date'];

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function sanction()
    {
        return $this->belongsTo(sanction::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class communique extends Model
{
    protected $fillable = [
        'titre',
        'contenu',
        'piece_jointe',
        'role_cible',
        'user_id',
        'date_publication',
        'annee_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

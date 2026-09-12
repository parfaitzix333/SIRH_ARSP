<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class retour extends Model
{
    protected $fillable = ['user_id', 'retour_utilisateur', 'annee_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

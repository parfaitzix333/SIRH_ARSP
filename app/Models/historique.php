<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class historique extends Model
{
    protected $fillable = ['user_id', 'action', 'ip', 'annee_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

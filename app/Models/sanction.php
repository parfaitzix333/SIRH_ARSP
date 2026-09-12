<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sanction extends Model
{
    protected $fillable = ['designation', 'annee_id'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function disciplines()
    {
        return $this->hasMany(discipline::class);
    }
}

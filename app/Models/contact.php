<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class contact extends Model
{
    protected $fillable = ['email', 'whatsapp', 'tel', 'adresse', 'longitude', 'latitude', 'annee_id'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

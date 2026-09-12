<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class propriete extends Model
{
    protected $fillable = ['titre', 'nos_info', 'annee_id'];

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

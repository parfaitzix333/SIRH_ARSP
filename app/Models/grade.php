<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grade extends Model
{
    protected $fillable = ['numero', 'designation'];

    public function employes()
    {
        return $this->hasMany(employe::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lecture extends Model
{
    use HasFactory;

    protected $table = 'lectures';

    protected $fillable = [
        'employe_id',
        'communique_id',
        'lu',
        'lu_a',
        'annee_id',
    ];

    protected $casts = [
        'lu' => 'boolean',
        'lu_a' => 'datetime',
    ];

    public function employe()
    {
        return $this->belongsTo(employe::class, 'employe_id');
    }

    public function communique()
    {
        return $this->belongsTo(communique::class, 'communique_id');
    }

    public function annee()
    {
        return $this->belongsTo(annee::class, 'annee_id');
    }
}

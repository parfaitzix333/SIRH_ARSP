<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class archive extends Model
{
    protected $fillable = [
        'employe_id',
        'type_document',
        'titre',
        'fichier',
        'description',
        'date_archivage',
        'archive_par',
        'annee_id',
    ];

    public function employe()
    {
        return $this->belongsTo(employe::class);
    }

    public function archiviste()
    {
        return $this->belongsTo(User::class, 'archive_par');
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }
}

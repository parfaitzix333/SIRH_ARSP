<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employe extends Model
{
    protected $fillable = [
        'matricule',
        'nom',
        'grade_id',
        'service_id',
        'date_naissance',
        'date_engagement',
        'lieu_naissance',
        'province_origine',
        'territoire',
        'localite',
        'niveau_etude',
        'user_id',
        'annee_id',
        'emploiyeur',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_engagement' => 'date',
    ];

    public function grade()
    {
        return $this->belongsTo(grade::class);
    }

    public function service()
    {
        return $this->belongsTo(service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function affectations()
    {
        return $this->hasMany(affectation::class);
    }
    public function lectures()
    {
        return $this->hasMany(lecture::class);
    }

    public function dossiersEtude()
    {
        return $this->hasMany(dossiers_etude::class, 'employe_id');
    }

    public function audits()
    {
        return $this->hasMany(audit::class);
    }

    public function performances()
    {
        return $this->hasMany(performance::class);
    }

    public function archives()
    {
        return $this->hasMany(archive::class);
    }

    public function faceTemplates()
    {
        return $this->hasMany(face_template::class);
    }

    public function presences()
    {
        return $this->hasMany(presence::class);
    }

    public function mouvements()
    {
        return $this->hasMany(mouvement::class);
    }

    public function disciplines()
    {
        return $this->hasMany(discipline::class);
    }

    public function formationEmployes()
    {
        return $this->hasMany(formation_employe::class);
    }

    public function demandesConges()
    {
        return $this->hasMany(demandes_conge::class);
    }
}

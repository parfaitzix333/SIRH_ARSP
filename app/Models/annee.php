<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class annee extends Model
{
    protected $fillable = ['annee', 'statut'];

    public function services()
    {
        return $this->hasMany(service::class);
    }

    public function categories()
    {
        return $this->hasMany(categorie::class);
    }

    public function postes()
    {
        return $this->hasMany(poste::class);
    }

    public function employes()
    {
        return $this->hasMany(employe::class);
    }

    public function affectations()
    {
        return $this->hasMany(affectation::class);
    }

    public function dossiersEtude()
    {
        return $this->hasMany(dossiers_etude::class);
    }

    public function sanctions()
    {
        return $this->hasMany(sanction::class);
    }

    public function disciplines()
    {
        return $this->hasMany(discipline::class);
    }

    public function formations()
    {
        return $this->hasMany(formation::class);
    }

    public function audits()
    {
        return $this->hasMany(audit::class);
    }

    public function performances()
    {
        return $this->hasMany(performance::class);
    }

    public function communiques()
    {
        return $this->hasMany(communique::class);
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

    public function conges()
    {
        return $this->hasMany(conge::class);
    }

    public function demandesConges()
    {
        return $this->hasMany(demandes_conge::class);
    }

    public function proprietes()
    {
        return $this->hasMany(propriete::class);
    }

    public function contacts()
    {
        return $this->hasMany(contact::class);
    }

    public function retours()
    {
        return $this->hasMany(retour::class);
    }

    public function historiques()
    {
        return $this->hasMany(historique::class);
    }

    public function reglements()
    {
        return $this->hasMany(reglement::class);
    }

    public function mouvements()
    {
        return $this->hasMany(mouvement::class);
    }
}

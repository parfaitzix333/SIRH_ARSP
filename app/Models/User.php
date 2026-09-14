<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'matricule', 'annee_id', 'autorisation'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employes()
    {
        return $this->hasMany(employe::class);
    }

    public function annee()
    {
        return $this->belongsTo(annee::class);
    }

    public function performancesEvaluees()
    {
        return $this->hasMany(performance::class, 'evaluateur_id');
    }

    public function archives()
    {
        return $this->hasMany(archive::class, 'archive_par');
    }

    public function communiques()
    {
        return $this->hasMany(communique::class);
    }

    public function historiques()
    {
        return $this->hasMany(historique::class);
    }

    public function demandesCongesValidees()
    {
        return $this->hasMany(demandes_conge::class, 'valide_par');
    }

    public function retours()
    {
        return $this->hasMany(retour::class);
    }
}

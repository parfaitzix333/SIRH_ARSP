<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->constrained('employes');

            $table->foreignId('evaluateur_id')
                ->nullable()
                ->constrained('users');

            $table->date('periode_debut');
            $table->date('periode_fin');

            $table->text('objectifs')->nullable();

            $table->decimal('qualite_travail', 5, 2)->nullable();
            $table->decimal('productivite', 5, 2)->nullable();
            $table->decimal('ponctualite', 5, 2)->nullable();
            $table->decimal('assiduite', 5, 2)->nullable();
            $table->decimal('comportement', 5, 2)->nullable();
            $table->decimal('travail_equipe', 5, 2)->nullable();
            $table->decimal('cote_generale', 5, 2)->nullable();

            $table->text('appreciation')->nullable();
            $table->text('recommandations')->nullable();

            $table->enum('statut', [
                'brouillon',
                'soumise',
                'validee'
            ])->default('brouillon');

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performances');
    }
};

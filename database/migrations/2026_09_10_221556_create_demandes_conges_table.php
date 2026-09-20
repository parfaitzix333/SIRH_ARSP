<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes_conges', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->constrained('employes');
            $table->foreignId('interimaire_id')
                ->constrained('employes')->nullable();
            $table->foreignId('conge_id')
                ->constrained('conges');

            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('nombre_jour');
            $table->boolean('valide_national')->default(false);
            $table->boolean('valide_secDg')->default(false);
            $table->boolean('valide_serv')->default(false);
            $table->string('piece_justificative')->nullable();

            $table->date('date_validation')->nullable();

            $table->text('motif')->nullable();

            $table->enum('statut', [
                'brouillon',
                'soumise',
                'validee',
                'refusee',
                'annulee'
            ])->default('soumise');

            $table->foreignId('valide_par')
                ->nullable()
                ->constrained('users');

            $table->dateTime('date_validation')->nullable();

            $table->text('commentaire_validation')->nullable();

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_conges');
    }
};

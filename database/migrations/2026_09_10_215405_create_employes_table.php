<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();

            $table->string('matricule', 50)->unique();
            $table->string('nom', 150);
            $table->foreignId('grade_id')
                ->nullable();
            $table->foreignId('service_id')
                ->nullable();
            $table->date('date_naissance')->nullable();
            $table->date('date_engagement')->nullable();
            $table->string('lieu_naissance', 150)->nullable();
            $table->string('province_origine', 150)->nullable();
            $table->string('territoire', 150)->nullable();
            $table->string('localite', 150)->nullable();
            $table->string('niveau_etude', 150)->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users');
            $table->string('emploiyeur')
                ->default('ARSP');

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};

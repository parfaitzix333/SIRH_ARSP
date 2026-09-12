<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_employes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('formation_id')
                ->constrained('formations');

            $table->foreignId('employe_id')
                ->constrained('employes');

            $table->string('statut', 100)->nullable();
            $table->string('resultat', 100)->nullable();
            $table->string('certificat', 255)->nullable();

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_employes');
    }
};

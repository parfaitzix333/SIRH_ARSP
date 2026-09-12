<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->constrained('employes');

            $table->foreignId('service_id')
                ->constrained('services');

            $table->foreignId('categorie_id')
                ->nullable()
                ->constrained('categories');

            $table->foreignId('poste_id')
                ->nullable()
                ->constrained('postes');

            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('affectations');
    }
};
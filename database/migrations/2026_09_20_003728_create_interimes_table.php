<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employe_id')
                ->constrained('employes');

            $table->foreignId('interimaire_id')
                ->constrained('employes');

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interimes');
    }
};

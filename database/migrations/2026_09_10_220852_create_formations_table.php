<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();

            $table->string('domaine', 150)->nullable();
            $table->string('intitule', 200);

            $table->date('date_debut');
            $table->date('date_fin');

            $table->integer('nb_jour')->nullable();

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};

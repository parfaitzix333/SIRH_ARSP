<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dossiers_etude', function (Blueprint $table) {
            $table->id();

            $table->string('type_document', 100);
            $table->string('fichier', 255);

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->foreignId('employe_id')
                ->constrained('employes');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dossiers_etude');
    }
};

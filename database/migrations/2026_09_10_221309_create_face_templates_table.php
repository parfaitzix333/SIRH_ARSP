<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('face_templates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->constrained('employes');

            $table->binary('face_embedding1');
            $table->binary('face_embedding2')->nullable();
            $table->binary('face_embedding3')->nullable();
            $table->binary('face_embedding4')->nullable();
            $table->binary('face_embedding5')->nullable();

            $table->enum('mouvement', [
                'entree',
                'sortie'
            ]);

            $table->time('heure');
            $table->date('DATE');

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('face_templates');
    }
};

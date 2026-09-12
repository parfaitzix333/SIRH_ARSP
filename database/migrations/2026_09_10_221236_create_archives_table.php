<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archives', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->nullable()
                ->constrained('employes');

            $table->string('type_document', 150);
            $table->string('titre', 255)->nullable();
            $table->string('fichier', 255);
            $table->text('description')->nullable();

            $table->date('date_archivage');

            $table->foreignId('archive_par')
                ->nullable()
                ->constrained('users');

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};

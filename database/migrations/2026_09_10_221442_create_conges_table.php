<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conges', function (Blueprint $table) {
            $table->id();

            $table->string('designation', 150);

            $table->enum('TYPE', [
                'paye',
                'non_paye'
            ]);

            $table->enum('indice', [
                '++',
                '--'
            ]);

            $table->boolean('actif')
                ->default(true);

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conges');
    }
};

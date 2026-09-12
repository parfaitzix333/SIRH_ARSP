<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disciplines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->constrained('employes');

            $table->foreignId('sanction_id')
                ->nullable()
                ->constrained('sanctions');

            $table->enum('etat', ['declaree', 'levee'])
                ->default('declaree');

            $table->date('DATE');
            $table->text('contenu');

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disciplines');
    }
};

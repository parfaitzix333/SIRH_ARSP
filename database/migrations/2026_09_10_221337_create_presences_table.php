<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employe_id')
                ->constrained('employes');

            $table->date('DATE');
            $table->time('heure');

            $table->enum('mouvement', [
                'entree',
                'sortie'
            ]);

            $table->decimal('score_reconnaissance', 6, 5)->nullable();

            $table->string('SOURCE', 50)
                ->default('desktop');

            $table->boolean('synchronise')
                ->default(false);

            $table->dateTime('synced_at')->nullable();

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->enum('autorisation', [
                'oui',
                'non'
            ])->default('non');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};

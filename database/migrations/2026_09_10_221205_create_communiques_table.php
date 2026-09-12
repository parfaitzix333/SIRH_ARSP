<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communiques', function (Blueprint $table) {
            $table->id();

            $table->string('titre', 255);
            $table->text('contenu');
            $table->string('piece_jointe', 255)->nullable();

            $table->string('role_cible', 100)->nullable();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users');

            $table->dateTime('date_publication')->nullable();

            $table->foreignId('annee_id')
                ->constrained('annees');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communiques');
    }
};

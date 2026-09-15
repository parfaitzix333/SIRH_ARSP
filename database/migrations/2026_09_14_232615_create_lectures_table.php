<?php

use App\Models\annee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employe_id');
            $table->unsignedBigInteger('communique_id');
            $table->boolean('lu')->default(false);
            $table->timestamp('lu_a')->nullable();
            $table->foreignId('annee_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};

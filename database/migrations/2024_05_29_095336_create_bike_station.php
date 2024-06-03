<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Création de la table avec des stations de vélo avec toutes les données voulu
    public function up(): void
    {
        Schema::create('bike_station', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('nbr_available')->nullable();
            $table->integer('pct_available')->nullable();
            $table->integer('bike_available')->nullable();
            $table->float('lon');
            $table->float('lat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // Suppression de ta table des stations de vélos
    public function down(): void
    {
        Schema::dropIfExists('bike_station');
    }
};

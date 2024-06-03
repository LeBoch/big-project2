<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Création de la table bus stop avec les propriétes
    public function up(): void
    {
        Schema::create('bus_stop', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->float('lon');
            $table->float('lat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    // Suppresion de la table bus stop
    public function down(): void
    {
        Schema::dropIfExists('bus_stop');
    }
};

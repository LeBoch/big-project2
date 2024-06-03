<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Création de la table car parking avec les propriétes
    public function up(): void
    {
        Schema::create('car_parking', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('nbr_total_space')->nullable();
            $table->integer('nbr_space_available')->nullable();
            $table->float('lon');
            $table->float('lat');
            $table->string('authorized_car_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    // Suppression de la table Car Parking
    public function down(): void
    {
        Schema::dropIfExists('car_parking');
    }
};

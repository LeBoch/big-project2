<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $bikeController = new \App\Http\Controllers\BikeController();
        $carController = new \App\Http\Controllers\CarController();
        $tramController = new \App\Http\Controllers\TramController();
        $busController = new \App\Http\Controllers\BusController();

        $bikeController->fetchData();
        $carController->fetchData();
        $tramController->fetchData();
        $busController->fetchData();
    }
}

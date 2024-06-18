<?php

use App\Models\Bike;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


$bikeController = new \App\Http\Controllers\BikeController();
$carController = new \App\Http\Controllers\CarController();
$tramController = new \App\Http\Controllers\TramController();
$busController = new \App\Http\Controllers\BusController();


// Appel de notre controller avec la methode pour récupérer toutes les données des stations de vélos
Schedule::call(function () use ($bikeController) {
    $bikeController->fetchData();
    // Appel de cette méthode toutes les 5 minutes
})->everyFiveMinutes();

// Appel de notre controller avec la methode pour récupérer toutes les données des parkings de bus
Schedule::call(function () use ($carController) {
    $carController->fetchData();
    // Appel de cette méthode toutes les 5 minutes
})->everyFiveMinutes();
//})->everyMinute();
// Appel de notre controller avec la methode pour récupérer toutes les données des arrêts de tram
Schedule::call(function () use ($tramController) {
    $tramController->fetchData();
    // Appel de cette méthode tout les mois
})->monthly();
//})->everyMinute();
// Appel de notre controller avec la methode pour récupérer toutes les données des arrêts de bus
Schedule::call(function () use ($busController) {
    $busController->fetchData();
    // Appel de cette méthode tout les mois
})->monthly();
//})->everyMinute();



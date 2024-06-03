<?php

use App\Models\Bike;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Appel de notre controller avec la methode pour récupérer toutes les données des stations de vélos
Schedule::call(function () {
    $data = new \App\Http\Controllers\BikeController();
    $data->fetchData();
    // Appel de cette méthode toutes les 5 minutes
})->everyFiveMinutes();

// Appel de notre controller avec la methode pour récupérer toutes les données des parkings de bus
Schedule::call(function () {
    $data = new \App\Http\Controllers\CarController();
    $data->fetchData();
    // Appel de cette méthode toutes les 5 minutes
})->everyFiveMinutes();

// Appel de notre controller avec la methode pour récupérer toutes les données des arrêts de tram
Schedule::call(function () {
    $data = new \App\Http\Controllers\TramController();
    $data->fetchData();
    // Appel de cette méthode tout les mois
})->monthly();

// Appel de notre controller avec la methode pour récupérer toutes les données des arrêts de bus
Schedule::call(function () {
    $data = new \App\Http\Controllers\BusController();
    $data->fetchData();
    // Appel de cette méthode tout les mois
})->monthly();

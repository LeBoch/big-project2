<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/bike/station', [\App\Http\Controllers\BikeController::class, 'getAllBikeStation'])->name('bike-station');

Route::get('/car/parking', [\App\Http\Controllers\CarController  ::class, 'getAllCarsParking'])->name('car-parking');

Route::get('/bus/stop', [\App\Http\Controllers\BusController  ::class, 'getAllBusStop']);

Route::get('/tram/stop', [\App\Http\Controllers\TramController  ::class, 'getAllTramStop'])->name('tram-stop');

Route::get('/tram/coordinates', [\App\Http\Controllers\TramController  ::class, 'getALlTramLines'])->name('tram-lines');


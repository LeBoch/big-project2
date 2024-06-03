<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Support\Facades\Http;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Recupération de toutes les parkings de montpellier avec l'API
    public function fetchData()
    {
        $response = Http::get('https://www.herault-data.fr/api/explore/v2.1/catalog/datasets/parkingtpsreel_modele0/records?limit=100');
        if ($response->successful()) {
            $data = $response->json();
            // Truncate pour reset les ID
            Car::query()->truncate();
            foreach ($data['results'] as $value) {
                // Récupération des données voulu et insertion dans la BDD
                $car = new Car();
                $car->forceFill([
                    'name' => $value['name'],
                    'nbr_total_space' => $value['nombre_total_de_places'],
                    'nbr_space_available' => $value['nombre_de_places_disponibles'],
                    'lon' => $value['geo_point_2d']['lon'],
                    'lat' => $value['geo_point_2d']['lat'],
                    'authorized_car_type' => $value['type_de_vehicule_autorise']
                ])->save();
            }
        }
    }
// Récupération de toutes les emplacements de Parkings avec leurs données
    public function getAllCarsParking()
    {
        $car = Car::all();
        return response()->json($car);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Support\Facades\Http;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Recuperation de toutes les stations de Vélos
    public function getAllBikeStation()
    {
          $bike = Bike::all();
            return response()->json($bike);
    }

    // Récupération des données de l'api et insertion en base de données
    public function fetchData(){
        $response = Http::get('https://www.herault-data.fr/api/explore/v2.1/catalog/datasets/tam_mmm_velomag/records?limit=100');
        if ($response->successful()) {
            // Truncate pour reset les ID à chaque mise à jour
            Bike::query()->truncate();
            $data = $response->json();
            // Récupération et insertions des données voulu en BDD
            foreach ($data['results'] as $value) {
                $bike = new Bike();
                $bike->forceFill([
                    'lon' => $value['geo_point_2d']['lon'],
                    'lat' => $value['geo_point_2d']['lat'],
                    'name' => $value['address'],
                    'nbr_available' => $value['freeslotnumber'],
                    'bike_available' => $value['num_bikes_available'],
                    'pct_available' => $value['pourcentage_de_velos_restants'],
                ])->save();
            }
        }
    }

}


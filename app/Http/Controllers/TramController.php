<?php

namespace App\Http\Controllers;

use App\Models\Tram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TramController extends Controller
{
    // Recupération de tout les trams pour les afficher en front
    public function getAllTramStop()
    {
        $tram = Tram::all();
        return response()->json($tram);
    }

    // Recupération de toutes les coordonées des lignes de trams pour pouvoir afficher la ligne
    public function getALlTramLines()
    {
        $response = Http::get('https://www.herault-data.fr/api/explore/v2.1/catalog/datasets/reseau-de-tramway-de-montpellier-mediterranee-metropole/records?limit=5');
        if ($response->successful()) {
            $data = $response->json();
            $reversed_data = $data;
            foreach ($reversed_data['results'] as &$result) {
                if (isset($result['geo_shape']['geometry']['coordinates'])) {
                    // Array Reverse pour la raison que les données sont inversés dans l'API Hérault Data
                    $result['geo_shape']['geometry']['coordinates'] = array_map(fn($el) => array_reverse($el), $result['geo_shape']['geometry']['coordinates']);
                }
            }
            return response()->json($reversed_data);
        } else {
            return response()->json(['error' => 'API request failed'], $response->status());
        }
    }

    /**
     * Recuperation de tous les arrets de TRAM à l'aide de l'API
     * @return void
     */
    public function fetchData()
    {
        // On appelle l'api pour récupérer tous les tram
        $offset = 1;
        $response = Http::get("https://www.herault-data.fr/api/explore/v2.1/catalog/datasets/tam_mmm_tpsreel/records?limit=100&refine=route_short_name%3A%221%22&refine=route_short_name%3A%222%22&refine=route_short_name%3A%223%22&refine=route_short_name%3A%224%22");
        if ($response->successful()) {
            // On truncate la table pour reset les ids
            Tram::query()->truncate();
            $data = $response->json();

            // On converti le json en modèle Tram et on les enregistre en base de données
            foreach ($data['results'] as $value) {
                $tram = new Tram();
                if (isset($value['stop_coordinates']['lat']) && isset($value['stop_coordinates']['lon'])) {
                    $tram->forceFill([
                        'lon' => $value['stop_coordinates']['lon'],
                        'lat' => $value['stop_coordinates']['lat'],
                        'name' => $value['stop_name'],
                    ])->save();
                }
            }
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Support\Facades\Http;

class BusController extends Controller
{
    // Récupération de tous les bus pour pouvoir les afficher en front
    public function getAllBusStop(){
        $bus = Bus::all();
        return response()->json($bus);
    }

    public function fetchData()
    {
        // Mise en place d'un offset initial à 0
        $offset = 0;

        // Premier appel pour obtenir le nombre total d'entrées
        $response = Http::get("https://www.herault-data.fr/api/explore/v2.1/catalog/datasets/tam_mmm_tpsreel/records?limit=1&offset={$offset}");
        if ($response->successful()) {
            $data = $response->json();
            $totalCount = $data['total_count'];
        } else {
            // Gérer le cas où la requête échoue
            throw new Exception("Failed to fetch data from the API.");
        }

        // Truncate les bus pour reset les ID
        Bus::query()->truncate();

        // Boucle pour récupérer les données par lots de 100
        while ($offset < $totalCount) {
            $response = Http::get("https://www.herault-data.fr/api/explore/v2.1/catalog/datasets/tam_mmm_tpsreel/records?limit=100&offset={$offset}");
            if ($response->successful()) {
                $data = $response->json();
                foreach ($data['results'] as $value) {
                    // Récupération uniquement des bus (le numéro des lignes de bus commence après 6)
                    if ($value['route_short_name'] > 6) {
                        // Récupération des données de l'API et insertion des données dans la BDD
                        $car = new Bus();
                        if (isset($value['stop_coordinates']['lat']) && isset($value['stop_coordinates']['lon'])) {
                            $car->forceFill([
                                'lon' => $value['stop_coordinates']['lon'],
                                'lat' => $value['stop_coordinates']['lat'],
                                'name' => $value['stop_name'],
                            ])->save();
                        }
                    }
                }
                // On rajoute 100 à notre offset pour pouvoir récupérer les prochaines données
                $offset += 100;
            } else {
                // Gérer le cas où la requête échoue
                throw new Exception("Failed to fetch data from the API at offset {$offset}.");
            }
        }
    }

}

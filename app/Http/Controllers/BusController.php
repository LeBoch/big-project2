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
        // Mise en place d'un offset à 1 ( dernier ID récupérer )
        $offset = 1;
        $response = Http::get("https://www.herault-data.fr/api/explore/v2.1/catalog/datasets/tam_mmm_tpsreel/records?limit=100&offset={$offset}");
        if ($response->successful()) {
            $data = $response->json();
            $totalCount = $data['total_count'];
        }
        // Truncate les bus pour reset les ID
        Bus::query()->truncate();
        // Bouclage sur la division par 100 du nombre total d'entrée dans l'api , nous avons un maximum de 100 entrée par appel
        for ($i = 0; $i < $totalCount / 100; $i++) {
            // Mise en place de notre offset dans notre url pour pouvoir récupérer les données par rapport au dernier ID
            $response = Http::get("https://www.herault-data.fr/api/explore/v2.1/catalog/datasets/tam_mmm_tpsreel/records?limit=100&offset={$offset}");
            if ($response->successful()) {
                $data = $response->json();
                foreach ($data['results'] as $value) {
                    // Recuperation uniquement que des bus ( le numéro des lignes de bus commence après 6 )
                    if ($value['route_short_name'] > 6) {
                        // Recuperation des données de l'api et insertions des données dans notre BDD
                        $car = new Bus();
                        if (isset($value['stop_coordinates']['lat']) && isset($value['stop_coordinates']['lon'])) {
                            $car->forceFill([
                                'lon' => $value['stop_coordinates']['lon'],
                                'lat' => $value['stop_coordinates']['lat'],
                                'name' => $value['stop_name'],
                            ])->save();
                            // On rajoute 100 a notre offset pour pouvoir récuperer les prochaines données
                            $offset += 100;
                        }
                    }
                }

            }
        }
    }
}

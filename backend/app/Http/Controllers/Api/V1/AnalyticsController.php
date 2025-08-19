<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Cache;


class AnalyticsController extends Controller
{
    public function consoMoyenneParModele(){


        $stats = Cache::remember('conso_moyenne_par_modele', 3600, function () {
            return DB::table('vehicules')
                ->select('modele', DB::raw('ROUND(AVG(conso_energetique)::numeric, 2) as consoMoyenne'))
                ->groupBy('modele')
                ->get();
        });

        return response()->json($stats);

    }


    public function compareEmissions()
    {
    
        $stats = Cache::remember('emissions_comparaison', 3600, function () {
            return DB::table('vehicules')
                ->select(
                    'type_moteur',
                    DB::raw('AVG(emission_co) AS moyenne_emission'),
                    DB::raw('MIN(emission_co) AS min_emission'),
                    DB::raw('MAX(emission_co) AS max_emission'),
                    DB::raw('COUNT(*) AS nb_vehicules')
                )
                ->groupBy('type_moteur')
                ->get();
        });

        return response()->json($stats);
    }

    public function tauxDisponibilite(){

   $stats = Cache::remember('taux_disponibilite', 3600, function () {
    $vehiculesDispo = DB::table('vehicules')
        ->select(DB::raw('COUNT(*) AS nb_vehicules_dispo'))
        ->where('statut','<>', 'available')
        ->first();

    $vehiculesTotal = DB::table('vehicules')
        ->select(DB::raw('COUNT(*) AS nb_vehicules_total'))
        ->first();
    
    $tauxDisponibilite = $vehiculesDispo->nb_vehicules_dispo / $vehiculesTotal->nb_vehicules_total * 100;

    return [
        'taux_disponibilite' => round($tauxDisponibilite, 2)
    ];
});      
      return response()->json($stats);

    }

    public function fleetComposition(){

    $stats = Cache::remember('vehicules_type_moteur', 3600, function () {
    $stats = DB::table('vehicules')
        ->select(
            'type_moteur',
            DB::raw('COUNT(*) AS nb_vehicules')
        )
        ->groupBy('type_moteur')
        ->get();

    $vehiculesTotal = DB::table('vehicules')
        ->select(DB::raw('COUNT(*) AS nb_vehicules_total'))
        ->first();

    return $stats->map(function ($item) use ($vehiculesTotal) {
        $item->proportion = round(($item->nb_vehicules / $vehiculesTotal->nb_vehicules_total) * 100, 2);
        return $item;
    });
});
            

        return response()->json($stats);

            }


            public function fleetOperational(){

                $stats = Cache::remember('fleet_operational',3600,function(){

                    return DB::table('vehicules')
                    ->select(
                        'statut',
                        DB::raw('COUNT(*) AS nb_vehicules')
                    )
                    ->where('statut', '<>', 'charging','and','in_use')
                    ->groupBy('statut')
                    ->get();
                });

                return response()->json($stats);
            }

}

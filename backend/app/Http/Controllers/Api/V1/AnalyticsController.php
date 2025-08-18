<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use DB;


class AnalyticsController extends Controller
{
    public function consoMoyenneParModele(){

        $stats = DB::table('vehicules')
        ->select('modele',DB::raw('ROUND(AVG(conso_energetique)::numeric, 2) as consoMoyenne'))
        ->groupBy('modele')
        ->get();

        return response()->json($stats);

    }


    public function compareEmissions()
    {

     $stats = DB::table('vehicules')
            ->select(
                'type_moteur',
                DB::raw('AVG(emission_co) AS moyenne_emission'),
                DB::raw('MIN(emission_co) AS min_emission'),
                DB::raw('MAX(emission_co) AS max_emission'),
                DB::raw('COUNT(*) AS nb_vehicules')
            )
            ->groupBy('type_moteur')
            ->get();
        return response()->json($stats);
    }

    public function tauxDisponibilite(){

        $vehiculesDispo = DB::table('vehicules')
            ->select(DB::raw('COUNT(*) AS nb_vehicules_dispo')
            )
            ->where('statut','<>', 'available')
            ->get();

        $vehiculesTotal = DB::table('vehicules')
            ->select(DB::raw('COUNT(*) AS nb_vehicules_total'))
            ->get();

      $tauxDisponibilite = $vehiculesDispo[0]->nb_vehicules_dispo / $vehiculesTotal[0]->nb_vehicules_total * 100;

        $stats = [
            'taux_disponibilite' => round($tauxDisponibilite, 2)
        ];

        return response()->json($stats);

    }

    public function fleetComposition(){

        $stats = DB::table('vehicules')
            ->select(
                'type_moteur',
                DB::raw('COUNT(*) AS nb_vehicules')
            )
            ->groupBy('type_moteur')
            ->get();

           $vehiculesTotal = DB::table('vehicules')
            ->select(DB::raw('COUNT(*) AS nb_vehicules_total'))
            ->get();


            $stats = $stats->map(function ($item) use ($vehiculesTotal) {
                $item->proportion = round(($item->nb_vehicules / $vehiculesTotal[0]->nb_vehicules_total) * 100, 2);
                return $item;
            });

        return response()->json($stats);

            }


            public function fleetOperational(){

                $stats = DB::table('vehicules')
                    ->select(
                        'statut',
                        DB::raw('COUNT(*) AS nb_vehicules')
                    )
                    ->where('statut', '<>', 'charging','and','in_use')
                    ->groupBy('statut')
                    ->get();

                return response()->json($stats);
            }

}

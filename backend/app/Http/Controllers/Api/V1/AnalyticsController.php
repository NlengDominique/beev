<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use DB;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function consoMoyenneParModele(){

        $stats = DB::table('vehicules')
        ->select('modele',DB::raw('ROUND(AVG(conso_energetique)::numeric, 2) as consoMoyenne'))
        ->groupBy('modele')
        ->get();

        return response()->json($stats);

    }
}

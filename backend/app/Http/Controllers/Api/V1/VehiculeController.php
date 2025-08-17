<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $vehicles = QueryBuilder::for(Vehicule::class)
            ->allowedFilters(['marque', 'modele', 'statut','type_moteur'])
            ->paginate(10);

        return response()->json($vehicles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $vehicule =Vehicule::find($id);

       if(!$vehicule) {
           return response()->json(['message' => 'Vehicle not found'], 404);
       }

       return response()->json($vehicule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\VehiculeNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicule\V1\StoreRequest;
use App\Http\Requests\Vehicule\V1\UpdateRequest;
use App\Http\Resources\V1\VehiculeResource;
use App\Models\Vehicule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Cache;
use App\Exceptions\InvalidUuidException;
use Str;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    $vehicles = Cache::remember('vehicules', 360, function () {
        return QueryBuilder::for(Vehicule::class)
            ->allowedFilters(['marque', 'modele', 'statut', 'type_moteur'])
            ->paginate(10);
    });
      

        return response()->json(VehiculeResource::collection($vehicles) ,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        $attributes = $request->validated();

        $vehicule = Vehicule::create($attributes);

        return response()->json(VehiculeResource::make($vehicule), 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
     $vehicule = $this->findVehiculeOrFail($id);

    return response()->json(VehiculeResource::make($vehicule), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {


        $vehicule = $this->findVehiculeOrFail($id);

        $attributes = $request->validated();

        $vehicule->update($attributes);

        return response()->json(VehiculeResource::make($vehicule), 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    
    {
      if (!Str::isUuid($id)) {
        throw new VehiculeNotFoundException();
    }
        
       $vehicule = Vehicule::find($id);

        if(!$vehicule) {
         throw new VehiculeNotFoundException();
       }

         $vehicule->delete();

         return response()->json(['message' => 'Vehicle deleted successfully'], 200);
    }

    private function findVehiculeOrFail(string $id): Vehicule
{
    if (!Str::isUuid($id)) {
        throw new VehiculeNotFoundException();
    }

    $vehicule = Vehicule::find($id);
    if (!$vehicule) {
        throw new VehiculeNotFoundException();
    }

    return $vehicule;
}
}

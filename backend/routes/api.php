<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\VehiculeController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//vehicles
Route::prefix('v1')->group(function(){
   Route::get('/vehicles',[VehiculeController::class, 'index']);
   Route::get('/vehicles/{id}', [VehiculeController::class, 'show']);
   Route::post('/vehicles', [VehiculeController::class, 'store']);
   Route::put('/vehicles/{id}', [VehiculeController::class, 'update']);
   Route::delete('/vehicles/{id}', [VehiculeController::class, 'destroy']);
});

//analytics

<?php

namespace App\Exceptions;

use Exception;

class VehiculeNotFoundException extends Exception
{
  
    public function render($request)
    {
        return response()->json([
            'error' => [
                'type' => 'VehiculeNotFoundException',
                'status' => 404,
                'message' => 'Vehicule not found.',
            ]
        ], 404);
    }
}

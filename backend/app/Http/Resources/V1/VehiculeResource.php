<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiculeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      return [
            'marque' => $this->marque,
            'modele' => $this->modele,
            'statut' => $this->statut,
            'type_moteur' => $this->type_moteur,
            'created_at' => new DateResource($this->created_at),
            'updated_at' => new DateResource($this->updated_at),
        ];
    }
}

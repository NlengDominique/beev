<?php

namespace App\Http\Requests\Vehicule\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
     return [
            'marque' => 'sometimes|string|max:255',
            'modele' => 'sometimes|string|max:255',
            'capacite_batterie' => 'sometimes|integer|min:0',
            'niveau_charge' => 'sometimes|integer|min:0|max:100',
            'statut' => 'sometimes|in:available,charging,in_use',
            'conso_energetique' => 'sometimes|numeric|min:0',
            'type_moteur' => 'sometimes|in:BEV,ICE',
            'emission_co' => 'sometimes|numeric|min:0',
        ];
    }
}

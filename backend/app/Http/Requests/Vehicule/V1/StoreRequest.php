<?php

namespace App\Http\Requests\Vehicule\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function messages(): array
    {
        return [
            'marque.required' => 'La marque est obligatoire',
            'modele.required' => 'Le modèle est obligatoire',
            'capacite_batterie.required' => 'La capacité batterie est obligatoire',
            'niveau_charge.required' => 'Le niveau de charge est obligatoire',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'capacite_batterie' => 'required|integer|min:0',
            'niveau_charge' => 'required|integer|min:0|max:100',
            'statut' => 'required|in:available,charging,in_use',
            'conso_energetique' => 'required|numeric|min:0',
            'type_moteur' => 'required|in:BEV,ICE',
            'emission_co' => 'required|numeric|min:0',
        ];
        
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Str;

class VehiculeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('seeders/cars.csv'); 

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows); 

        foreach ($rows as $row) {
            $data = array_combine($header, $row);

             DB::table('vehicules')->insert([
                'id' => $data['ID'] ?: Str::uuid(),
                'marque' => $data['Brand'],
                'modele' => $data['Model'],
                'capacite_batterie' => (int)$data['Battery capacity (kWh)'],
                'niveau_charge' => (int)$data['Current charge level (%)'],
                'statut' => $data['Status'],
                'conso_energetique' => (float)$data['Average energy consumption (kWh/100km or L/100km)'],
                'type_moteur' => $data['Type'],
                'emission_co' => (float)$data['Emission_gco2_km'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}

}

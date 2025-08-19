<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Vehicule extends Model
{
    /** @use HasFactory<\Database\Factories\VehiculeFactory> */
    use HasFactory,HasUuids;

    protected $guarded = [];


    protected static function booted()
    {
        static::created(function ($vehicule) {
            self::invalidateCache();
        });

        static::updated(function ($vehicule) {
            self::invalidateCache();
        });

        static::deleted(function ($vehicule) {
            self::invalidateCache();
        });
    }

    protected static function invalidateCache()
    {
        Cache::forget('vehicules');             // liste paginée
        Cache::forget('fleet_operational');     // stats par statut
        Cache::forget('vehicules_type_moteur'); // stats par type moteur
        Cache::forget('taux_disponibilite');    // taux de disponibilité si utilisé
    }

}

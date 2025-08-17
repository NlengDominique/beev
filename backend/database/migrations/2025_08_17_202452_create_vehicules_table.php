<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicules', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('marque');
            $table->string('modele');
            $table->integer('capacite_batterie');
            $table->integer('niveau_charge');
            $table->enum('statut',['available','charging','in_use'])
            ->default('available');
            $table->double('conso_energetique');
            $table->enum('type_moteur',['BEV','ICE'])->default('BEV');
            $table->double('emission_co');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};

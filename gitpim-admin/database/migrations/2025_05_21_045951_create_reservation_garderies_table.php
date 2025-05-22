<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('reservation_garderies', function (Blueprint $table) {
        $table->id();
        $table->string('code_reservation')->unique(); // ex : GA25050001
        $table->string('nom_enfant');
        $table->integer('age');
        $table->dateTime('heure_arrivee');
        $table->dateTime('heure_depart');
        $table->string('raison_presence');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_garderies');
    }
};

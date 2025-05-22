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
    Schema::create('reservation_bagnes', function (Blueprint $table) {
        $table->id();
        $table->string('code_reservation')->unique(); // ex : BA25050001
        $table->string('nom_client');
        $table->string('email_client');
        $table->date('date'); // jour de la visite
        $table->enum('horaire', ['matin', 'apres-midi']); // uniquement 10h ou 14h
        $table->integer('nb_personnes'); // max 10
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_bagnes');
    }
};

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
    Schema::create('reservation_kayaks', function (Blueprint $table) {
        $table->id();
        $table->string('code_reservation')->unique(); // Ex: KA25050001
        $table->string('nom_client');
        $table->string('email_client');
        $table->date('date');
        $table->time('heure_debut');
        $table->time('heure_fin');
        $table->enum('type_kayak', ['simple', 'double']);
        $table->integer('nb_personnes');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_kayaks');
    }
};

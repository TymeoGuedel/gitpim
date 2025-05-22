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
    Schema::create('reservation_randonnees', function (Blueprint $table) {
        $table->id();
        $table->string('code_reservation')->unique();
        $table->string('nom_client');
        $table->string('email_client');
        $table->date('date');
        $table->integer('nb_personnes');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_randonnees');
    }
};

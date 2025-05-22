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
    Schema::create('reservation_repas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('reservation_chambre_id');
        $table->date('date');
        $table->time('horaire');
        $table->integer('nb_couverts');
        $table->timestamps();

        $table->foreign('reservation_chambre_id')->references('id')->on('reservation_chambres')->onDelete('cascade');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_repas');
    }
};

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
    Schema::table('reservation_chambres', function (Blueprint $table) {
        $table->unsignedTinyInteger('nb_bungalows_mer')->default(0);
        $table->unsignedTinyInteger('nb_bungalows_jardin')->default(0);
    });
}

public function down()
{
    Schema::table('reservation_chambres', function (Blueprint $table) {
        $table->dropColumn(['nb_bungalows_mer', 'nb_bungalows_jardin']);
    });
}

};

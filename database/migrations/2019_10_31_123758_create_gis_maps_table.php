<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGisMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gis_maps', function (Blueprint $table) {
                $table->increments('id');
                $table->string('Lintang', 60);
                $table->string('Bujur', 60);
                $table->string('Kedalaman', 60);
                $table->string('Magnitude', 60);
                $table->string('Audio_Link', 60);
                $table->string('Video_Link', 60);
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gis_maps');
    }
    



}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWindyPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('windy_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('model')->nullable()->default('gfs');
            $table->timestamp('time')->nullable();
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
        Schema::dropIfExists('windy_points');
    }
}

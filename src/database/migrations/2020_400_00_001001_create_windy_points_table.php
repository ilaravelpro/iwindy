<?php
/**
 * Author: Amir Hossein Jahani | iAmir.net
 * Last modified: 7/23/20, 8:07 AM
 * Copyright (c) 2021. Powered by iamir.net
 */

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
            $table->timestamp('valid_at')->nullable();
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

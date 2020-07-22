<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWindyPointsMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('windy_points_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('point_id')->unsigned()->nullable();
            $table->foreign('point_id')->references('id')->on('windy_points')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->string('unit')->nullable();
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
        Schema::dropIfExists('windy_points_meta');
    }
}

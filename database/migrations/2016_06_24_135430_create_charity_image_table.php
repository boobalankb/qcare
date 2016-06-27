<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharityImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charity_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('charity_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('charity_image', function (Blueprint $table) {
            $table->foreign('charity_id')->references('id')->on('charities');
        });

        Schema::table('charity_image', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('charity_image');
    }
}

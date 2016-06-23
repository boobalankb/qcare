<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('charity_category_id');
            $table->string('support');
            $table->string('name');
            $table->text('description');
            $table->text('address');
            $table->string('zipcode');
            $table->string('state');
            $table->string('country');
            $table->string('email');
            $table->integer('phone');
            $table->string('contactperson');
            $table->string('certification_details');
            $table->string('authentication_details');
            $table->string('latitude');
            $table->string('longtitude');
            $table->tinyInteger('status');
            $table->timestamps();

            // associations
            //$table->foreign('charity_category_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('charity');
    }
}

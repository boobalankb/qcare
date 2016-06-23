<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('charity_category_id')->unsigned();
            $table->text('description');
            $table->text('address');
            $table->string('email');
            $table->string('phone');
            $table->string('latitude');
            $table->string('longtitude');
            $table->tinyInteger('status');
            $table->timestamps();

            // associations
            //$table->foreign('charity_category_id')->references('id')->on('users');
        });

        Schema::table('charities', function (Blueprint $table) {
            $table->foreign('charity_category_id')->references('id')->on('charity_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('charities');
    }
}

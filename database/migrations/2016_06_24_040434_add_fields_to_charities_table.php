<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCharitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charities', function (Blueprint $table) {
            $table->string('state', 100)->after('address');
            $table->string('country', 100)->after('state');
            $table->string('zip', 15)->after('country');
            $table->string('contact_person', 100)->after('longtitude');
            $table->string('size', 100)->after('contact_person');
            $table->text('certification')->after('size');
            $table->text('authentication')->after('certification');
            $table->text('performance')->after('authentication');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charities', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('zip');
            $table->dropColumn('contact_person');
            $table->dropColumn('size');
            $table->dropColumn('certification');
            $table->dropColumn('authentication');
            $table->dropColumn('performance');
        });
    }
}

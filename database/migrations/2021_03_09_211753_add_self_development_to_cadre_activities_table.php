<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSelfDevelopmentToCadreActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cadre_activities', function (Blueprint $table) {
            $table->enum('self_development', ['Ekstakurikuler', 'Pembiasaan Diri']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cadre_activities', function (Blueprint $table) {
            //
        });
    }
}

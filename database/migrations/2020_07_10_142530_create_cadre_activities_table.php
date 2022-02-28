<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadreActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadre_activities', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('work_program_id')->constrained();
            $table->integer('condition');
            $table->integer('percentage');
            $table->longText('results');
            $table->longText('problem');
            $table->longText('behavioral');
            $table->longText('physical');
            $table->longText('plan');
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
        Schema::dropIfExists('cadre_activities');
    }
}

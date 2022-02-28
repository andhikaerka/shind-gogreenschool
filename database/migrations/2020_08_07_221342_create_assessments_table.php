<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_profile_id')->constrained()->onDelete('cascade');
            $table->integer('component_1');
            $table->integer('component_2');
            $table->integer('component_3');
            $table->integer('component_4');
            $table->integer('component_5');
            $table->integer('component_6');
            $table->integer('component_7');
            $table->integer('component_8');
            $table->integer('component_9');
            $table->integer('component_10');
            $table->integer('component_11');
            $table->integer('component_12');
            $table->integer('component_13');
            $table->integer('component_14');
            $table->integer('component_15');
            $table->integer('component_16');
            $table->integer('component_17');
            $table->integer('component_18');
            $table->integer('component_19');
            $table->integer('component_20');
            $table->integer('component_21');
            $table->integer('component_22');
            $table->integer('component_23');
            $table->integer('component_24');
            $table->integer('component_25');
            $table->integer('component_26');
            $table->integer('component_27');
            $table->integer('component_28');
            $table->integer('component_29');
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
        Schema::dropIfExists('assessments');
    }
}

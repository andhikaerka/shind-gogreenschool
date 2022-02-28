<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_profile_id')->constrained();
            $table->string('subject')->nullable();
            $table->string('teacher')->nullable();
            $table->string('class')->nullable();
            $table->string('period')->nullable();
            $table->foreignId('aspect_id')->constrained();
            $table->string('hook')->nullable();
            $table->longText('artwork')->nullable();
            $table->integer('hour')->nullable();
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
        Schema::dropIfExists('lesson_plans');
    }
}

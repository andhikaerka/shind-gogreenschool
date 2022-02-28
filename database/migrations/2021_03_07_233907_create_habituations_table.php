<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabituationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habituations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_profile_id')->constrained();
            $table->string('program');
            $table->enum('category', ['Rutin', 'Spontan', 'Keteladanan']);
            $table->string('tutor');
            $table->string('time');
            $table->string('activity');
            $table->string('target');
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
        Schema::dropIfExists('habituations');
    }
}

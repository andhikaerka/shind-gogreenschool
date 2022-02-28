<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivityImplementationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_implementations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('work_group_id')->constrained();
            $table->foreignId('activity_id')->constrained();
            $table->longText('progress');
            $table->longText('constraints');
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
        Schema::dropIfExists('activity_implementations');
    }
}

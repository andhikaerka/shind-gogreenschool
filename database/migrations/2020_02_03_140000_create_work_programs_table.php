<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('study_id')->constrained();
            $table->longText('condition');
            $table->longText('plan');
            // $table->longText('activity')->nullable();
            $table->string('percentage');
            $table->string('time');
            $table->string('tutor_1');
            $table->string('tutor_2')->nullable();
            $table->string('tutor_3')->nullable();
            $table->boolean('featured')->default(0);
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
        Schema::dropIfExists('work_programs');
    }
}

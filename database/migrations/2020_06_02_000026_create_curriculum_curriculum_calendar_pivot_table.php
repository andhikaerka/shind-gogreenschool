<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurriculumCurriculumCalendarPivotTable extends Migration
{
    public function up()
    {
        Schema::create('curriculum_curriculum_calendar', function (Blueprint $table) {
            $table->foreignId('curriculum_id')->constrained()->onDelete('cascade');
            $table->foreignId('curriculum_calendar_id')->constrained()->onDelete('cascade');
        });

    }
}

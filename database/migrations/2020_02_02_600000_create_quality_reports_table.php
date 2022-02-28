<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_profile_id')->constrained();
            $table->boolean('has_document')->default(0);
            $table->longText('waste_management');
            $table->longText('energy_conservation');
            $table->longText('life_preservation');
            $table->longText('water_conservation');
            $table->longText('canteen_management');
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
        Schema::dropIfExists('quality_reports');
    }
}

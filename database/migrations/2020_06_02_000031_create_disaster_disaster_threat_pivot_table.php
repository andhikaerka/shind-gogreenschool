<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisasterDisasterThreatPivotTable extends Migration
{
    public function up()
    {
        Schema::create('disaster_disaster_threat', function (Blueprint $table) {
            $table->foreignId('disaster_id')->constrained()->onDelete('cascade');
            $table->foreignId('disaster_threat_id')->constrained()->onDelete('cascade');
        });

    }
}

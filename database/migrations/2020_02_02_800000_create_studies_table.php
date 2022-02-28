<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quality_report_id')->constrained();
            $table->foreignId('work_group_id')->constrained();
            $table->foreignId('snp_category_id')->constrained();
            $table->longText('potential');
            $table->longText('problem');
            $table->longText('activity')->nullable();
            $table->longText('behavioral');
            $table->longText('physical');
            $table->longText('kbm');
            $table->longText('artwork');
            $table->integer('period');
            $table->string('source');
            $table->integer('cost')->nullable();
            $table->integer('percentage');
            $table->foreignId('partner_id')->constrained();
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
        Schema::dropIfExists('studies');
    }
}

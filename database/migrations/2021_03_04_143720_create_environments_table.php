<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('environments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_profile_id')->constrained();
            $table->string('isi');
            $table->string('proses');
            $table->string('kompetensi_kelulusan');
            $table->string('pendidik_dan_tenaga_kependidikan');
            $table->string('sarana_prasarana');
            $table->string('pengelolaan');
            $table->string('pembiayaan');
            $table->string('penilaian_pendidikan');
            $table->string('file');
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
        Schema::dropIfExists('environments');
    }
}

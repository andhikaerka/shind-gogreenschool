<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_profile_id')->constrained();
            $table->string('name');
            $table->string('cp_name');
            $table->string('cp_phone');
            $table->foreignId('partner_category_id')->constrained();
            $table->foreignId('partner_activity_id')->constrained();
            $table->date('date');
            $table->longText('purpose');
            $table->integer('total_people');
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
        Schema::dropIfExists('partners');
    }
}

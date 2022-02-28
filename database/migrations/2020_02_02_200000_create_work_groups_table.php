<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_profile_id')->constrained();
            // $table->foreignId('user_id')->constrained();
            $table->foreignId('work_group_name_id')->constrained();
            $table->string('alias')->nullable();
            $table->text('description');
            $table->foreignId('aspect_id')->constrained();
            $table->string('tutor');
            $table->text('task');
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
        Schema::dropIfExists('work_groups');
    }
}

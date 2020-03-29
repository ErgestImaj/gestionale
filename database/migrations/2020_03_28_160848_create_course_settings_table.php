<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_nr')->nullable();
            $table->integer('course_id');
			  		$table->boolean('pause')->default(0);
			  		$table->integer('pause_time')->nullable();
			  		$table->integer('total_hours')->nullable();
			  		$table->integer('created_by');
			  		$table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('course_settings');
    }
}

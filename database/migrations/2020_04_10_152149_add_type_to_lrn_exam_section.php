<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToLrnExamSection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utilities_lrn_exam_sessions', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0)->after('course_id');
        });
    }


}

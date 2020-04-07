<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvestigatorIdToLrnExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utilities_lrn_exam_sessions', function (Blueprint $table) {
            $table->integer('investigator_id')->nullable();
            $table->string('start_hour')->nullable()->change();
            $table->string('start_minute')->nullable()->change();
            $table->string('end_hour')->nullable()->change();
            $table->string('end_minute')->nullable()->change();
        });
    }


}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToLmsExams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utilities_lrn_exam_sessions', function (Blueprint $table) {
						$table->dropColumn('locked');
						$table->dropColumn('locked_by');
						$table->unsignedBigInteger('updated_by')->nullable()->change();
				  	$table->dateTime('date')->nullable()->change();
				  	$table->dateTime('end_date')->nullable()->change();
				  	$table->dateTime('date_of_issue')->nullable()->change();
            $table->softDeletes();
        });

    }


}

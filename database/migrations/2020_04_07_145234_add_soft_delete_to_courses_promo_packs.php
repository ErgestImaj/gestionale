<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToCoursesPromoPacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses_promo_packs', function (Blueprint $table) {
					$table->dropColumn('locked');
					$table->dropColumn('locked_by');
					$table->unsignedBigInteger('updated_by')->nullable()->change();
			    $table->softDeletes();
        });
    }


}

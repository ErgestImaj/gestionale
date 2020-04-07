<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses_promo_pack_courses', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('code');
            $table->dropColumn('type');
            $table->dropColumn('description');
            $table->dropColumn('skills');
            $table->dropColumn('duration');
            $table->dropColumn('program_description');
            $table->dropColumn('expiry');
        });
    }


}

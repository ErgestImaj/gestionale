<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStructuresStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('structures_structure_statuses', function (Blueprint $table) {
	        $table->integer('status')->nullable()->change();
	        $table->integer('status_lrn')->nullable()->change();
	        $table->dateTime('date')->nullable()->change();
	        $table->dateTime('date_lrn')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('structures_structure_statuses', function (Blueprint $table) {
            //
        });
    }
}

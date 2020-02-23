<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStructureStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('structures_structure_statuses', function (Blueprint $table) {
	        $table->bigInteger('locked_by')->nullable()->change();
	        $table->dateTime('locked')->nullable()->change();
	        $table->dateTime('updated')->nullable()->change();
	        $table->bigInteger('updated_by')->nullable()->change();
	        $table->dateTime('created')->nullable()->change();
	        $table->bigInteger('created_by')->nullable()->change();
	        $table->tinyInteger('status_dile')->nullable();
	        $table->dateTime('date_dile')->nullable();
	        $table->tinyInteger('status_iiq')->nullable();
	        $table->dateTime('date_iiq')->nullable();
	        $table->tinyInteger('status_miur')->nullable();
	        $table->dateTime('date_miur')->nullable();
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

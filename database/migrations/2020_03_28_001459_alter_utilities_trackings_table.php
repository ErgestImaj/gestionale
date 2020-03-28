<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUtilitiesTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utilities_trackings', function (Blueprint $table) {
						$table->dropColumn('locked');
						$table->dropColumn('locked_by');
						$table->unsignedBigInteger('updated_by')->nullable()->change();
						$table->integer('nr_certificates');
						$table->date('send_date');
						$table->date('expiry_date');
        });
    }



}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUtilitiesCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utilities_certificates', function (Blueprint $table) {
						$table->dropColumn('locked');
						$table->dropColumn('locked_by');
						$table->unsignedBigInteger('updated_by')->nullable()->change();
						$table->integer('exam_session_id')->nullable()->change();
        });
    }




}

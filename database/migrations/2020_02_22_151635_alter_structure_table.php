<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStructureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('structures_structures', function (Blueprint $table) {
	        $table->bigInteger('locked_by')->nullable()->change();
	        $table->dateTime('locked')->nullable()->change();
	        $table->dateTime('updated')->nullable()->change();
	        $table->bigInteger('updated_by')->nullable()->change();
	        $table->bigInteger('same_legal_and_operational')->nullable()->change();
	        $table->bigInteger('courses_preference')->nullable()->change();
	        $table->bigInteger('operational_country')->nullable()->change();
	        $table->bigInteger('operational_region')->nullable()->change();
	        $table->bigInteger('operational_prov')->nullable()->change();
	        $table->bigInteger('operational_town')->nullable()->change();
	        $table->string('operational_address')->nullable()->change();
	        $table->string('operational_zipcode')->nullable()->change();
	        $table->bigInteger('legal_user_id')->nullable()->change();
	        $table->string('fax')->nullable()->change();
	        $table->string('website')->nullable()->change();
	        $table->string('pec')->nullable()->change();
	        $table->string('file')->nullable()->change();
	        $table->string('image')->nullable()->change();
	        $table->string('codice_destinatario')->nullable();
	        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('structures_structures', function (Blueprint $table) {
            //
        });
    }
}

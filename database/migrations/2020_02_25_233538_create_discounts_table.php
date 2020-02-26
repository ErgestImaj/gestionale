<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('structure_id');
            $table->integer('corsi');
            $table->decimal('sconto',10,2);
	          $table->unsignedInteger('created_by');
	          $table->unsignedInteger('updated_by')->nullable();
		        $table->foreign('created_by')->references('id')->on('users');
		        $table->foreign('updated_by')->references('id')->on('users');
		        $table->foreign('structure_id')->references('id')->on('structures_structures');
            $table->timestamps();
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
        Schema::dropIfExists('discounts');
    }
}

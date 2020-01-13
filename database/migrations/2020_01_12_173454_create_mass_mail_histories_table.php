<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMassMailHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mass_mail_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string( 'subject' );
            $table->text( 'description' );
            $table->string( 'send_to' );
            $table->string( 'created_by' );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mass_mail_histories');
    }
}

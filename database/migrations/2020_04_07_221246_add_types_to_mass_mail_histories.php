<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypesToMassMailHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mass_mail_histories', function (Blueprint $table) {
					$table->string('types')->after('send_to')->nullable();
					$table->text('send_to')->change();
        });
    }

}

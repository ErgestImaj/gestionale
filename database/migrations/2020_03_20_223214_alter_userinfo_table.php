<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_userinfo', function (Blueprint $table) {
					$table->bigInteger('locked_by')->nullable()->change();
					$table->dateTime('locked')->nullable()->change();
					$table->dateTime('updated')->nullable()->change();
					$table->dateTime('document_expire_date')->nullable()->change();
					$table->dateTime('birth_date')->nullable()->change();
					$table->bigInteger('updated_by')->nullable()->change();
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
        Schema::table('users_userinfo', function (Blueprint $table) {
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersChangeColumnsDefaultVal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dateTime('last_login')->nullable()->change();
            $table->dateTime('locked')->nullable()->change();
            $table->dateTime('activation')->nullable()->change();
            $table->dateTime('created')->nullable()->change();
            $table->dateTime('updated')->nullable()->change();
        });
    }


}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypesToWorkshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->string('types')->after('partecipants')->nullable();
            $table->text('partecipants')->change();
        });
    }


}

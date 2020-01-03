<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersMakeNullableUpdatedBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable()->change();
            $table->unsignedBigInteger('locked_by')->nullable()->change();
            $table->dropColumn('params');
            $table->dropColumn('old_coop_id');
            $table->dropColumn('website_id');
            $table->dropColumn('slug');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}

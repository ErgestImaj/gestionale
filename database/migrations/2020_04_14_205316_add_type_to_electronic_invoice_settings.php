<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToElectronicInvoiceSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electronic_invoice_settings', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0)->after('user_id');
        });
    }

}

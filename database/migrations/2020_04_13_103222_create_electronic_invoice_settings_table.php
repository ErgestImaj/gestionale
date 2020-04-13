<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectronicInvoiceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('electronic_invoice_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('dati_trasmissione_id_paese');
            $table->string('dati_trasmissione_id_codice');
            $table->string('dati_anagrafici_id_paese');
            $table->string('dati_anagrafici_id_codice');
            $table->string('codice_fiscale');
            $table->string('denominazione');
            $table->string('regime_fiscale');
            $table->string('indirizzo');
            $table->string('numero_civico');
            $table->string('cap');
            $table->string('comune');
            $table->string('provincia');
            $table->string('nazione');
            $table->string('numero_rea');
            $table->string('capitale_sociale');
            $table->string('socio_unico');
            $table->string('stato_liquidazione');
            $table->string('telefono');
            $table->string('email');
            $table->string('istituto_finanziario');
            $table->string('iban');
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
        Schema::dropIfExists('electronic_invoice_settings');
    }
}

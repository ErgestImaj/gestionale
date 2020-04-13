<?php

use Illuminate\Database\Seeder;

class AdminElectronicInvoiceSettings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       \App\Models\ElectronicInvoiceSettings::create([
        	'user_id'=>38,
        	'dati_trasmissione_id_paese'=>"IT",
        	'dati_trasmissione_id_codice'=>"10209790152",
        	'dati_anagrafici_id_paese'=>"IT",
        	'dati_anagrafici_id_codice'=>"07240111216",
        	'codice_fiscale'=>"07240111216",
        	'denominazione'=>"MEDIAFORM EDUCATIONAL QUALIFICATIONS AND INTERNATIONAL",
        	'regime_fiscale'=>"RF01",
        	'indirizzo'=>"CORSO ITALIA",
        	'numero_civico'=>"125/127",
        	'cap'=>"80011",
        	'comune'=>"Acerra",
        	'provincia'=>"NA",
        	'nazione'=>"IT",
        	'numero_rea'=>"0870875",
        	'capitale_sociale'=>"1250.00",
        	'socio_unico'=>"SM",
        	'stato_liquidazione'=>"LN",
        	'telefono'=>"0813198141",
        	'email'=>"amministrazione@mediaform.it",
        	'istituto_finanziario'=>"Poste Italiane Spa",
        	'iban'=>"IT15G0760103400001024439968",
				]);
    }
}

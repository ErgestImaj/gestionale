<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ElectronicInvoiceSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
					'dati_trasmissione_id_paese'=>'required|string',
					'dati_trasmissione_id_codice'=>'required|string',
					'dati_anagrafici_id_paese'=>'required|string',
					'dati_anagrafici_id_codice'=>'required|string',
					'codice_fiscale'=>'required|string',
					'denominazione'=>'required|string',
					'regime_fiscale'=>'required|string',
					'indirizzo'=>'required|string',
					'numero_civico'=>'required|string',
					'cap'=>'required|string',
					'comune'=>'required|string',
					'provincia'=>'required|string',
					'nazione'=>'required|string',
					'numero_rea'=>'required|string',
					'capitale_sociale'=>'required|string',
					'socio_unico'=>'required|string',
					'stato_liquidazione'=>'required|string',
					'telefono'=>'required|string',
					'email'=>'required|string|email',
					'istituto_finanziario'=>'required|string',
					'iban'=>'required|string',
        ];
    }
    public function fillFormFields(){
    	return [
				'user_id'=>auth()->id(),
				'dati_trasmissione_id_paese'=>$this->input('dati_trasmissione_id_paese'),
				'dati_trasmissione_id_codice'=>$this->input('dati_trasmissione_id_codice'),
				'dati_anagrafici_id_paese'=>$this->input('dati_anagrafici_id_paese'),
				'dati_anagrafici_id_codice'=>$this->input('dati_anagrafici_id_codice'),
				'codice_fiscale'=> $this->input('codice_fiscale'),
				'denominazione'=>$this->input('denominazione'),
				'regime_fiscale'=>$this->input('regime_fiscale'),
				'indirizzo'=>$this->input('indirizzo'),
				'numero_civico'=>$this->input('numero_civico'),
				'cap'=>$this->input('cap') ,
				'comune'=>$this->input('comune'),
				'provincia'=>$this->input('provincia'),
				'nazione'=>$this->input('nazione'),
				'numero_rea'=>$this->input('numero_rea'),
				'capitale_sociale'=>$this->input('capitale_sociale'),
				'socio_unico'=>$this->input('socio_unico'),
				'stato_liquidazione'=>$this->input('stato_liquidazione'),
				'telefono'=>$this->input('telefono'),
				'email'=>$this->input('email'),
				'istituto_finanziario'=>$this->input('istituto_finanziario'),
				'iban'=>$this->input('iban'),
			];
		}
}

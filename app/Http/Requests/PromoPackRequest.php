<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoPackRequest extends FormRequest
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
			'name' => 'required|string',
			'description' => 'required|string',
			'price' => 'required|numeric',
			'type' => 'required|numeric',
			'expiry_date' => 'required|date',
			'corsi' => 'required|array',
			'corsi.*.quantity' => 'required|numeric|min:1',
		];
	}

	public function attributes()
	{
		return [
			'name' => 'nome',
			'type' => 'tipo',
			'description' => 'descrizione',
			'price' => 'prezzo',
			'expiry_date' => 'data scadenza',
			'corsi.*.quantity' => 'quantita'
		];
	}
	public function fillFormFields(){
		return [
			'name'=>$this->input('name'),
			'type'=>$this->input('type'),
			'description'=>$this->input('description'),
			'price'=>$this->input('price'),
			'expiry_date'=>$this->input('expiry_date'),
			'expiry_date'=>$this->input('expiry_date'),
			'state'=>$this->input('status')??0,
			'created_by'=>auth()->id(),
		];
	}

}

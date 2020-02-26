<?php

namespace App\Http\Requests;

use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            '*.corsi'=>'required|numeric',
            '*.sconto'=>'required|numeric',
        ];
    }
	public function attributes()
	{
		return [
			'*.corsi'=> 'corsi',
			'*.sconto'=> 'sconto'
		];
	}
	public function fillFormFields(){
    	foreach ($this->all() as $key=>$val){
		    $data[] = new Discount(array_prepend($val,auth()->id(),'created_by'));
	    }
    	return $data ;

	}
}

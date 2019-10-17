<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vat_name'=>'required|string',
            'vat_value'=>'required|numeric',
        ];
    }
    public function attributes(){
        return [
            'vat_name'=>trans('form.name'),
            'vat_value'=>trans('form.value'),
        ];
    }
}

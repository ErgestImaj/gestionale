<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IBANRequest extends FormRequest
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
            'cart_iban'=>'required|string',
            'cart_cc_postale'=>'required|string',
            'cart_intestazione'=>'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'cart_iban'=>trans('form.cart_iban'),
            'cart_cc_postale'=>strtolower(trans('form.cart_cc_postale')),
            'cart_intestazione'=>strtolower(trans('form.cart_intestazione')),
        ];
    }
}

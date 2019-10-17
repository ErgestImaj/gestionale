<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayPalRequest extends FormRequest
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
            'api_username'=>'required|string',
            'api_signature'=>'required|string',
            'api_password'=>'required|string',
            'api_currency'=>'required|string|max:3',
        ];
    }
    public function attributes()
    {
        return [
            'api_username'=>trans('form.username'),
            'api_signature'=>trans('form.api_signature'),
            'api_password'=>trans('form.api_password'),
            'api_currency'=>trans('form.api_currency'),
        ];
    }
}

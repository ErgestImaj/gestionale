<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailToSingleUserRequest extends FormRequest
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
            'cc_email'     =>  'nullable|sometimes|email',
            'bcc_email'    =>  'nullable|sometimes|email',
            'soggetto'     =>  'required|string',
            'descrizione'  =>  'required|string'
        ];
    }

    /**
     * Get the validation messages
     * @return array
     */
    public function messages()
    {
        return [
            'cc_email.email'              =>  'L\'cc-mail non è valida',
            'bcc_email.email'             =>  'L\'bcc-mail non è valida',
            'soggetto.required'           =>  'Il campo soggetto e richiesto',
            'descrizione.required'        =>  'Il campo descrizione e richiesto'
        ];
    }
}

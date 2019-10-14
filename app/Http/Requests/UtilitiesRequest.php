<?php

namespace App\Http\Requests;

use App\Rules\EmailsArrayRule;
use Illuminate\Foundation\Http\FormRequest;

class UtilitiesRequest extends FormRequest
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
            'lrn_email'     => ['required', new EmailsArrayRule()],
            'lrn_email_cc'  => ['required', new EmailsArrayRule()],
            'support_email' => ['required', new EmailsArrayRule()],
        ];
    }
}

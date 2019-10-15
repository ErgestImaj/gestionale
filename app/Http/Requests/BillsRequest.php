<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillsRequest extends FormRequest
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
            'invoice_mediaform_piva'=>'required|string',
            'invoice_mediaform_cf'=>'required|string',
            'invoice_mediaform_tel'=>'required|string',
            'invoice_mediaform_fax'=>'nullable|string',
            'invoice_mediaform_address'=>'nullable|string',
        ];
    }
    public function attributes()
    {
        return [
            'invoice_mediaform_piva'=>trans('form.invoice_mediaform_piva'),
            'invoice_mediaform_cf'=>trans('form.invoice_mediaform_cf'),
            'invoice_mediaform_tel'=>trans('form.invoice_mediaform_tel'),
            'invoice_mediaform_fax'=>trans('form.invoice_mediaform_fax'),
            'invoice_mediaform_address'=>trans('form.invoice_mediaform_address'),
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
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
            'mediaform_structure_accreditation_price'=>'required|string',
            'mediaform_former_accreditation_price'=>'required|string',
            'mediaform_supervisor_accreditation_price'=>'required|string',
            'mediaform_examiner_accreditation_price'=>'required|string',
            'lrn_structure_accreditation_price'=>'required|string',
            'lrn_examiner_accreditation_price'=>'required|string',
            'lrn_invigilator_accreditation_price'=>'required|string',
            'price_certificate_duplicate'=>'required|string',
            'fast_track_price'=>'required|string',
            'price_for_extra_shipment'=>'required|string',
        ];
    }
    public function attributes()
    {
        return [
            'mediaform_structure_accreditation_price'=>trans('form.mediaform_structure_accreditation_price'),           'api_signature'=>trans('form.api_signature'),
            'mediaform_former_accreditation_price'=>trans('form.mediaform_former_accreditation_price'),
            'mediaform_supervisor_accreditation_price'=>trans('form.mediaform_supervisor_accreditation_price'),
            'mediaform_examiner_accreditation_price'=>trans('form.mediaform_examiner_accreditation_price'),
            'lrn_structure_accreditation_price'=>trans('form.lrn_structure_accreditation_price'),
            'lrn_examiner_accreditation_price'=>trans('form.lrn_examiner_accreditation_price'),
            'lrn_invigilator_accreditation_price'=>trans('form.lrn_invigilator_accreditation_price'),
            'price_certificate_duplicate'=>trans('form.price_certificate_duplicate'),
            'fast_track_price'=>trans('form.fast_track_price'),
            'price_for_extra_shipment'=>trans('form.price_for_extra_shipment'),
        ];
    }
}

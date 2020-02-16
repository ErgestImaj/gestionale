<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StructureRequest extends FormRequest
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
     * Prepare data for validation
     */
    public function prepareForValidation() {
        $this->merge(
            json_decode($this->get('structure'),true)
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
           'nome'=>'required|string|min:2|max:191',
           'legal_name'=>'required|string|min:2|max:191',
           'piva'=>'required|string|max:191',
           'tax_code'=>'required|string|min:2|max:191',
           'codice_destinatario'=>'sometimes|string|min:7|max:7',
           'legal_zipcode'=>'required|string',
           'legal_address'=>'required|string',
           'legal_region'=>'required|numeric|exists:location_regions,id',
           'legal_town'=>'required|numeric|exists:location_towns,id',
           'legal_country'=>'required|numeric|exists:location_countries,id',
           'legal_prov'=>'required|numeric|exists:location_provs,id',
           'operational_zipcode'=>'sometimes|string',
           'operational_address'=>'sometimes|string',
           'operational_town'=>'sometimes|numeric|exists:location_towns,id',
           'operational_region'=>'sometimes|numeric|exists:location_regions,id',
           'operational_prov'=>'sometimes|numeric|exists:location_provs,id',
           'operational_country'=>'sometimes|numeric|exists:location_countries,id',
           'phone'=>'required|string',
           'fax'=>'sometimes|string',
           'email'=>'required|email|unique:users',
           'pec'=>'sometimes|email',
           'website'=>'sometimes|url',
           'rappresentante_cognome'=>'required|string|min:2|max:191',
           'rappresentante_nome'=>'required|string|min:2|max:191',
           'rappresentante_email'=>'required|email|unique:users',
           'accredit'=>'required|array',
           'doc_file3'=>'nullable|mimes:jpeg,png,jpg',
           'doc_file2'=>'required|mimes:jpeg,png,jpg,pdf',
           'doc_file1'=>'required|mimes:jpeg,png,jpg,pdf',
        ];
    }

    public function attributes() {
        return [
            'nome'=>strtolower(trans('form.nome_strutura')),
            'legal_name'=>strtolower(trans('form.ragione_sociale')),
            'tax_code'=>'codice fiscale',
            'legal_region'=>'regione',
            'operational_region'=>'regione',
            'legal_country'=>strtolower(trans('form.country')),
            'operational_country'=>strtolower(trans('form.country')),
            'legal_town'=>strtolower(trans('form.city')),
            'operational_town'=>strtolower(trans('form.city')),
            'legal_prov'=>strtolower(trans('form.state')),
            'operational_prov'=>strtolower(trans('form.state')),
            'legal_zipcode'=>strtolower(trans('form.cap')),
            'operational_zipcode'=>strtolower(trans('form.cap')),
            'legal_address'=>strtolower(trans('form.address')),
            'operational_address'=>strtolower(trans('form.address')),
            'phone'=>strtolower(trans('form.phone')),
            'website'=>strtolower(trans('form.site')),
            'doc_file1'=>'domanda accreditamento',
            'doc_file2'=>'visura camerale',
            'doc_file3'=>'logo struttura',

        ];
    }
}

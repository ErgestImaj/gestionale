<?php

namespace App\Http\Requests;

use App\Models\Tracking;
use Illuminate\Foundation\Http\FormRequest;

class TrackingRequest extends FormRequest
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
            'user_id'=>'required|exists:users,id',
            'lrn_exam_session_id'=>'required|exists:utilities_lrn_exam_sessions,id',
					  'code'=>'required|string',
					  'estimate_date'=>'required|date',
					  'status'=>'nullable|numeric',
					  'nr_certificates'=>'required|numeric',
					  'send_date'=>'required|date',
					  'expiry_date'=>'required|date',
        ];
    }

    public function attributes()
		{
			return [
				'user_id'=>'struttura',
				'lrn_exam_session_id'=>'esame di riferimento',
				'status'=>'stato',
				'code'=>'codice spedizione',
				'estimate_date'=>'data ricezione',
				'nr_certificates'=>'codice spedizione',
				'send_date'=>'data spedizione',
				'expiry_date'=>'data scadenza reclamo',
			];
		}
		public function fillFormFields(){
    	return [
    		'user_id'=>$this->input('user_id'),
    		'lrn_exam_session_id'=>$this->input('lrn_exam_session_id'),
    		'status'=>$this->input('status'),
    		'code'=>$this->input('code'),
    		'estimate_date'=>$this->input('estimate_date'),
    		'nr_certificates'=>$this->input('nr_certificates'),
    		'send_date'=>$this->input('nr_certificates'),
    		'expiry_date'=>$this->input('expiry_date'),
				'updated_by'=>auth()->id(),
				'state'=>Tracking::IS_ACTIVE,
			];
		}
}

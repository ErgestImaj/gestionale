<?php

namespace App\Http\Requests;

use App\Models\Tracking;
use Carbon\Carbon;
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
					  'send_date'=>'required|date',
					  'estimate_date'=>'required|date|after_or_equal:send_date',
					  'expiry_date'=>'required|date',
					  'status'=>'required|numeric',
					  'nr_certificates'=>'required|numeric',
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
    	$expiry_date = Carbon::createFromFormat('d-m-Y', $this->input('expiry_date'))->format('Y-m-d');
    	$status = $expiry_date <= Carbon::now() ? Tracking::STATUS_EXPIERD :  $this->input('status');
    	return [
    		'user_id'=>$this->input('user_id'),
    		'lrn_exam_session_id'=>$this->input('lrn_exam_session_id'),
    		'status'=>	$status ?? Tracking::STATUS_TO_SEND,
    		'code'=>$this->input('code'),
    		'estimate_date'=>$this->input('estimate_date'),
    		'nr_certificates'=>$this->input('nr_certificates'),
    		'send_date'=>$this->input('send_date'),
    		'expiry_date'=>$expiry_date,
				'updated_by'=>auth()->id(),
				'state'=> Tracking::IS_ACTIVE,
			];
		}
}

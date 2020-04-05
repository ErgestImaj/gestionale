<?php

namespace App\Http\Requests;

use App\Models\Cart\CourseTransactions;
use Illuminate\Foundation\Http\FormRequest;

class CourseTransactionRequest extends FormRequest
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
            'course'=>'required|exists:courses_courses,id',
            'qty'=>'required|numeric',
        ];
    }
    public function attributes()
		{
			return [
				'course'=>'corso',
				'qty'=>'numero corsi',
			];
		}
		public function fillFormFileds(){
    	return [
    		'qty'=>$this->input('qty'),
    		'course_id'=>$this->input('course'),
    		'order_id'=>0,
    		'type'=>CourseTransactions::TYPE_ADMIN_ADDED,
    		'paypal_transaction_id'=>0,
    		'parent_transaction_id'=>0,
    		'state'=>1,
				'created_by'=>auth()->id(),
			];
		}
}

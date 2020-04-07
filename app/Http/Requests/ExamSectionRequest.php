<?php

namespace App\Http\Requests;

use App\Models\Exams\LrnExamSession;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ExamSectionRequest extends FormRequest
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
            'course_id'=>'required|exists:courses_courses,id',
            'invigilator_id'=>'required|exists:users,id',
            'examiner_id'=>'required|exists:users,id',
            'investigator_id'=>'sometimes|nullable|exists:users,id',
					  'location_id'=>'required|numeric',
					  'location'=>'required_if:location_id,1|string',
					  'date'=>'required|date',
					  'end_date'=>'required|date|after_or_equal:'.Carbon::today(),
        ];
    }
    public function attributes()
		{
			return [
				'course_id'=>'corso',
				'invigilator_id'=>'invigilator',
				'examiner_id'=>'esaminatore',
				'investigator_id'=>'ispettore',
				'location_id'=>'sede',
				'location'=>'indirizo',
				'date'=>'data',
				'end_date'=>'data chiusura',
			];
		}

		public function fillFormFields(){
    	$user = User::find(168);
			$location = $this->input('location_id') == 0 ? $user->structure->legal_address.','.$user->structure->legal_zipcode : $this->input('location');
    	return [
    		'user_id'=>168, //auth()->id
				'course_id'=>$this->input('course_id'),
				'date'=>$this->input('date'),
				'end_date'=>Carbon::createFromFormat('d-m-Y', $this->input('end_date'))->format('Y-m-d'),
				'examiner_id'=>$this->input('examiner_id'),
				'invigilator_id'=>$this->input('invigilator_id'),
				'location_id'=>$this->input('location_id'),
				'location'=>$location,
				'cdd'=>0,
				'state'=>LrnExamSession::IS_ACTIVE,
				'created_by'=>168
			];
		}

}

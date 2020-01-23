<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkshopRequest extends FormRequest
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
            'when'=>'required|in:0,1',
            'date'=>'required|date',
            'partecipants'=>'required|array',
            'note'=>'required|string|min:20'

        ];
    }
    public function attributes() {
        return [
            'when'=>strtolower(trans('form.preferenze')),
            'date'=>strtolower(trans('form.data')),
            'note'=>strtolower(trans('form.description')),
            'partecipants'=>strtolower(trans('form.target')),
        ];
    }
    public function fillFormData(){

        return [
            'date'=>substr($this->date, 0, strpos($this->date, "T")),
            'created_by'=>auth()->id(),
            'note'=>$this->note,
            'partecipants'=>$this->partecipants,
            'when'=>$this->when
        ];
    }
}

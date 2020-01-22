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
            'preferenze'=>'required|in:0,1',
            'date'=>'required|date',
            'target'=>'required|array',
            'description'=>'required|string'

        ];
    }
    public function attributes() {
        return [
            'preferenze'=>strtolower(trans('form.preferenze')),
            'date'=>strtolower(trans('form.data')),
            'description'=>strtolower(trans('form.description')),
            'exclude'=>strtolower(trans('form.exclude')),
        ];
    }
    public function fillFormData(){

        return [
            'date'=>substr($this->date, 0, strpos($this->date, "T")),
            'created_by'=>auth()->id(),
            'note'=>$this->description,
            'partecipants'=>$this->target,
            'when'=>$this->preferenze
        ];
    }
}

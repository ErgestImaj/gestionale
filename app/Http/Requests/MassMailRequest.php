<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MassMailRequest extends FormRequest
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
            'subject'=>'required|string|min:3',
            'description'=>'required|string|min:15',
            'target'=>'required|array|min:1',
            'exclude'=>'nullable|array',
            'exclude.*'=>'nullable|email',
        ];
    }
    public function attributes() {
        return [
            'subject'=>trans('form.subject'),
            'description'=>trans('form.description'),
            'exclude'=>trans('form.exclude'),
        ];
    }
    public function fillFormData(){

       return [
           'subject'=>$this->subject,
           'created_by'=>auth()->id(),
           'description'=>$this->description,
           'send_to'=>implode(',',$this->target),
           'exclude'=>($this->exists('exclude') && is_array($this->exclude)) ? implode(',',$this->exclude) : null
       ];
    }
}

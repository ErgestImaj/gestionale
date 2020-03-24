<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseModuleRequest extends FormRequest
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
            'module_name'=>'required|string',
            'module_description'=>'nullable|string',
            'module_percentage_success'=>'nullable|numeric',
            'module_credits'=>'nullable|numeric',
            'module_credits_price'=>'nullable|numeric',
            'module_code'=>'nullable|string',
            'order'=>'nullable|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'module_name'=>strtolower(trans('form.name')),
            'module_code'=>strtolower(trans('form.code_module')),
            'module_percentage_success'=>strtolower(trans('form.module_percentage_success')),
            'module_credits'=>strtolower(trans('form.module_credits')),
            'module_credits_price'=>strtolower(trans('form.module_credits_price')),
            'module_description'=>strtolower(trans('form.description')),
            'order'=>'ordine',
        ];
    }

    public function fillFormData()
    {

        return [
            'module_name'=>$this->module_name,
            'module_description'=>$this->module_description,
            'module_code'=>$this->module_code,
            'module_percentage_success'=>$this->module_percentage_success ?? 0,
            'module_credits'=>$this->module_credits ??  0,
            'module_credits_price'=>$this->module_credits_price ?? 0,
            'order'=>$this->order ?? 0,
        ];
    }
}

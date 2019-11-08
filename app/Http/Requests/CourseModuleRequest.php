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
            'name'=>'required|string',
            'description'=>'nullable|string',
            'module_percentage_success'=>'nullable|numeric',
            'module_credits'=>'nullable|numeric',
            'module_credits_price'=>'nullable|numeric',
            'code'=>'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'name'=>strtolower(trans('form.name')),
            'code'=>strtolower(trans('form.code_module')),
            'module_percentage_success'=>strtolower(trans('form.module_percentage_success')),
            'module_credits'=>strtolower(trans('form.module_credits')),
            'module_credits_price'=>strtolower(trans('form.module_credits_price')),
            'description'=>strtolower(trans('form.description')),
        ];
    }

    public function fillFormData()
    {

        return [
            'module_name'=>$this->name,
            'module_description'=>$this->description,
            'module_code'=>$this->code,
            'module_percentage_success'=>$this->module_percentage_success ?? 0,
            'module_credits'=>$this->module_credits ??  0,
            'module_credits_price'=>$this->module_credits_price ?? 0,
        ];
    }
}

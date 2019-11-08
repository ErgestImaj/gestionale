<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Models\Expiry;
use App\Models\VatRate;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
     * Prepare the data for validation.
     * @return void

     */

    protected function prepareForValidation()
    {

        $this->merge([
            'category' => Category::findByHashid($this->category)->id ?? 0,
            'expiry'=>Expiry::findByHashid($this->expiry)->id ?? 0,
            'vat_rate'=>VatRate::findByHashid($this->vat_rate)->id??0,
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_name'=>'required|string|max:191',
            'category'=>'required|exists:categories,id',
            'course_code'=>'required|string',
            'duration'=>'required|numeric',
            'expiry'=>'required|exists:expiries,id',
            'course_description'=>'required',
            'skills'=>'required',
            'program_description'=>'required',
            'price'=>'required|numeric',
            'min_order_partner'=>'required|numeric',
            'min_order_master'=>'required|numeric',
            'min_order_affiliate'=>'required|numeric',
            'vat_rate'=>'required|exists:vat_rates,id',
        ];
    }

    public function attributes()
    {
        return [
            'course_name'=>strtolower(trans('form.name')),
            'category'=>strtolower(trans('form.category')),
            'course_code'=>strtolower(trans('form.code')),
            'duration'=>strtolower(trans('form.duration')),
            'expiry'=>strtolower(trans('form.expiry')),
            'course_description'=>strtolower(trans('form.description')),
            'skills'=>strtolower(trans('form.skills')),
            'program_description'=>strtolower(trans('form.program_description')),
            'price'=>strtolower(trans('form.costo')),
            'min_order_partner'=>strtolower(trans('form.min_order_partner')),
            'min_order_master'=>strtolower(trans('form.min_order_master')),
            'min_order_affiliate'=>strtolower(trans('form.min_order_affiliate')),
            'vat_rate'=>strtolower(trans('form.vat_rate')),
        ];
    }

    public function fillFormData()
    {

        return [
            'name'=>$this->course_name,
            'category_id'=>$this->category,
            'code'=>$this->course_code,
            'duration'=>$this->duration,
            'expiry'=>$this->expiry,
            'description'=>$this->course_description,
            'skills'=>$this->skills,
            'program_description'=>$this->program_description,
            'price'=>$this->price,
            'min_order_partner'=>$this->min_order_partner,
            'min_order_master'=>$this->min_order_master,
            'min_order_affiliate'=>$this->min_order_affiliate,
            'vat_rate'=>$this->vat_rate,
        ];
    }
}

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
            'name'=>'required|string|max:191',
            'category'=>'required|exists:categories,id',
            'code'=>'required|string',
            'duration'=>'required|string',
            'expiry'=>'required|exists:expiries,id',
            'description'=>'required',
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
            'name'=>mb_strtolower(trans('form.name'),'UTF-8'),
            'category'=>mb_strtolower(trans('form.category'),'UTF-8'),
            'code'=>mb_strtolower(trans('form.code'),'UTF-8'),
            'duration'=>mb_strtolower(trans('form.duration'),'UTF-8'),
            'expiry'=>mb_strtolower(trans('form.expiry'),'UTF-8'),
            'description'=>mb_strtolower(trans('form.description'),'UTF-8'),
            'skills'=>mb_strtolower(trans('form.skills'),'UTF-8'),
            'program_description'=>mb_strtolower(trans('form.program_description'),'UTF-8'),
            'price'=>mb_strtolower(trans('form.costo'),'UTF-8'),
            'min_order_partner'=>mb_strtolower(trans('form.min_order_partner'),'UTF-8'),
            'min_order_master'=>mb_strtolower(trans('form.min_order_master'),'UTF-8'),
            'min_order_affiliate'=>mb_strtolower(trans('form.min_order_affiliate'),'UTF-8'),
            'vat_rate'=>mb_strtolower(trans('form.vat_rate'),'UTF-8'),
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

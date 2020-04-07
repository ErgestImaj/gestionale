<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
     */
    public function prepareForValidation() {

        $doc = json_decode($this->get('doc'),true);

        $this->merge([
            'id' => isset( $doc['id']) ? $doc['id'] : '',
            'role' => isset( $doc['role']) ? $doc['role'] : '',
            'types' => isset( $doc['types']) ? $doc['types'] : '',
            'category'=> isset($doc['category']) ? $doc['category'] : '',
            'name'=>isset($doc['name']) ? $doc['name'] : '',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roles =  [
            'role'=>'required|array',
				  	'types'=>'required|array',
            'role.*'=>'numeric',
            'category'=>'required|array',
            'category.*'=>'numeric',
            'name'=>'required|string|min:3|max:199',
        ];
        if (!empty($this->id)){
            $roles['doc_file'] = 'nullable|max:10000';
        }else{
            $roles['doc_file'] = 'required|file|max:10000';
        }
        return $roles;


    }
}

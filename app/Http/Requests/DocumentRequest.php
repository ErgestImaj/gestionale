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
            'role' => isset( $doc['role']) ? $doc['role'] : '',
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
        return [
            'role'=>'required|array',
            'role.*'=>'numeric',
            'category'=>'required|array',
            'category.*'=>'numeric',
            'name'=>'required|string|min:3|max:199',
            'doc_file'=>'required|file|max:10000',
        ];
    }
}

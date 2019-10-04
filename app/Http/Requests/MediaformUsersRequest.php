<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MediaformUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userId =  $this->user->id ??  null;
       $rules =  [
            'first_name'=>'required|string|max:191',
            'last_name'=>'required|string|max:191',
            'email'=>'required|email|unique:users,email,'.$userId,
            'image'=>'nullable|sometimes|mimes:jpg,png,jpeg'
        ];
        $userId ? $rules['password']='nullable|sometimes|min:6' : $rules['password']='required|min:6';

        return $rules;
    }
    /**
     * Get attributes that apply to the request.
     *
     * @return array
     */
    public function attributes(){
        return [
            'first_name' => 'nome',
            'last_name'  => 'cognome',
            'image'      => 'immagine profilo'
        ];
    }
    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'Il campo :attribute è obbligatorio.',
            'mimes'=>'L\':attribute deve essere un file di tipo:jpg,png,jpeg ',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class MediaformUsersRequest extends FormRequest
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
		 * Prepare data for validation
		 */
		public function prepareForValidation() {

			$this->merge(
				json_decode( $this->input( 'user' ), true )
			);
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
        if ($this->input('type') == User::$roles[User::TUTOR]) $rules['corsi'] = 'required|array';
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

}

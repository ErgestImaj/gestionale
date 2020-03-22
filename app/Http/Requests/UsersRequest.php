<?php

namespace App\Http\Requests;

use App\Helpers\Upload;
use App\Models\User;
use App\Models\UsersInfo;
use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
	protected $userId;

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
	public function prepareForValidation()
	{
		if (!empty($this->input('user')))
			$this->merge(
				json_decode($this->input('user'), true)
			);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$this->userId = $this->user_id ?? null;
		$rules = [
			'firstname' => 'bail|required|string|min:2|max:191',
			'lastname' => 'required|string|min:2|max:191',
			'email' => 'required|email|unique:users,email,'.$this->userId,
			'phone' => 'sometimes|nullable|string',
			'mobile' => 'sometimes|nullable|string',
			'corsi' => 'sometimes|nullable|array',
			'type' => 'required|string',
			'lrn_user' => 'required|numeric',
			'fiscal_code' => 'required|string',
			'gender' => 'required|string',
			'birth_date' => 'required|date',
			'nationality' => 'required|numeric|exists:location_countries,id',
			'country' => 'required|numeric|exists:location_countries,id',
			'birth_place' => 'required|numeric|exists:location_towns,id',
			'town' => 'required|numeric|exists:location_towns,id',
			'region' => 'required|numeric|exists:location_regions,id',
			'prov' => 'required|numeric|exists:location_provs,id',
			'address' => 'required|string',
			'zipcode' => 'required|string',
			'education' => 'required|numeric|exists:educations,id',
			'document_type' => 'required|numeric|exists:document_types,id',
			'document_number' => 'required',
			'document_expire_date' => 'required|date',
			'structure_id' => 'sometimes|nullable|numeric|exists:structures_structures,id',
			'high_school_diploma_name' => 'sometimes|nullable|string',
			'high_school_diploma_date' => 'sometimes|nullable|date',
			'high_school_diploma_institute' => 'sometimes|nullable|string',
			'university_degree_faculty' => 'sometimes|nullable|string',
			'university_degree_name' => 'sometimes|nullable|string',
			'university_degree_date' => 'sometimes|nullable|date',
			'university_degree_institute' => 'sometimes|nullable|string',
		];
		if (User::$roles[User::STUDENTI] != $this->input('type')) {
			$rules['school_region'] = 'required|numeric|exists:location_regions,id';
			$rules['school_name'] = 'required|string';
			$rules['school_codice_meccanografico'] = 'required|string';
			$rules['employment'] = 'required|numeric|exists:jobs,id';
			$rules['cv'] = $this->userId ? $this->hasFile('cv') ? 'sometimes|nullable|mimes:jpeg,png,jpg,pdf' :'' : 'required|mimes:jpeg,png,jpg,pdf';
		}

		$rules['document'] = $this->userId ? $this->hasFile('document') ? 'sometimes|nullable|mimes:jpeg,png,jpg,pdf' :'' : 'required|mimes:jpeg,png,jpg,pdf';

		return $rules;
	}

	public function attributes()
	{
		return [
			'firstname' => 'nome',
			'lastname' => 'cognome',
			'phone' => 'telefono',
			'mobile' => 'cellulare',
			'type' => 'tipo',
			'lrn_user' => 'tipo',
			'fiscal_code' => 'codice fiscale',
			'gender' => 'sesso',
			'birth_date' => 'data di nascita',
			'nationality' => 'nazionalità',
			'country' => 'stato',
			'birth_place' => 'luogo di nascita',
			'town' => 'città',
			'region' => 'regione',
			'prov' => 'provincia',
			'address' => 'indirizzo',
			'zipcode' => 'codice postale',
			'education' => 'titolo di studio',
			'document_type' => 'tipo di documento',
			'document_number' => 'numero di documento',
			'document_expire_date' => 'data scadenza documento',
			'document' => 'documento di identità',
			'structure_id' => 'struttura',
			'high_school_diploma_name' => 'diploma',
			'high_school_diploma_date' => 'data diploma',
			'high_school_diploma_institute' => 'istituto diploma',
			'university_degree_faculty' => 'facoltà universitaria',
			'university_degree_name' => 'laurea',
			'university_degree_date' => 'data laurea',
			'university_degree_institute' => 'università',
			'school_region' => 'regione istituto scolastico',
			'school_name' => 'istituto',
			'school_codice_meccanografico' => 'codice meccanografico',
			'employment' => 'occupazione',
			'cv' => 'curriculum vitae'
		];
	}

	/**
	 * @return array
	 */
	public function fillUser()
	{
		$avatar = '';
		if ($this->hasFile('image')) {
			if ($this->file('image')->isValid()) {
				$upload = new Upload();
				$avatar = $upload->upload($this->file('image'), 'public/avatars')->resize(100, 100)->getData();
				$avatar = $avatar['basename'];
			}
		}
		$user = [
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'email' => $this->email
		];
		if (!empty($avatar)) $user['avatar'] = $avatar;
		if (!$this->userId) $user['password'] = uniqid();

		return $user;

	}

	/**
	 * @return array
	 */
	public function fillUserInfo()
	{
		$token = $this->token ?: uniqid();
		$image = null;
		if ($this->hasFile('document')) {
			if ($this->file('document')->isValid()) {
				$upload = new Upload();
				$image = $upload->upload($this->file('document'), 'public' . DIRECTORY_SEPARATOR . UsersInfo::CONTENT_PATH . DIRECTORY_SEPARATOR . $token)->getData();
				$image = $image['basename'];
			}
		}
		$userinfo = [
			'lrn_user' => $this->input('lrn_user'),
			'is_editable' => $this->userId ? $this->input('is_editable') : UsersInfo::IS_EDITABLE,
			'fiscal_code' => $this->input('fiscal_code'),
			'gender' => $this->input('gender'),
			'birth_date' => $this->input('birth_date'),
			'birth_place' => $this->input('birth_place'),
			'nationality' => $this->input('nationality'),
			'phone' => $this->input('phone'),
			'mobile' => $this->input('mobile'),
			'country' => $this->input('country'),
			'region' => $this->input('region'),
			'prov' => $this->input('prov'),
			'town' => $this->input('town'),
			'address' => $this->input('address'),
			'zipcode' => $this->input('zipcode'),
			'education' => $this->input('education'),
			'document_type' => $this->input('document_type'),
			'document_number' => $this->input('document_number'),
			'document_expire_date' => $this->input('document_expire_date'),
			'document' => $this->hasFile('document') ? $image : $this->document,
			'structure_id' => $this->input('structure_id') ?: 0,
			'high_school_diploma_name' => $this->input('high_school_diploma_name'),
			'high_school_diploma_date' => $this->input('high_school_diploma_date'),
			'high_school_diploma_institute' => $this->input('high_school_diploma_institute'),
			'university_degree_faculty' => $this->input('university_degree_faculty'),
			'university_degree_name' => $this->input('university_degree_name'),
			'university_degree_date' => $this->input('university_degree_date'),
			'university_degree_institute' => $this->input('university_degree_institute'),
			'token' => $token,
		];
		if (User::$roles[User::STUDENTI] != $this->input('type')) {
			$userinfo['school_region'] = $this->input('school_region');
			$userinfo['school_name'] = $this->input('school_name');
			$userinfo['school_codice_meccanografico'] = $this->input('school_codice_meccanografico');
			$userinfo['employment'] = $this->input('employment');
			$cv = '';
			if ($this->hasFile('cv')) {
				if ($this->file('cv')->isValid()) {
					$upload = new Upload();
					$cv = $upload->upload($this->file('cv'), 'public' . DIRECTORY_SEPARATOR . UsersInfo::CONTENT_PATH . DIRECTORY_SEPARATOR . $token)->getData();
					$cv = $cv['basename'];
				}
			}
			$userinfo['cv'] = $cv;
		}
		return $userinfo;
	}
}

<?php

namespace App\Http\Requests;

use App\Helpers\Upload;
use App\Models\Accreditation;
use App\Models\Structure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class StructureRequest extends FormRequest {

	public $userId;
	public $structureId;
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return auth()->check() && $this->user()->can( 'create', 'App\Models\Structure' );
	}

	/**
	 * Prepare data for validation
	 */
	public function prepareForValidation() {

		$this->merge(
			json_decode( $this->input( 'structure' ), true )
		);
	}


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$this->structureId =  $this->id ??  null;
		$this->userId =  $this->user_id ??  null;
		$rules = [
			'nome'                => 'bail|required|string|min:2|max:191',
			'legal_name'          => 'required|string|min:2|max:191',
			'piva'                => 'required|string|max:191',
			'tax_code'            => 'required|string|min:2|max:191',
			'codice_destinatario' => 'sometimes|min:7|max:7',
			'legal_zipcode'       => 'required|string',
			'legal_address'       => 'required|string',
			'legal_region'        => 'required|numeric|exists:location_regions,id',
			'legal_town'          => 'required|numeric|exists:location_towns,id',
			'legal_country'       => 'required|numeric|exists:location_countries,id',
			'legal_prov'          => 'required|numeric|exists:location_provs,id',
			'operational_zipcode' => 'sometimes|string',
			'operational_address' => 'sometimes|string',
			'operational_town'    => 'sometimes|numeric|exists:location_towns,id',
			'operational_region'  => 'sometimes|numeric|exists:location_regions,id',
			'operational_prov'    => 'sometimes|numeric|exists:location_provs,id',
			'operational_country' => 'sometimes|numeric|exists:location_countries,id',
			'parent'              => 'sometimes|nullable|numeric|exists:structures_structures,id',
			'minimum_order'       => 'sometimes|nullable|numeric',
			'phone'               => 'required|string',
			'fax'                 => 'sometimes|string',
			'pec'                 => 'sometimes|email',
			'email'               => 'required|email|unique:users,email,'.$this->userId,
			'website'             => 'sometimes|string',
			'accredit'            => 'required|array',
			'doc_file3'           => 'nullable|mimes:jpeg,png,jpg',
		];
		if ( is_array( $this->get( 'accredit' ) ) ) {
			foreach ( $this->get( 'accredit' ) as $acredit ) {
				switch ( $acredit ) {
					case Accreditation::MIUR:
						$rules['accredit_miur'] = 'required|date';
						break;
					case Accreditation::MF:
						$rules['accredit_mf'] = 'required|date';
						break;
					case Accreditation::IIQ:
						$rules['accredit_iiq'] = 'required|date';
						break;
					case Accreditation::LRN:
						$rules['accredit_lrn'] = 'required|date';
						break;
					case Accreditation::DILE:
						$rules['accredit_dile'] = 'required|date';
						break;
				}
			}
		}

		if ($this->structureId){
			$rules['doc_file2'] = 'nullable|mimes:jpeg,png,jpg,pdf';
			$rules['doc_file1'] = 'nullable|mimes:jpeg,png,jpg,pdf';
		}else{
			$rules['doc_file2'] = 'required|mimes:jpeg,png,jpg,pdf';
			$rules['doc_file1'] = 'required|mimes:jpeg,png,jpg,pdf';
		}


		return $rules;
	}

	public function attributes() {

		return [
			'nome'                => strtolower( trans( 'form.nome_strutura' ) ),
			'legal_name'          => strtolower( trans( 'form.ragione_sociale' ) ),
			'tax_code'            => 'codice fiscale',
			'legal_region'        => 'regione',
			'operational_region'  => 'regione',
			'legal_country'       => strtolower( trans( 'form.country' ) ),
			'operational_country' => strtolower( trans( 'form.country' ) ),
			'legal_town'          => 'città',
			'operational_town'    => strtolower( trans( 'form.city' ) ),
			'legal_prov'          => strtolower( trans( 'form.state' ) ),
			'operational_prov'    => strtolower( trans( 'form.state' ) ),
			'legal_zipcode'       => strtolower( trans( 'form.cap' ) ),
			'operational_zipcode' => strtolower( trans( 'form.cap' ) ),
			'legal_address'       => strtolower( trans( 'form.address' ) ),
			'operational_address' => strtolower( trans( 'form.address' ) ),
			'phone'               => strtolower( trans( 'form.phone' ) ),
			'website'             => strtolower( trans( 'form.site' ) ),
			'doc_file1'           => 'domanda accreditamento',
			'doc_file2'           => 'visura camerale',
			'doc_file3'           => 'logo struttura',
			'accredit_miur'       => 'data accreditamento MIUR',
			'accredit_mf'         => 'data accreditamento MF',
			'accredit_lrn'        => 'data accreditamento LRN',
			'accredit_dile'       => 'data accreditamento DILE',
			'accredit_iiq'        => 'data accreditamento IIQ',
			'parent'              => 'struttura madre',
			'minimum_order'       => 'ordine minimo',

		];
	}

	public function fillStructure() {
		$token = $this->token ?: uniqid();
		$validation_request = $visura_camerale = $image = null;
		if ( $this->hasFile( 'doc_file1' ) ) {
			if ( $this->file( 'doc_file1' )->isValid() ) {
				$upload = new Upload();
				$validation_request   = $upload->upload( $this->file( 'doc_file1' ), 'public'.DIRECTORY_SEPARATOR.Structure::CONTENT_PATH.DIRECTORY_SEPARATOR.$token )->getData();
				$validation_request   = $validation_request['basename'];
			}
		}
		if ( $this->hasFile( 'doc_file2' ) ) {
			if ( $this->file( 'doc_file2' )->isValid() ) {
				$upload = new Upload();
				$visura_camerale   = $upload->upload( $this->file( 'doc_file2' ), 'public'.DIRECTORY_SEPARATOR.Structure::CONTENT_PATH.DIRECTORY_SEPARATOR.$token )->getData();
				$visura_camerale   = $visura_camerale['basename'];
			}
		}
		if ( $this->hasFile( 'doc_file3' ) ) {
			if ( $this->file( 'doc_file3' )->isValid() ) {
			   $upload = new Upload();
				 $image   = $upload->upload( $this->file( 'doc_file3' ), 'public/' . Structure::CONTENT_PATH.'/'.$token )->getData();
				 $image   =  $image['basename'];
			}
		}

		$structure = [
			'name'                => $this->nome,
			'type'                => $this->structureId ? $this->type : $this->route( 'type' ),
			'legal_name'          => $this->legal_name,
			'tax_code'            => $this->tax_code,
			'piva'                => $this->piva,
			'lrn'                 => $this->lrn,
			'codice_destinatario' => $this->codice_destinatario,
			'legal_region'        => $this->legal_region,
			'operational_region'  => $this->operational_region,
			'legal_country'       => $this->legal_country,
			'operational_country' => $this->operational_country,
			'legal_town'          => $this->legal_town,
			'operational_town'    => $this->operational_town,
			'legal_prov'          => $this->legal_prov,
			'operational_prov'    => $this->operational_prov,
			'legal_zipcode'       => $this->legal_zipcode,
			'operational_zipcode' => $this->operational_zipcode,
			'legal_address'       => $this->legal_address,
			'operational_address' => $this->operational_address,
			'phone'               => $this->phone,
			'fax'                 => $this->fax,
			'email'               => $this->email,
			'pec'                 => $this->pec,
			'website'             => $this->website,
			'state'               => 1,
			'visura_camerale'     => $this->hasFile( 'doc_file2' ) ? $visura_camerale : $this->visura_camerale,
			'validation_request'  => $this->hasFile( 'doc_file1' ) ? $validation_request : $this->validation_request,
			'image'               => $this->hasFile( 'doc_file3' ) ? $image : $this->image,
			'token'               => $token,
			'parent_structure_id' => $this->parent,
			'minimum_order'       => $this->minimum_order,
		];
		if (!$this->structureId){
			$structure['created_by'] = auth()->id();
		}
		return $structure;
	}

	public function fillStructureStatus() {
		$status = [
			'state'=>1,
			'status_miur'=>null,
			'date_miur'=>null,
			'status'=>null,
			'date'=>null,
			'status_iiq'=>null,
			'date_iiq'=>null,
			'status_lrn'=>null,
			'date_lrn'=>null,
			'status_dile'=>null,
			'date_dile'=>null
		];
		foreach ( $this->get( 'accredit' ) as $acredit ) {
			switch ( $acredit ) {
				case Accreditation::MIUR:
				  Arr::set($status,'status_miur',1);
				  Arr::set($status,'date_miur', $this->accredit_miur);
					break;
				case Accreditation::MF:
					Arr::set($status,'status',1);
					Arr::set($status,'date', $this->accredit_mf);
					break;
				case Accreditation::IIQ:
					Arr::set($status,'status_iiq',1);
					Arr::set($status,'date_iiq', $this->accredit_iiq);
					break;
				case Accreditation::LRN:
					Arr::set($status,'status_lrn',1);
					Arr::set($status,'date_lrn', $this->accredit_lrn);
					break;
				case Accreditation::DILE:
					Arr::set($status,'status_dile',1);
					Arr::set($status,'date_dile', $this->accredit_dile);
					break;
			}
		}
		return $status;
	}

	public function fillStructureUser() {
		$avatar='';
		if ($this->hasFile('doc_file3')) {
			if ($this->file('doc_file3')->isValid()) {
				$upload = new Upload();
				$avatar = $upload->upload($this->file('doc_file3'), 'public/avatars')->resize(100, 100)->getData();
				$avatar = $avatar['basename'];
			}
		}
		$user =  [
			'firstname' => $this->nome,
			'lastname'  => $this->nome,
			'email'     => $this->email,
			'avatar'    => $this->hasFile('doc_file3') ?  $avatar : $this->image
		];
		if (!$this->structureId){
			$user['password'] = uniqid();
		}
		return $user;

	}

}

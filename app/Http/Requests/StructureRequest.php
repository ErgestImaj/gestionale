<?php

namespace App\Http\Requests;

use App\Helpers\Upload;
use App\Models\Accreditation;
use App\Models\Structure;
use Illuminate\Foundation\Http\FormRequest;

class StructureRequest extends FormRequest {
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
			json_decode( $this->get( 'structure' ), true )
		);
	}


	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		$rules = [
			'nome'                => 'bail|required|string|min:2|max:191',
			'legal_name'          => 'required|string|min:2|max:191',
			'piva'                => 'required|string|max:191',
			'tax_code'            => 'required|string|min:2|max:191',
			'codice_destinatario' => 'sometimes|string|min:7|max:7',
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
			'phone'               => 'required|string',
			'fax'                 => 'sometimes|string',
			'email'               => 'required|email|unique:users',
			'pec'                 => 'sometimes|email',
			'website'             => 'sometimes|url',
			'accredit'            => 'required|array',
			'doc_file3'           => 'nullable|mimes:jpeg,png,jpg',
			'doc_file2'           => 'required|mimes:jpeg,png,jpg,pdf',
			'doc_file1'           => 'required|mimes:jpeg,png,jpg,pdf',
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
		];
	}

	public function fillStructure() {
		$token = uniqid();
		$validation_request = $visura_camerale = $image = null;
		if ( $this->hasFile( 'doc_file1' ) ) {
			if ( $this->file( 'doc_file1' )->isValid() ) {
				$upload = new Upload();
				$validation_request   = $upload->upload( $this->file( 'doc_file1' ), 'public/' . Structure::CONTENT_PATH.'/'.$token )->getData();
				$validation_request   = $validation_request['basename'];
			}
		}
		if ( $this->hasFile( 'doc_file2' ) ) {
			if ( $this->file( 'doc_file2' )->isValid() ) {
				$upload = new Upload();
				$visura_camerale   = $upload->upload( $this->file( 'doc_file2' ), 'public/' . Structure::CONTENT_PATH.'/'.$token )->getData();
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

		return [
			'name'                => $this->nome,
			'type'                => $this->route( 'type' ),
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
			'visura_camerale'     => $visura_camerale,
			'validation_request'  => $validation_request,
			'image'               => $image,
			'token'               => $token,
			'created_by'          => auth()->id()
		];
	}

	public function fillStructureStatus() {
		$status = [];
		foreach ( $this->get( 'accredit' ) as $acredit ) {
			switch ( $acredit ) {
				case Accreditation::MIUR:
					$status['status_miur'] = 1;
					$status['date_miur']   = $this->accredit_miur;
					break;
				case Accreditation::MF:
					$status['status'] = 1;
					$status['date']   = $this->accredit_mf;
					break;
				case Accreditation::IIQ:
					$status['status_iiq'] = 1;
					$status['date_iiq']   = $this->accredit_iiq;
					break;
				case Accreditation::LRN:
					$status['status_lrn'] = 1;
					$status['date_lrn']   = $this->accredit_lrn;
					break;
				case Accreditation::DILE:
					$status['status_dile'] = 1;
					$status['date_dile']   = $this->accredit_dile;
					break;
			}
		}
		$status['state']=1;
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
		return [
			'firstname' => $this->nome,
			'lastname'  => $this->nome,
			'email'     => $this->email,
			'password'  => uniqid(),
			'avatar'      => $avatar
		];

	}
}

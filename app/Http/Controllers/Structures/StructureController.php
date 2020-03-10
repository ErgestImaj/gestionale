<?php

namespace App\Http\Controllers\Structures;

use App\Http\Controllers\Controller;
use App\Http\Requests\StructureRequest;
use App\Models\StructureStatus;
use App\Models\User;
use App\Models\UserGroups;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Structure;
use Illuminate\Support\Facades\Password;
use Psy\Util\Str;


class StructureController extends Controller {

	public function partnerIndex() {
		return view( 'struture.index', [
			'type' => Structure::TYPE_PARTNER
		] );
	}

	public function masterIndex() {
		return view( 'struture.index', [
			'type' => Structure::TYPE_MASTER
		] );
	}

	public function affiliatiIndex() {
		return view( 'struture.index', [
			'type' => Structure::TYPE_AFFILIATE
		] );
	}

	public function sconto(Structure $structure) {

		return view('struture.sconto')->with([
			'structure'=>$structure
		]);
	}

	// TODO: check user permission
	public function getStructure( Request $request ) {

		if ( empty( $request->type ) ) {
			return null;
		}

		return Structure::where( 'type', $request->type )->with( ['province','owner'] )->latest()->get();
	}

	public function getStructureParent($type){
    if(empty($type)) return [];
    if(auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)){
	      return Structure::where( 'type', (int)$type - 1 )->latest()->get(['id','legal_name']);
    }
    elseif (auth()->user()->hasRole(User::PARTNER)){
	    return Structure::where( 'type', (int)$type - 1 )->where('created_by',auth()->id())->latest()->get(['id','legal_name']);
    }
	}

	public function store( StructureRequest $request,$type ) {

		//create struture user
		$user = new User;
		$user->fill( $request->fillStructureUser() );
		try {
			$user->save();
		} catch ( \Exception $exception ) {
			logger( $exception->getMessage() );
			return response( [
				'status' => 'error',
				'msg'    => trans( 'messages.error' )
			] );
		}
		//assign role to user
		if($type == Structure::TYPE_PARTNER):
	  	$user->roles()->sync(UserGroups::where('name', User::PARTNER)->firstOrFail()->id);
		elseif ($type == Structure::TYPE_MASTER):
			$user->roles()->sync(UserGroups::where('name', User::MASTER)->firstOrFail()->id);
		elseif ($type == Structure::TYPE_AFFILIATE):
			$user->roles()->sync(UserGroups::where('name', User::AFFILIATI)->firstOrFail()->id);		//create structure statuses
    endif;

		//create structure

		$structure  = new Structure;
		$structure->user_id = $user->id;
		$structure->fill($request->fillStructure());
		$structure->code = $user->username;
		try {
			$structure->save();
		} catch ( \Exception $exception ) {
			logger( $exception->getMessage() );
			return response( [
				'status' => 'error',
				'msg'    => trans( 'messages.error' )
			] );
		}

		//create structure status

		$status  = new StructureStatus;
		$status->structure_id = $structure->id;
		$status->fill($request->fillStructureStatus());
		try {
			$status->save();
		} catch ( \Exception $exception ) {
			logger( $exception->getMessage() );
			return response( [
				'status' => 'error',
				'msg'    => trans( 'messages.error' )
			] );
		}

		if ($request->input('login')){
			$token = Password::broker()->createToken($user);
			$user->sendPasswordResetNotification($token);
		}

		return response( [
			'status' => 'success',
			'msg'    => trans( 'messages.success' )
		] );

	}

	public function show(Structure $structure){

		$status_details = [
			'status_mf'=>$structure->status->status ?? '',
			'data_mf'=>format_date($structure->status->date) ?? '',
			'status_lrn'=>$structure->status->status_lrn ?? '',
			'data_lrn'=>format_date($structure->status->date_lrn) ?? '',
			'status_dile'=>$structure->status->status_dile ?? '',
			'data_dile'=>format_date($structure->status->date_dile) ?? '',
			'status_miur'=>$structure->status->status_miur ?? '',
			'data_miur'=>format_date($structure->status->date_miur) ?? '',
			'status_iiq'=>$structure->status->status_iiq ?? '',
			'data_iiq'=>format_date($structure->status->date_iiq) ?? '',
		];
		$structure_details =[
			'name'=>$structure->name,
			'legal_name'=>$structure->legal_name,
			'piva'=>$structure->piva,
			'tax_code'=>$structure->tax_code,
			'legal_country'=>$structure->county->name ?? '',
			'legal_region'=>$structure->region->title ?? '',
			'legal_prov'=>$structure->province->title ?? '',
			'legal_town'=>$structure->town->title ?? '',
			'legal_address'=>$structure->legal_address,
			'legal_zipcode'=>$structure->legal_zipcode,
			'operational_country'=>$structure->operationalCountry->name ?? '',
			'operational_region'=>$structure->operationalRegion->title ?? '',
			'operational_prov'=>$structure->operationalProvince->title ?? '',
			'operational_town'=>$structure->operationalTown->title ?? '',
			'operational_address'=>$structure->operational_address,
			'operational_zipcode'=>$structure->operational_zipcode,
			'phone'=>$structure->phone,
			'fax'=>$structure->fax,
			'email'=>$structure->email,
			'pec'=>$structure->pec,
			'webiste'=>$structure->website,
			'codice_destinatario'=>$structure->codice_destinatario,
			'structura_madre'=>$structure->parent->legal_name ?? '',
			'lrn_code'=>$structure->lrn,
			'profile_img'=>Structure::CONTENT_PATH.'/'.$structure->token.'/'.$structure->image,
			'visura_camerale'=>Structure::CONTENT_PATH.'/'.$structure->token.'/'.$structure->visura_camerale,
			'validation_request'=>Structure::CONTENT_PATH.'/'.$structure->token.'/'.$structure->validation_request,
			'minimum_order'=>$structure->minimum_order

		];
		$user_details=[
			'created_by'=>$structure->user->display_name,
			'updated_by'=>$structure->updatedByUser->display_name ?? '',
			'created_at'=>format_date($structure->created) ?? '',
			'updated_at'=>format_date($structure->updated) ?? '',
			'state'=>$structure->user->state,
			'username'=>$structure->owner->username,
			'locked'=>format_date($structure->user->locked) ?? '',
			'locked_by'=>format_date($structure->user->locked) ?? '',
			'last_login_id'=>$structure->user->last_login_ip,
			'last_login'=>diffForHumans($structure->user->last_login),
		];

		return [
			'status_details'=>$status_details,
			'structure_details'=>$structure_details,
			'user_details'=>$user_details
		];
	}

	public function details(Structure $structure) {
		return view('struture.details')->with([
			'structure'=>$structure
		]);
	}
	public function edit(Structure $structure){
		return $structure->load('status');
	}
	public function update(StructureRequest $request, Structure $structure){

		try {
			$structure->status()->update($request->fillStructureStatus());
			$structure->user()->update($request->fillStructureUser());
			$structure->update($request->fillStructure());
		} catch ( \Exception $exception ) {
			logger( $exception->getMessage() );
			return response( [
				'status' => 'error',
				'msg'    => trans( 'messages.error' )
			] );
		}
		return response( [
			'status' => 'success',
			'msg'    => trans( 'messages.success' )
		] );
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param Discount $discount
	 *
	 * @return void
	 */
	public function updateStatus(Structure $structure)
	{
      $user = User::findOrFail($structure->user_id);
		 $user->isActive() ? $user->disable() : $user->enable();
	  	$structure->isActive() ? $structure->disable() : $structure->enable();

			return response( [
				'status' => 'success',
				'msg'    => trans('messages.change_status')
			] );

	}
	public function destroy(Structure $structure)
	{

		$structure->owner()->update([
			'updated_by'=>auth()->id(),
			'deleted_at' => Carbon::now()->toDateTimeString()
		]);
		$structure->update([
			'updated_by'=>auth()->id(),
			'deleted_at' => Carbon::now()->toDateTimeString()
		]);
		return response( [
			'status' => 'success',
			'msg'    => trans( 'messages.delete' )
		] );
	}

}

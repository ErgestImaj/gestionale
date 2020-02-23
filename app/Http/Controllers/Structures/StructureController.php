<?php

namespace App\Http\Controllers\Structures;

use App\Http\Controllers\Controller;
use App\Http\Requests\StructureRequest;
use App\Models\StructureStatus;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Http\Request;
use App\Models\Structure;
use Illuminate\Support\Facades\Password;


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

	// TODO: check user permission
	public function getStructure( Request $request ) {

		if ( empty( $request->type ) ) {
			return null;
		}

		return Structure::where( 'type', $request->type )->with( 'province' )->latest()->get();
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
}

<?php

namespace App\Http\Controllers\Structures;

use App\Exports\StructuresExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StructureRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\Structure;
use App\Models\StructureStatus;
use App\Models\User;
use App\Models\UserGroups;
use App\Models\UserStatus;
use App\Services\StructureServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;


class StructureController extends Controller
{

	public function export()
	{
		return Excel::download(new StructuresExport(request()->type, request()->from, request()->to), 'structure.xlsx');
	}

	public function partnerIndex()
	{
		return view('struture.index', [
			'type' => Structure::TYPE_PARTNER
		]);
	}

	public function masterIndex()
	{
		return view('struture.index', [
			'type' => Structure::TYPE_MASTER
		]);
	}

	public function affiliatiIndex()
	{
		return view('struture.index', [
			'type' => Structure::TYPE_AFFILIATE
		]);
	}

	public function sconto(Structure $structure)
	{

		return view('struture.sconto')->with([
			'structure' => $structure
		]);
	}

	// TODO: check user permission
	public function getStructures(Request $request)
	{
		if (empty($request->type)) return [];

		 $query = Structure::type($request->type)
			 ->with([
				 'province' => function ($query) {
					 $query->select('id', 'title');
				 },
				 'owner' => function ($query) {
					 $query->select('id', 'state');
				 },
			 ]);
		if (auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)) {
		  	return $query->latest()->get(['id', 'user_id', 'legal_prov', 'piva', 'type', 'legal_name', 'code', 'email', 'phone', 'state']);
		} elseif (auth()->user()->hasRole(User::PARTNER) || auth()->user()->hasRole(User::MASTER)) {
			 return	$query->where('created_by',auth()->id())->latest()->get(['id', 'user_id', 'legal_prov', 'piva', 'type', 'legal_name', 'code', 'email','created_by', 'phone', 'state']);
		}
     return  [];
	}

	public function getStructureLrnDile()
	{
		return Structure::whereHas('status', function ($query) {
			$query->where('status_lrn', 1)->orWhere('status_dile', 1);
		})->latest()->get(['id', 'legal_name']);
	}

	public function getStructureParent($type)
	{
		if (empty($type)) return [];
		if (auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)) {
			return Structure::type((int)$type - 1)->latest()->get(['id', 'legal_name']);
		} elseif (auth()->user()->hasRole(User::PARTNER)) {
			return Structure::type((int)$type - 1)->where('created_by', auth()->id())->latest()->get(['id', 'legal_name']);
		}
	}

	public function store(StructureRequest $request, $type)
	{

		DB::beginTransaction();

		try {

			//create struture user
			$user = new User;
			$user->fill($request->fillStructureUser());
			$user->save();

			//assign role to user
			if ($type == Structure::TYPE_PARTNER):
				$user->roles()->sync(UserGroups::where('name', User::PARTNER)->firstOrFail()->id);
			elseif ($type == Structure::TYPE_MASTER):
				$user->roles()->sync(UserGroups::where('name', User::MASTER)->firstOrFail()->id);
			elseif ($type == Structure::TYPE_AFFILIATE):
				$user->roles()->sync(UserGroups::where('name', User::AFFILIATI)->firstOrFail()->id);    //create structure statuses
			endif;

			//create structure
			$structure = new Structure;
			$structure->user_id = $user->id;
			$structure->fill($request->fillStructure());
			$structure->code = $user->username;
			$structure->save();

			//create structure status
			$status = new StructureStatus;
			$status->structure_id = $structure->id;
			$status->fill($request->fillStructureStatus());
			$status->save();
			DB::commit();

		} catch (\Exception $exception) {

			DB::rollBack();
			logger($exception->getMessage());
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}

		try {
			if ($request->input('login')) {
				$token = Password::broker()->createToken($user);
				$user->sendPasswordResetNotification($token);
			}
		} catch (Exception $exception) {
			logger('Send login access via email ' . $exception->getMessage());
		}

		return response([
			'status' => 'success',
			'msg' => trans('messages.success')
		]);

	}

	public function show(Structure $structure)
	{

		return StructureServices::dataForVue($structure);
	}

	public function details(Structure $structure)
	{
		return view('struture.details')->with([
			'structure' => $structure
		]);
	}

	public function edit(Structure $structure)
	{
		return $structure->load('status');
	}

	public function update(StructureRequest $request, Structure $structure)
	{

		try {
			$structure->status()->update($request->fillStructureStatus());
			$structure->owner()->update($request->fillStructureUser());
			$structure->update($request->fillStructure());
			return response([
				'status' => 'success',
				'msg' => trans('messages.success')
			]);
		} catch (\Exception $exception) {
			logger($exception->getMessage());
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Structure $structure
	 *
	 * @return void
	 */
	public function updateStatus(Structure $structure)
	{
		try {
			$user = User::findOrFail($structure->user_id);
      if ($user->isActive() ){
				$user->disable();
				$structure->disable();
			}else{
				$user->enable();
				$structure->enable();
			}
			return response([
				'status' => 'success',
				'msg' => trans('messages.change_status')
			]);
		} catch (\Exception $exception) {
			logger($exception->getMessage());
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Structure $structure
	 *
	 * @return void
	 */
	public function updateHierarchy(Structure $structure, Request $request)
	{

		try {
			$structure->update([
				'type' => $request->input('type')
			]);
			return response([
				'status' => 'success',
				'msg' => trans('messages.change_status')
			]);
		} catch (\Exception $exception) {
			logger($exception->getMessage());
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}

	}

	public function listActiveStructures()
	{
		return Structure::active()->get(['id', 'legal_name']);
	}

	public function destroy(Structure $structure)
	{

		$structure->owner()->update([
			'updated_by' => auth()->id(),
			'deleted_at' => Carbon::now()->toDateTimeString()
		]);
		$structure->update([
			'updated_by' => auth()->id(),
			'deleted_at' => Carbon::now()->toDateTimeString()
		]);
		return response([
			'status' => 'success',
			'msg' => trans('messages.delete')
		]);
	}

	public function getAvailableCourses($type)
	{

		if (!in_array($type, Category::getTypes())) [];
		$user_id = 168; //to be replaced with auth()->id();

		$courses = Course::active()->whereHas('cartCourseTransactions', function ($query) use ($user_id) {
			$query->whereHas('owner', function ($query) use ($user_id) {
				$query->where('user_id', $user_id);
			});
		}
		)->get(['id', 'name', 'category_id']);

		$filtered_course = $courses->filter(function ($course) use ($user_id, $type) {
//			if ($course->category->type == $type){
//				$course->qty = $course->cartCourseTransactions->where('user_id', $user_id)->sum('qty');
//				if ($course->qty > 0) return $course->modules;
			//	}
			return $course->modules;

		});

		return $filtered_course->values()->toJson();

	}

	public function getExaminers($type)
	{
		$user_id = 168; //to be replaced with auth()->id();
		$examiners = User::active()->whereHas('roles', function ($query) {
			$query->where('name', User::ESAMINATORE);
		})->where('created_by', $user_id)->get(['id', 'firstname', 'lastname', 'created_by']);
		$filtered_examiners = $examiners->filter(function ($examiner) use ($type) {
			if ($examiner->userStatus->status == UserStatus::PAYMENT_OK && $examiner->userInfo->lrn_user == $type) return $examiner;

		});

		return $filtered_examiners->values()->toJson();
	}

	public function getInvigilators($type)
	{
		$user_id = 168; //to be replaced with auth()->id();
		$invigilators = User::active()->whereHas('roles', function ($query) {
			$query->where('name', User::INVIGILATOR);
		})->where('created_by', $user_id)->get(['id', 'firstname', 'lastname', 'created_by']);

		$filtered_invigilators = $invigilators->filter(function ($invigilator) use ($type) {
			if ($invigilator->userStatus->status == UserStatus::PAYMENT_OK && $invigilator->userInfo->lrn_user == $type) return $invigilator;

		});

		return $filtered_invigilators->values()->toJson();
	}

}

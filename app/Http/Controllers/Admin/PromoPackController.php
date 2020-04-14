<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromoPackRequest;
use App\Models\PromoPack;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoPackController extends Controller
{
	public function index()
	{

		return PromoPack::with(
			[
				'courses' => function ($query) {
					$query->select(['id', 'name']);
				},
				'user' => function ($query) {
					$query->select(['id', 'firstname','lastname']);
				},
			]
		)->get();

	}

	public function store(PromoPackRequest $request){
		DB::beginTransaction();
		try {
      $promoPack = new PromoPack;
      $promoPack->fill($request->fillFormFields());
      $promoPack->save();
			$extra = array_map(function($course){
				return ['course_id'=>$course['id'],'qty'=>$course['quantity']];
			}, $request->input('corsi'));
			$course_ids = array_pluck( $extra, 'course_id');
			$qtys = array_pluck( $extra, 'qty');
			foreach ($course_ids as $key=>$val){
				$store[$val] = ['qty'=>$qtys[$key]];
			}
			$promoPack->courses()->sync($store);
			DB::commit();
			return response([
				'status' => 'success',
				'msg' => trans('messages.success'),
				'redirect'=>route('admin.promo.pack')
			]);
		} catch (\Exception $exception) {
			DB::rollback();
			logger($exception->getMessage());
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}
	}

	public function edit(PromoPack $promoPack){
		return view('course.promo.edit', [
			'promo' => $promoPack->load('courses'),
		]);
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param Structure $structure
	 *
	 * @return void
	 */
	public function update(PromoPackRequest $request, PromoPack $promoPack)
	{
		DB::beginTransaction();
		try {
			$promoPack->fill($request->fillFormFields());
			$promoPack->save();
			$extra = array_map(function($course){
				return ['course_id'=>$course['id'],'qty'=>$course['quantity']];
			}, $request->input('corsi'));
			$course_ids = array_pluck( $extra, 'course_id');
			$qtys = array_pluck( $extra, 'qty');
			foreach ($course_ids as $key=>$val){
				$store[$val] = ['qty'=>$qtys[$key]];
			}
			$promoPack->courses()->sync($store);
    DB::commit();
			return response([
				'status' => 'success',
				'msg' => trans('messages.success'),
				'redirect'=>route('admin.promo.pack')
			]);
		} catch (\Exception $exception) {
			DB::rollback();
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
	public function updateStatus(PromoPack $promoPack)
	{
		try {
			$promoPack->isActive() ? $promoPack->disable() : $promoPack->enable();
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
	public function destroy(PromoPack $promoPack)
	{
		$promoPack->update([
			'updated_by' => auth()->id(),
			'deleted_at' => Carbon::now()->toDateTimeString()
		]);
		return response([
			'status' => 'success',
			'msg' => trans('messages.delete')
		]);
	}
}

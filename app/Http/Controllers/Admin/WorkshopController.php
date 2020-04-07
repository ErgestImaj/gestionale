<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkshopRequest;
use App\Models\Workshop;
use Illuminate\Support\Str;

class WorkshopController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getWorkshops()
	{
		$workshops = Workshop::latest()->get();
		$workshops_filtred = $workshops->filter(function ($workshop) {

			$html = $workshop->when == 1 ? trans('form.afternoon') : trans('form.morning');
			$html .= ' | ' . format_date($workshop->date);
			$workshop->date = $html;
			$workshop->description = Str::limit($workshop->note, 20, '...');
			$workshop->participants = implode(', ', array_pluck($workshop->partecipants, 'name'));
			$workshop->types = implode(', ', array_pluck($workshop->types, 'name'));
			$workshop->created_by = optional($workshop->user)->displayName();
			$workshop->updated_by = optional($workshop->updatedByUser)->displayName();
			$workshop->editlink = route('admin.workshop.edit', $workshop->hashid());
			$workshop->remlink = route('admin.workshop.destroy', $workshop->hashid());
			$workshop->remMessage = trans('messages.delete_confirm', ['record' => 'workshop']);
			$workshop->hashid = $workshop->hashid();
			return $workshop;
		});

		return $workshops_filtred->values()->toJson();
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(WorkshopRequest $request)
	{
		$workshop = new Workshop;
		try {
			$workshop->fill($request->fillFormData());
			$workshop->save();
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
	 * Display the specified resource.
	 *
	 * @param \App\Models\Workshop $workshop
	 * @return \Illuminate\Http\Response
	 */
	public function show(Workshop $workshop)
	{
		return view('workshops.edit', compact('workshop'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Models\Workshop $workshop
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Workshop $workshop)
	{
		return $workshop;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Workshop $workshop
	 * @return \Illuminate\Http\Response
	 */
	public function update(WorkshopRequest $request, Workshop $workshop)
	{

		try {
			$workshop->fill($request->fillFormData());
			$workshop->updated_by = auth()->id();
			$workshop->update();
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
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Workshop $workshop
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Workshop $workshop)
	{

		try {
			$workshop->delete();
			return response([
				'status' => 'success',
				'msg' => trans('messages.delete_msg', ['record' => 'workshop'])
			]);
		} catch (\Exception $exception) {
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}


	}
}

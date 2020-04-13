<?php

namespace App\Http\Controllers;

use App\Http\Requests\ElectronicInvoiceSettingsRequest;
use App\Models\ElectronicInvoiceSettings;

class ElectronicInvoiceSettingsController extends Controller
{
	public function index(){
		$colums = (new ElectronicInvoiceSettings())->getTableColumns();
		$removeKeys=['id','user_id','created_at','updated_at'];
		$fileds = array_diff($colums,$removeKeys);
		return view('superadmin.settings.electronic-invoice',compact('fileds'));
	}
	public function store(ElectronicInvoiceSettingsRequest $request)
	{
		try {
			if (auth()->user()->electroniceInvoiceSettings()->exists()) {
				auth()->user()->electroniceInvoiceSettings()->update($request->fillFormFields());
			} else {
				$settings = new ElectronicInvoiceSettings;
				$settings->fill($request->fillFormFields());
				$settings->save();
			}

			toastr()->success('Dati salvato con successo!');
			return back();
		} catch (\Exception $exception) {
			logger($exception->getMessage());
			toastr()->error(trans('messages.error'));
			return back();
		}
	}
}

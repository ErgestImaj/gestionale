<?php

namespace App\Http\Controllers;

use App\Http\Requests\ElectronicInvoiceSettingsRequest;
use App\Models\ElectronicInvoiceSettings;

class ElectronicInvoiceSettingsController extends Controller
{
	public function index()
	{
		$colums = (new ElectronicInvoiceSettings())->getTableColumns();
		$removeKeys = ['id', 'user_id', 'created_at', 'updated_at', 'type'];
		$fileds = array_diff($colums, $removeKeys);
		$settings = ElectronicInvoiceSettings::all();
		return view('superadmin.settings.electronic-invoice', compact('fileds','settings'));
	}

	public function update(ElectronicInvoiceSettingsRequest $request,ElectronicInvoiceSettings $settings)
	{
		try {
			$settings->fill($request->fillFormFields());
			$settings->update();
			toastr()->success('Dati salvato con successo!');
			return back();
		} catch (\Exception $exception) {
			logger($exception->getMessage());
			toastr()->error(trans('messages.error'));
			return back();
		}
	}
}

<?php

namespace App\Http\Controllers\Cart;

use App\Exports\FastTrackExport;
use App\Helpers\ConfigHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceUploadRequest;
use App\Mail\FastTrackOrderShipped;
use App\Mail\ResendInvoice;
use App\Models\Cart\FastTrack;
use App\Models\ElectronicInvoiceSettings;
use App\Models\Exams\LrnExamSession;
use App\Services\ElectronicInvoiceServices;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class FastTrackController extends Controller
{
	public function export()
	{
		return Excel::download(new FastTrackExport(request()->from_date, request()->to_date, request()->structure), 'fast_track.xlsx');
	}

	public function index()
	{
		return FastTrack::with(['user' => function ($query) {
			$query->select('id', 'firstname');
		}])->latest()->get();
	}

	public function uploadInvoice(InvoiceUploadRequest $request, FastTrack $fastTrack)
	{
		try {
			$file = [];
			if ($request->hasFile('fattura')) {
				if ($request->file('fattura')->isValid()) {
					$file = UploadHelper::uploadAndGetUrl($request->file('fattura'), FastTrack::CONTENT_PATH . DIRECTORY_SEPARATOR . $fastTrack->token);
				}
			}

			if (empty(@$file['url']))
				return response([
					'status' => 'error',
					'msg' => trans('messages.error_file')
				]);

			$fastTrack->update([
				'receipt' => $file['url']
			]);
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

	public function manualOrderConfirm(FastTrack $fastTrack)
	{
		try {
			LrnExamSession::whereIn('id', $fastTrack->exam_sessions)->update(
				[
					'fast_track' => LrnExamSession::FAST_TRACK_WAIT
				]
			);

			$fastTrack->update(
				[
					'state' => FastTrack::STATE_PAYED
				]
			);
			Mail::send(
				new FastTrackOrderShipped($fastTrack)
			);
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

	public function downloadInvoice(FastTrack $fastTrack)
	{
		$config = ConfigHelper::getConfigValuesByName('cart');
		$pdf = PDF::loadView('orders.invoice-fast-track', compact('fastTrack', 'config'));
		return $pdf->download('invoice.pdf');
	}

	public function sendInvoice(FastTrack $fastTrack)
	{
		try {
			Mail::send(
				new ResendInvoice($fastTrack)
			);
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
	 * @param FastTrack $fastTrack
	 * TO DO: code refactor
	 */
	public function generateInvoice(FastTrack $fastTrack)
	{
		if (empty(@$fastTrack->user->structure->pec)) {
			toastr()->error('il pec email e un campo obbligatorio per fattura elettronica');
			return back();
		}

		if ((empty(@$fastTrack->user->structure->piva)) && empty(@$fastTrack->user->structure->tax_code)) {
			toastr()->error('il PIVA e un campo obbligatorio per fattura elettronica');
			return back();
		}

		$setting = ElectronicInvoiceSettings::where('type',$fastTrack->type)->first();
		$electronic_invoice = ElectronicInvoiceServices::generateXMLInvoice($fastTrack, $fastTrack->user->structure,$setting);
		if ($electronic_invoice) {
			toastr()->success('Fattura elettronica generato con successo!');
			return view('orders.electronic-invoice');
		}
		toastr()->error(trans('messages.error'));
		return back();
	}
}

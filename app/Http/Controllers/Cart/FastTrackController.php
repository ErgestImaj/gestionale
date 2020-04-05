<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\ConfigHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceUploadRequest;
use App\Mail\FastTrackOrderShipped;
use App\Mail\ResendInvoice;
use App\Models\Cart\ElectronicInvoice;
use App\Models\Cart\FastTrack;
use App\Models\Exams\LrnExamSession;
use App\Services\ElectronicInvoiceServices;
use http\Env\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class FastTrackController extends Controller
{
    public function index(){
         return FastTrack::with(['user'=>function($query){
         	 $query->select('id','firstname');
				 }])->latest()->get();
		}
		public function uploadInvoice(InvoiceUploadRequest $request, FastTrack $fastTrack){
			try {
				$file=[];
				if ($request->hasFile('fattura')){
					if ($request->file('fattura')->isValid()) {
						$file = UploadHelper::uploadAndGetUrl($request->file('fattura'), FastTrack::CONTENT_PATH.DIRECTORY_SEPARATOR.$fastTrack->token);
					}
				}

				if (empty(@$file['url']))
					return response([
						'status' => 'error',
						'msg' => trans('messages.error_file')
					]);

				 $fastTrack->update([
				 	'receipt'=> $file['url']
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
		public function manualOrderConfirm(FastTrack $fastTrack){
			try {
				LrnExamSession::whereIn('id',$fastTrack->exam_sessions)->update(
					[
						'fast_track'=>LrnExamSession::FAST_TRACK_WAIT
			  	]
				);

				$fastTrack->update(
					[
						'state'=>FastTrack::STATE_PAYED
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
		public function downloadInvoice(FastTrack $fastTrack){
			$config = ConfigHelper::getConfigValuesByName('cart');
			$pdf =  PDF::loadView('orders.invoice-fast-track',compact('fastTrack','config'));
			return $pdf->download('invoice.pdf');
		}
		public function sendInvoice(FastTrack $fastTrack){
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
		public function generateInvoice(FastTrack $fastTrack){
			if (empty(@$fastTrack->user->structure->pec))
				return toastr()->success(' il pec email e un campo obbligatorio per fattura elettronica');
			if ((empty(@$fastTrack->user->structure->piva))&& empty(@$fastTrack->user->structure->tax_code))
				return toastr()->success(' il PIVA e un campo obbligatorio per fattura elettronica');

			$response = ElectronicInvoiceServices::generateXMLInvoice($fastTrack,$fastTrack->user->structure);
			if ($response['status']){
				$electronic_invoice = $response['electronic_invoice'];
        return response()->download($electronic_invoice->content_path.$electronic_invoice->receipt);
			}
			return toastr()->error(trans('messages.error'));
		}
}

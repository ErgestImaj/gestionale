<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceUploadRequest;
use App\Mail\FastTrackOrderShipped;
use App\Mail\ResendInvoice;
use App\Models\Cart\FastTrack;
use App\Models\Config;
use App\Models\Exams\LrnExamSession;
use Illuminate\Support\Facades\Mail;
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
			$config = Config::where('name', 'cart')->pluck('config_values')->first();
			$pdf=  PDF::loadView('orders.invoice-fast-track',compact('fastTrack','config'));
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
}

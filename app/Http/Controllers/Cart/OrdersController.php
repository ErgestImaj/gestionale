<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\ConfigHelper;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceUploadRequest;
use App\Models\Cart\CourseTransactions;
use App\Models\Cart\Orders;
use App\Services\ElectronicInvoiceServices;
use Illuminate\Support\Facades\DB;
use PDF;


class OrdersController extends Controller
{
	public function index()
	{
		$orders = Orders::latest()->with([
			'orderItems' => function ($query) {
				$query->type()->select(['id', 'order_id','item_id', 'qty', 'price', 'status'])->get();
			},
			'orderItems.course' => function ($query) {
				$query->select(['id', 'name'])->get();
			},
			'structure' => function ($query) {
				$query->select(['id', 'firstname']);
			},
			'paypalTransactions' => function ($query) {
				$query->select(['id','order_id', 'params']);
			},
		])->get(['id', 'type', 'user_id', 'price','token', 'order_number', 'order_date', 'payment_type', 'status', 'receipt']);
		$filtered_collection = $orders->filter(function ($order) {
			if ($order->payment_type == Orders::PAYPAL && $order->status == Orders::STATUS_PENDING){}
			else{
				return $order;
			};
		});

	 return $filtered_collection->values()->toJson();
	}
	public function uploadInvoice(InvoiceUploadRequest $request, Orders $order){
		try {
			$file=[];
			if ($request->hasFile('fattura')){
				if ($request->file('fattura')->isValid()) {
					$file = UploadHelper::uploadAndGetUrl($request->file('fattura'), Orders::CONTENT_PATH.DIRECTORY_SEPARATOR.$order->token);
				}
			}

			if (empty(@$file['url']))
				return response([
					'status' => 'error',
					'msg' => trans('messages.error_file')
				]);

			$order->update([
				'receipt'=> $file['url'],
				'updated_by'=>auth()->id()
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
	public function manualOrderConfirm(Orders $order){
		DB::beginTransaction();
		try {

			foreach ($order->orderItems as $item):
				CourseTransactions::create(
					[
						'user_id'=>$order->structure->id,
						'course_id'=>$item->item_id,
						'qty'=>$item->qty,
						'order_id'=>$order->id,
						'paypal_transaction_id'=>$order->paypalTransactions->id ?? 0,
						'parent_transaction_id'=>0,
						'type'=>CourseTransactions::TYPE_COURSE_PURCHASE,
						'state'=>1,
						'created_by'=>auth()->id(),
						'updated_by'=>auth()->id(),
					]
				);
			endforeach;
			$order->update([
				'status'=>Orders::STATUS_COMPLETE,
				'updated_by'=>auth()->id()
			]);
			DB::commit();

			return response([
				'status' => 'success',
				'msg' => trans('messages.success')
			]);
		} catch (\Exception $exception) {
			DB::rollBack();
			logger($exception->getMessage());
			return response([
				'status' => 'error',
				'msg' => trans('messages.error')
			]);
		}
	}

	public function downloadInvoice(Orders $order){
		$config = ConfigHelper::getConfigValuesByName('cart');
		$pdf =  PDF::loadView('orders.invoice-order',compact('order','config'));
		return $pdf->download('invoice.pdf');
	}
	/**
	 * @param Orders $order
	 * TO DO: code refactor
	 */
	public function generateInvoice(Orders $order){
		if (empty(@$order->structure->structure->pec)){
			toastr()->error('il pec email e un campo obbligatorio per fattura elettronica');
			return back();
		}

		if ((empty(@$order->structure->structure->piva))&& empty(@$order->structure->structure->tax_code)){
			toastr()->error('il PIVA e un campo obbligatorio per fattura elettronica');
			return back();
		}


		$electronic_invoice = ElectronicInvoiceServices::generateXMLInvoice($order,$order->structure->structure);
		if ($electronic_invoice){
			toastr()->success('Fattura elettronica generato con successo!');
			return view('orders.electronic-invoice');
		}
		toastr()->error(trans('messages.error'));
		return back();
	}
}

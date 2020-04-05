<?php

namespace App\Http\Controllers\Cart;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceUploadRequest;
use App\Models\Cart\Orders;


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
		])->get(['id', 'type', 'user_id', 'price', 'order_number', 'order_date', 'payment_type', 'status', 'receipt']);
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
	public function downloadInvoice(Orders $orders){
		$config = ConfigHelper::getConfigValuesByName('cart');
		$pdf =  PDF::loadView('orders.invoice-fast-track',compact('fastTrack','config'));
		return $pdf->download('invoice.pdf');
	}
}

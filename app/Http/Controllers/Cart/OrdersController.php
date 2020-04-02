<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\CartOrders;
use phpDocumentor\Reflection\Types\Collection;

class OrdersController extends Controller
{
	public function index()
	{
		$orders = CartOrders::latest()->with([
			'orderItems' => function ($query) {
				$query->type()->select(['id', 'order_id','item_id', 'qty', 'price', 'status'])->get();
			},
			'orderItems.course' => function ($query) {
				$query->select(['id', 'name'])->get();
			},
			'structure' => function ($query) {
				$query->select(['id', 'firstname']);
			},
		])->get(['id', 'type', 'user_id', 'price', 'order_number', 'order_date', 'payment_type', 'status', 'receipt']);
		$filtered_collection = $orders->filter(function ($order) {
			if ($order->payment_type == CartOrders::PAYPAL && $order->status == CartOrders::STATUS_PENDING){}else{
				return $order;
			};
		});

	 return $filtered_collection->values()->toJson();
	}
}

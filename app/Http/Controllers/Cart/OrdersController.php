<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart\CartOrders;

class OrdersController extends Controller
{
	public function index()
	{
		$orders = CartOrders::with([
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
		return $orders;
	}
}

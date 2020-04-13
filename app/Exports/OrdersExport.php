<?php

namespace App\Exports;

use App\Models\Cart\Orders;
use App\Models\Structure;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
	use Exportable;

	public function __construct($from = 0, $to = 0, $structure = 0)
	{
		$this->structure = $structure;
		$this->from = $from;
		$this->to = $to;

	}

	public function view() : View{
		$query = Orders::query();
		if ($this->from !=0 && $this->to !=0){
			$query->whereBetween('created',[$this->from,$this->to]);
		}elseif ($this->from !=0){
			$query->whereDate('created','>',$this->from);
		}elseif ($this->to !=0){
			$query->whereDate('created','<=',$this->to);
		}
		if ($this->structure){
			$structure = Structure::findByHashid($this->structure);
			$query->where('user_id',$structure->user_id);
		}
		$orders = $query->cursor()->filter(function ($order){
			if ($order->payment_type != Orders::PAYPAL || $order->status != Orders::STATUS_PENDING) return $order;
		});

		return view('orders.orders-export',['orders'=>$orders]);
	}
}

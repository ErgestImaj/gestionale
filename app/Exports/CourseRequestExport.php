<?php

namespace App\Exports;

use App\Models\Cart\CourseRequest;
use App\Models\Structure;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CourseRequestExport implements FromView
{
	use Exportable;

	public function __construct($from = 0, $to = 0, $structure = 0)
	{
		$this->structure = $structure;
		$this->from = $from;
		$this->to = $to;

	}

	public function view() : View{
		$query = CourseRequest::query();
		if ($this->from !=0 && $this->to !=0){
			$query->whereBetween('created',[$this->from,$this->to]);
		}elseif ($this->from !=0){
			$query->whereDate('created','>',$this->from);
		}elseif ($this->to !=0){
			$query->whereDate('created','<=',$this->to);
		}
		if ($this->structure){
			$structure = Structure::findByHashid($this->structure);
			$query->where('structure_id',$structure->id);
		}
		$orders = $query->cursor();

		return view('orders.structure-orders-export',['orders'=>$orders]);
	}
}

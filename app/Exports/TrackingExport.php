<?php

namespace App\Exports;

use App\Models\Structure;
use App\Models\Tracking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class TrackingExport implements FromView
{

	use Exportable;

	public function __construct($from = 0, $to = 0, $structure = 0)
	{
		$this->structure = $structure;
		$this->from = $from;
		$this->to = $to;

	}

	public function view() : View{

		$query = Tracking::query();
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
		$trackings = $query->cursor();

		return view('tracking.export',['trackings'=>$trackings]);
	}
}

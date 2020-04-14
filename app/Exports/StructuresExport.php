<?php

namespace App\Exports;

use App\Models\Structure;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StructuresExport implements FromView
{
	use Exportable;

	public function __construct($type=1, $from = null, $to = null)
	{
		$this->type = $type;
		$this->from = $from;
		$this->to = $to;

	}

	public function view() : View{

		$query = Structure::query();

		if ($this->from && $this->to){
			$query->whereBetween('created',[$this->from,$this->to]);
		}elseif ($this->from){
			$query->whereDate('created','>',$this->from);
		}elseif ($this->to){
			$query->whereDate('created','<=',$this->to);
		}
		$structures = $query->type($this->type)->cursor();

		return view('struture.export',['structures'=>$structures]);
	}


}

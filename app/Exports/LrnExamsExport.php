<?php

namespace App\Exports;

use App\Models\Exams\LrnExamSession;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class LrnExamsExport implements FromView
{
	  use Exportable;

	public function __construct($type=1, $from = null, $to = null)
	{
		$this->type = $type;
		$this->from = $from;
		$this->to = $to;

	}

	public function view(): View
	{
		$query = LrnExamSession::query();

		if (!is_null($this->from) && !is_null($this->to)){
			$query->whereBetween('created',[$this->from,$this->to]);
		}elseif (!is_null($this->from)){
			$query->whereDate('created','>',$this->from);
		}elseif (!is_null($this->to)){
			$query->whereDate('created','<=',$this->to);
		}
		$exams = $query->type($this->type)->cursor();

		return view('exams.lrn-export',['exams'=>$exams]);
	}
}

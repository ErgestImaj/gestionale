<?php

namespace App\Exports;

use App\Models\Exams\LrnExamSession;
use App\Models\Structure;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class LrnExamsExport implements FromView
{
	  use Exportable;

	public function __construct($type=1, $from = 0, $to = 0,$structure=0)
	{
		$this->type = $type;
		$this->from = $from;
		$this->to = $to;
		$this->structure = $structure;

	}

	public function view(): View
	{
		$query = LrnExamSession::query();

		if ($this->from && $this->to){
			$query->whereBetween('created',[$this->from,$this->to]);
		}elseif ($this->from){
			$query->whereDate('created','>',$this->from);
		}elseif ($this->to){
			$query->whereDate('created','<=',$this->to);
		}
		if ($this->structure) {
			$structure = Structure::findByHashid($this->structure);
			$query->where('created_by', $structure->user_id);
		}
		$exams = $query->type($this->type)->cursor();

		return view('exams.lrn-export',['exams'=>$exams]);
	}
}

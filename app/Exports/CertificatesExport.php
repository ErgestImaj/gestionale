<?php

namespace App\Exports;

use App\Models\Certificate;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CertificatesExport implements FromView
{
	public function __construct($from = 0, $to = 0, $course = 0)
	{
		$this->course = $course;
		$this->from = $from;
		$this->to = $to;

	}

	public function view() : View{
		$query = Certificate::query();
		if ($this->from !=0 && $this->to !=0){
			$query->whereBetween('created',[$this->from,$this->to]);
		}elseif ($this->from !=0){
			$query->whereDate('created','>',$this->from);
		}elseif ($this->to !=0){
			$query->whereDate('created','<=',$this->to);
		}
		if ($this->course){
			$query->whereHas('examSession',function ($q){
				$q->where('course_id',$this->course);
			});
		}
		$certificates = $query->cursor();

		return view('certificate.export',['certificates'=>$certificates]);
	}
}

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class StorehouseAdminExport implements FromView
{
  use Exportable;

	public function __construct($courses)
	{
		$this->courses = $courses;
	}

	public function view(): View
	{
		return view('struture.storehouse.admin-export',['courses'=>$this->courses]);
	}
}

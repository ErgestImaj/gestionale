<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class StructureStoreHouseExport implements FromView
{
   use Exportable;


	public function __construct($structures, $isSingle = false)
	{
		$this->structures = $structures;
		$this->isSingle = $isSingle;
	}

	public function view(): View
	{
		return view('struture.storehouse.structures-storehouse-export', [
			'structures' => $this->structures,
			'isSingle' => $this->isSingle
		]);
	}
}

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class StructureStoreHouseExport implements FromView
{
   use Exportable;

	public function __construct($type = 1, $from = null, $to = null, $structure = null)
	{
		$this->type = $type;
		$this->from = $from;
		$this->to = $to;
		$this->structure = $structure;
	}

	public function view(): View
	{
		$query = User::query();

		if (!is_null($this->from) && !is_null($this->to)) {
			$query->whereBetween('created', [$this->from, $this->to]);
		} elseif (!is_null($this->from)) {
			$query->whereDate('created', '>', $this->from);
		} elseif (!is_null($this->to)) {
			$query->whereDate('created', '<=', $this->from);
		}
		$structures = $query->whereHas('roles', function ($query) {
			$query->where('name', array_search($this->type, User::$roles));
		})->cursor();

		return view('struture.storehouse.structures-storehouse-export', ['structures' => $structures]);
	}
}

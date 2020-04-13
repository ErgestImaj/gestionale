<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
	use Exportable;

	public function __construct($type = 'superadmin', $from = null, $to = null)
	{
		$this->type = $type;
		$this->from = $from;
		$this->to = $to;

	}

	public function view(): View
	{
		$query = User::query();

		if (!is_null($this->from) && !is_null($this->to)) {
			$query->whereBetween('created', [$this->from, $this->to]);
		} elseif (!is_null($this->from)) {
			$query->whereDate('created', '>', $this->from);
		} elseif (!is_null($this->to)) {
			$query->whereDate('created', '<=', $this->to);
		}
		$users = $query->whereHas('roles', function ($query) {
			$query->where('name', array_search($this->type, User::$roles));
		})->cursor();

		return view('utenti.export', ['users' => $users]);
	}
}

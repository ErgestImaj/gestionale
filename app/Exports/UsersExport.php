<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
	use Exportable;

	public function __construct($type = 'superadmin', $from = 0, $to = 0)
	{
		$this->type = $type;
		$this->from = $from;
		$this->to = $to;

	}

	public function view(): View
	{
		$query = User::query();
		if ($this->from && $this->to) {
			$query->whereBetween('created', [$this->from, $this->to]);
		} elseif ($this->from) {
			$query->whereDate('created', '>', $this->from);
		} elseif ($this->to) {
			$query->whereDate('created', '<=', $this->to);
		}
		$users = $query->whereHas('roles', function ($query) {
			$query->where('name', array_search($this->type, User::$roles));
		})->cursor();

		return view('utenti.export', ['users' => $users]);
	}
}

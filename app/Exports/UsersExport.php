<?php

namespace App\Exports;

use App\Models\Structure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
	use Exportable;

	/**
	 * @var int
	 */

	public function __construct($type = 'superadmin', $from = 0, $to = 0, $structure=0)
	{
		$this->type = $type;
		$this->from = $from;
		$this->to = $to;
		$this->structure = $structure;
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
		if ($this->structure) {
			$structure = Structure::findByHashid($this->structure);
			$query->where('created_by', $structure->user_id);
		}
		$users = $query->whereHas('roles', function ($query) {
			$query->where('name', array_search($this->type, User::$roles));
		})->cursor();

		return view('utenti.export', ['users' => $users]);
	}
}

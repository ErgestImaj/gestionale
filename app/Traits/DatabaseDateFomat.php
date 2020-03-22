<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait DatabaseDateFomat {

	public function databaseDateFormat($date='')
	{
		if (empty($date) || $date == '0000-00-00 00:00:00' || $date == '0000-00-00') return null;
		return (new Carbon($date))->format('Y-m-d');
	}

}

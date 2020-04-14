<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectronicInvoiceSettings extends Model
{
	const MEDIAFORM = 0;
	const LRN = 1;
	const IIQ = 2;
	const DILE = 3;
	const MIUR = 4;

	protected $guarded = [];

	public function getTableColumns()
	{
		return $this
			->getConnection()
			->getSchemaBuilder()
			->getColumnListing($this->getTable());
	}
}

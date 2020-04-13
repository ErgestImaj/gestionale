<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectronicInvoiceSettings extends Model
{
	protected $guarded = [];

	public function getTableColumns()
	{
		return $this
			->getConnection()
			->getSchemaBuilder()
			->getColumnListing($this->getTable());
	}
}

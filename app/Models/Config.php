<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
	//
	public $timestamps = false;
	protected $table = 'config';
	protected $_config = array();
	protected $fillable = ['name', 'config_values'];

	protected $casts = [
		'config_values' => 'json'
	];

	public static function loadConfig($name)
	{
		return self::where('name', $name)->first();
	}

	public function getValue($field = null, $default = null)
	{
		if (!$field) return $default;
		$values = $this->config_values;

		if (!isset($values[$field])) return $default;

		return $values[$field];
	}
}

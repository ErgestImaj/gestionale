<?php


namespace App\Helpers;


use App\Models\Config;

class ConfigHelper
{

	protected  static $_config = array();

	/**
	 * @param $name
	 * @return Config
	 */
	public static function  getConfig($name = 'system')
	{
		if(!isset(static::$_config[$name]))
			self::$_config[$name] = Config::loadConfig($name);

		return self::$_config[$name];
	}

	public static function  getConfigValue($field = null,$default = null,$config = 'utilities')
	{
		return self::getConfig($config)->getValue($field,$default);
	}

	public static function getConfigValuesByName($name)
	{
		return Config::where('name', $name)->pluck('config_values')->first();
	}
}

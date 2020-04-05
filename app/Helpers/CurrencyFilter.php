<?php


namespace App\Helpers;


class CurrencyFilter
{
	public function filter($value)
	{
		$currency = 0;
		$currency_string = preg_replace('/[^0-9,\.-]/','',$value);
		$chunks = preg_split('/[,\.]/',$currency_string);

		if(count($chunks) == 1) $currency = (int) $currency_string;
		elseif(count($chunks) > 1)
		{
			$decimals = array_pop($chunks);
			$currency = floatval(implode('',$chunks) . '.' . $decimals);
		}

		return number_format($currency,2,'.','');
	}


	public function render($value)
	{
		$currency = 0;
		$currency_string = preg_replace('/[^0-9,\.-]/','',$value);
		$chunks = preg_split('/[,\.]/',$currency_string);

		if(count($chunks) == 1) $currency = (int) $currency_string;
		elseif(count($chunks) > 1)
		{
			$decimals = array_pop($chunks);
			$currency = floatval(implode('',$chunks) . '.' . $decimals);
		}

		return number_format($currency,2,',','.');
	}
}

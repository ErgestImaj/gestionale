<?php


namespace App\Helpers;


class CurrencyHelper
{
	public static function renderValue($value, $show_currency_symbol = false, $symbol_before = false)
	{
		global $mainframe;

		$decimals = 2;
		$decimal_separator = '.';
		$thousand_separator = '';
		$currency_symbol = '';
		$filter = new CurrencyFilter();

		$filtered_value = $filter->filter($value);

		$return_value = number_format($filtered_value,$decimals,$decimal_separator,$thousand_separator);

		return $show_currency_symbol && $currency_symbol ?
			$symbol_before ?
				sprintf('%s %s', $currency_symbol, $return_value)
				: sprintf('%s %s', $return_value, $currency_symbol)
			: $return_value;
	}

	public static function filterCurrency($currency)
	{
		$filter = new CurrencyFilter();
		$filtered = $filter->filter($currency);
		return $filtered;
	}
}

<?php

namespace App\Traits;

trait PaymentNameAttribute{

	public function getPaymentNameAttribute()
	{
		return static::paymentTypeName($this->payment_type);
	}

	public static function paymentTypeName($payment_type)
	{
		$paymentTypeNames = static::paymentTypeNames();
		if (isset($paymentTypeNames[$payment_type])) return $paymentTypeNames[$payment_type];

		return '';
	}

	public static function paymentTypeNames()
	{
		return array(
			self::BANK_TRANSFER => 'Bonifico/Bollettino',
			self::PAYPAL => 'Paypal',
		);
	}
}

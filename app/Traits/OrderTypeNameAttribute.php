<?php

namespace App\Traits;

trait OrderTypeNameAttribute{

	public static function typeNames()
	{
		return [
			self::TYPE_SUBSCRIPTION => 'Accreditamento struttura',
			self::TYPE_USER_VALIDATION=> 'Accreditamento utente',
			self::TYPE_PURCHASE=> 'Acquisto corsi',
			self::TYPE_CERTIFICATE_DUPLICATE_REQUEST=> 'Acquisto duplicato',
			self::TYPE_CREDIT_PACK_PURCHASE=> 'Acquisto Credit Pack',
			self::TYPE_FAST_TRACK=> 'Fast Track',
		];
	}

	public static function typeName($type){
		$typeNames = static::typeNames();
		if (isset($typeNames[$type])) return $typeNames[$type];
		return '';
	}

	public function getTypeNameAttribute(){
		return static::typeName($this->type);
	}
}

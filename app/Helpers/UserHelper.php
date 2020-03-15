<?php


namespace App\Helpers;


use App\Models\User;

class UserHelper
{
  public static function getUserRole($role){
  	$type ='';
		switch ($role){
			case User::$roles[User::STUDENTI]:
				$type = User::STUDENTI;
				break;
			case User::$roles[User::DOCENTE]:
				$type = User::DOCENTE;
				break;
			case User::$roles[User::FORMATORE]:
				$type = User::FORMATORE;
				break;
			case User::$roles[User::SUPERVISORE]:
				$type = User::SUPERVISORE;
				break;
			case User::$roles[User::ESAMINATORE]:
				$type = User::ESAMINATORE;
				break;
			case User::$roles[User::INVIGILATOR]:
				$type = User::INVIGILATOR;
				break;
			case User::$roles[User::ISPETTORI]:
				$type = User::ISPETTORI;
				break;
			case User::$roles[User::TUTOR]:
				$type = User::TUTOR;
				break;
			case User::$roles[User::ADMIN]:
				$type = User::ADMIN;
				break;
			case User::$roles[User::SEGRETERIA]:
				$type = User::SEGRETERIA;
				break;
		}
		return $type;
	}
	public static function getUserRoleLabel($role){
		$label ='';
		switch ($role){
			case User::$roles[User::STUDENTI]:
				$label = User::$roles[User::STUDENTI];
				break;
			case User::$roles[User::DOCENTE]:
				$label = User::$roles[User::DOCENTE];
				break;
			case User::$roles[User::FORMATORE]:
				$label = User::$roles[User::FORMATORE];
				break;
			case User::$roles[User::SUPERVISORE]:
				$label = User::$roles[User::SUPERVISORE];
				break;
			case User::$roles[User::ESAMINATORE]:
				$label = User::$roles[User::ESAMINATORE];
				break;
			case User::$roles[User::INVIGILATOR]:
				$label = User::$roles[User::INVIGILATOR];
				break;
			case User::$roles[User::ISPETTORI]:
				$label = User::$roles[User::ISPETTORI];
				break;
			case User::$roles[User::TUTOR]:
				$label = User::$roles[User::TUTOR];
				break;
			case User::$roles[User::ADMIN]:
				$label = User::$roles[User::ADMIN];
				break;
			case User::$roles[User::SEGRETERIA]:
				$label = User::$roles[User::SEGRETERIA];
				break;
		}
		return $label;
	}
}

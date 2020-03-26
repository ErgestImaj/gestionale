<?php

namespace App\Models;

use App\Notifications\InvitationEmailNotification;
use App\Traits\HashIdAttribute;
use App\Traits\HasRoles;
use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use App\Traits\UserRelationships;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class User extends Authenticatable
{
	use  Notifiable, UserRelationships,HasUserRelationships, HashIdAttribute, HasRoles, HasHashid, HashidRouting, SoftDeletes, HasStatus;

	const CREATED_AT = 'created';
	const UPDATED_AT = 'updated';

	const  IS_ACTIVE = 1;
	const  NOT_ACTIVE = 0;

	#user roles
	const SUPERADMIN = 'superadmin';
	const ADMIN = 'amministrazione';
	const SEGRETERIA = 'segreteria';
	const PARTNER = 'partner';
	const MASTER = 'master';
	const AFFILIATI = 'affiliati';
	const STUDENTI = 'partecipante';
	const DOCENTE = 'docente';
	const FORMATORE = 'formatore';
	const SUPERVISORE = 'supervisore';
	const ESAMINATORE = 'esaminatore';
	const INVIGILATOR = 'invigilator';
	const ISPETTORI = 'inspettore';
	const TUTOR = 'tutor';

	public static $roles = [
		self::SUPERADMIN => 'superadmin',
		self::ADMIN => 'amministrazione',
		self::SEGRETERIA => 'segreteria',
		self::PARTNER => 'partner',
		self::MASTER => 'master',
		self::AFFILIATI => 'affiliati',
		self::STUDENTI => 'studenti',
		self::DOCENTE => 'docenti',
		self::FORMATORE => 'formatori',
		self::SUPERVISORE => 'supervisori',
		self::ESAMINATORE => 'esaminatori',
		self::INVIGILATOR => 'invigilatori',
		self::ISPETTORI => 'ispettori',
		self::TUTOR => 'tutori',
	];
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'username', 'firstname', 'lastname', 'email', 'password',
		'state', 'activation', 'created_by', 'updated_by', 'locked',
		'avatar'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */


	protected $casts = [
		'email_verified_at' => 'datetime',
		'activation' => 'datetime',
		'locked' => 'datetime',
		'deleted_at' => 'datetime',
		'last_login' => 'datetime',
		'created' => 'datetime',
		'state' => 'boolean'

	];
	protected $appends = ['avatar_url', 'display_name', 'hashid'];


	/**
	 * Check if user is superadmin
	 * @return bool
	 */
	public function isSuperAdmin()
	{
		return $this->hasRole(self::SUPERADMIN);
	}

	/**
	 * Display admin name: firstname lastname.
	 *
	 * @var string
	 */
	public function getFullNameAttribute()
	{
		return $this->firstname . ' ' . $this->lastname;
	}

	public function getDisplayNameAttribute()
	{
		return $this->displayName();
	}

	public function displayName()
	{
		$names = explode(' ', $this->full_name);
		return $names[0] . " " . substr($names[1], 0, 1) . ".";
	}

	/**
	 * @return avatar url
	 */
	public function getAvatarUrlAttribute()
	{
		if ($this->avatar)
			return Storage::url('avatars/' . $this->avatar);
		return Storage::url('user-avatar.png');
	}


	/**
	 * Get image thumb path.
	 *
	 * @var string
	 */
	public function removeAvatar()
	{
		if (!empty($this->avatar)) {
			Storage::delete('public/avatars/' . $this->avatar);
		}
	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new InvitationEmailNotification($token));
	}


}

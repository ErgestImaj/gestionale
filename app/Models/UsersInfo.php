<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersInfo extends Model
{
    //
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

		#types
		const TYPE_MF = 0;
		const TYPE_LRN = 1;
		const TYPE_IIQ = 2;
		const TYPE_DILE = 3;
		const TYPE_MIUR = 4;

		public static $typeLabels = [
			self::TYPE_MF => 'MF',
			self::TYPE_LRN => 'LRN',
			self::TYPE_DILE => 'DILE',
			self::TYPE_IIQ => 'IIQ',
			self::TYPE_MIUR => 'MIUR',
		];
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'users_userinfo';

    public $appends = [
    	'type'
		];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dirth_date'                  => 'datetime',
        'document_expire_date'        => 'datetime',
        'high_school_diploma_date'    => 'datetime',
        'university_degree_date'      => 'datetime',
        'locked'                      => 'datetime',
        'state'                       => 'boolean'

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getTypeAttribute(){
         return self::$typeLabels[$this->lrn_user];
		}
}

<?php

namespace App\Models;

use App\Models\Locations\Countries;
use App\Models\Locations\Provinces;
use App\Models\Locations\Regions;
use App\Models\Locations\Towns;
use App\Traits\DatabaseDateFomat;
use App\Traits\HasContentPath;
use App\Traits\HashIdAttribute;
use App\Traits\HasStatus;
use App\Traits\HasUserRelationships;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Mtvs\EloquentHashids\HasHashid;
use Mtvs\EloquentHashids\HashidRouting;

class UsersInfo extends Model
{
	 use HasStatus,DatabaseDateFomat,HashIdAttribute,HasHashid,HasContentPath,HashidRouting,HasUserRelationships,SoftDeletes;
    //
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

		const  IS_ACTIVE = 1;
		const  NOT_ACTIVE = 0;

	  const CONTENT_PATH = 'user_userinfo';

		const IS_NOT_EDITABLE = 0;
		const IS_EDITABLE = 1;

		const GENDER_M = 'M';
		const GENDER_F = 'F';

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
    	'types','hashid','content_path'
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
        'birth_date'                  => 'datetime',
        'document_expire_date'        => 'datetime',
        'high_school_diploma_date'    => 'datetime',
        'university_degree_date'      => 'datetime',
        'locked'                      => 'datetime',
        'state'                       => 'boolean'

    ];
     protected static function boot()
		 {
			 parent::boot();
			 self::creating(function($model){
				  $model->created_by = Auth::id();
				  $model->english_level = 0;
				  $model->english_level_declaration = 0;
				  $model->state = self::IS_ACTIVE;
			 });
		 }
	public function getBirthDateAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
	public function getDocumentExpireDateAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
	public function getHighSchoolDiplomaDateAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
	public function getUniversityDegreeDateAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}
	public function getLockedAttribute($val)
	{
		return $this->databaseDateFormat($val);
	}


	/**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(){
        return $this->belongsTo(User::class,'user_id');
    }
		/**
		 * @return \Illuminate\Database\Eloquent\Relations\HasOne
		 */
		public function structure()
		{
			return $this->belongsTo(Structure::class, 'structure_id');
		}
		public function birthPlace(){
			return $this->belongsTo(Towns::class,'birth_place','id');
		}
		public function userNationality(){
			return $this->belongsTo(Countries::class,'nationality','id');
		}
		public function userCountry(){
			return $this->belongsTo(Countries::class,'country','id');
		}
		public function userRegion(){
			return $this->belongsTo(Regions::class,'region','id');
		}
		public function userSchoolRegion(){
			return $this->belongsTo(Regions::class,'school_region','id');
		}
		public function userProv(){
			return $this->belongsTo(Provinces::class,'prov','id');
		}
		public function userTown(){
			return $this->belongsTo(Towns::class,'town','id');
		}
		public function userEducation(){
			return $this->belongsTo(Educations::class,'education','id');
		}
		public function job(){
			return $this->belongsTo(Job::class,'employment','id');
		}
		public function documentType(){
			return $this->belongsTo(DocumentType::class,'document_type','id');
		}
    public function getTypesAttribute(){
         return self::$typeLabels[$this->lrn_user];
		}
		public function scopeType($query,$type){
			return $query->where('lrn_user',$type);
		}

}

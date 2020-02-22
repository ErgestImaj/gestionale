<?php
namespace App\Traits;

use App\Models\Category;
use App\Models\Course;
use App\Models\DocumentCategories;
use App\Models\MassMailHistory;
use App\Models\Structure;
use App\Models\UsersInfo;

trait UserRelationships{

    /**
     * @return mixed
     */
    public function categories(){
        return $this->hasMany(Category::class,'created_by');
    }
    /**
     * @return mixed
     */
    public function documentcategories(){
        return $this->hasMany(DocumentCategories::class,'created_by');
    }
    /**
     * @return mixed
     */
    public function courses(){
        return $this->hasMany(Course::class,'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo(){
        return $this->hasOne(UsersInfo::class);
    }

    public function massMailsHistories(){
        return $this->hasMany(MassMailHistory::class);
    }

    public function structure(){
    	return $this->hasOne(Structure::class,'user_id');
    }
}

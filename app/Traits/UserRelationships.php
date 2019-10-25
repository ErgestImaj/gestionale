<?php
namespace App\Traits;

use App\Models\Category;
use App\Models\Course;
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
    public function courses(){
        return $this->hasMany(Course::class,'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo(){
        return $this->hasOne(UsersInfo::class);
    }
}

<?php
namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait HasStatus {


    /**
     * get object status
     * @return bool
     */
    public function isActive(){
        return $this->state == self::IS_ACTIVE;
    }

    /**
     * disable object
     * @return int
     */
    public function disable(){
        $this->locked = Carbon::now()->toDateTimeString();
        $this->locked_by = Auth::id();
        $this->state = self::NOT_ACTIVE;
        return $this->update();
    }

    /**
     * enable object
     * @return int
     */
    public function enable(){
        $this->state = self::IS_ACTIVE;
        return $this->update();
    }

    public function scopeActive($query,$state = self::IS_ACTIVE){
    	return $query->where('state',$state);
		}

}

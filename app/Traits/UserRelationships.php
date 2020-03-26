<?php
namespace App\Traits;

use App\Models\Category;
use App\Models\Course;
use App\Models\DocumentCategories;
use App\Models\Exams\LrnExamSession;
use App\Models\Exams\MediaformExamSession;
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

    public function userCourses(){
    	return $this->belongsToMany(Course::class,'course_user','user_id','course_id');
		}
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo(){
        return $this->hasOne(UsersInfo::class,'user_id','id');
    }


    public function massMailsHistories(){
        return $this->hasMany(MassMailHistory::class);
    }

		/**
		 * @return mixed
		 */
		public function structure(){
	      return $this->hasOne(Structure::class,'user_id');
	  }

	  public function examinerLrnExam(){
			return $this->hasMany(LrnExamSession::class,'examiner_id');
		}

		public function invigilatorLrnExam(){
			return $this->hasMany(LrnExamSession::class,'invigilator_id');
		}

		public function lrnexams(){
			return $this->belongsToMany(LrnExamSession::class,'utilities_lrn_exam_session_partecipants','lrn_exam_session_id','user_id')->withPivot();
		}

		public function examinerMfExam(){
			return $this->hasMany(MediaformExamSession::class,'examiner_id');
		}

		public function supervisorMfExam(){
			return $this->hasMany(MediaformExamSession::class,'supervisor_id');
		}
		public function formerMfExam(){
			return $this->hasMany(MediaformExamSession::class,'former_id');
		}

		public function mfexams(){
			return $this->belongsToMany(MediaformExamSession::class,'utilities_exam_session_partecipants','exam_session_id','user_id')->withPivot();
		}
}

<?php
namespace App\Traits;

use App\Models\Cart\CourseTransactions;
use App\Models\Cart\Orders;
use App\Models\Cart\FastTrack;
use App\Models\Category;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\DocumentCategories;
use App\Models\ElectronicInvoiceSettings;
use App\Models\Exams\LrnExamSession;
use App\Models\Exams\MediaformExamSession;
use App\Models\MassMailHistory;
use App\Models\Structure;
use App\Models\Tracking;
use App\Models\UsersInfo;
use App\Models\UserStatus;

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
			return $this->belongsToMany(LrnExamSession::class,'utilities_lrn_exam_session_partecipants','user_id','lrn_exam_session_id')->withPivot();
		}

		public function lrnExamSessions(){
			return $this->hasMany(LrnExamSession::class,'user_id');
		}
		public function mfExamSessions(){
			return $this->hasMany(MediaformExamSession::class,'user_id');
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
			return $this->belongsToMany(MediaformExamSession::class,'utilities_exam_session_partecipants','user_id','exam_session_id')->withPivot();
		}

		public function fastTracks(){
			return $this->hasMany(FastTrack::class,'user_id');
		}

		public function electronicInvoice(){
			return $this->hasMany(FastTrack::class,'user_id');
		}

		public function cartCourseTransactions(){
			return $this->hasMany(CourseTransactions::class,'user_id','id');
		}
	public function orders(){
		return $this->hasMany(Orders::class,'user_id','id');
	}
	public function tracking(){
			return $this->hasMany(Tracking::class,'user_id','id');
	}
	public function certificate(){
			return $this->hasMany(Certificate::class,'user_id');
	}
	public function userStatus(){
			return $this->hasOne(UserStatus::class,'user_id','id');
	}
	public function electroniceInvoiceSettings(){
			return $this->hasMany(ElectronicInvoiceSettings::class,'user_id','id');
	}
}

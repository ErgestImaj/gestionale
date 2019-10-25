<?php

namespace App\Observers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseObserver
{
    /**
     * Handle the user "creating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(Course $course)
    {
        //
        $course->language_level_id = null;
        $course->min_order = 0;
        $course->url = 0;
        $course->created_by = Auth::id();
        $course->password = 1;
        $course->state = 1;

    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function saving(Course $course)
    {
        $course->updated_by = Auth::id();
    }
}

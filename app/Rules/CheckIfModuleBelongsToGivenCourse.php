<?php

namespace App\Rules;

use App\Models\Course;
use Illuminate\Contracts\Validation\Rule;

class CheckIfModuleBelongsToGivenCourse implements Rule
{
    /**
     * @var
     */
    private $course;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($course)
    {
        if ($course !=null) $this->course = $course;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

       if($this->course != null){
           $course = Course::find($this->course);
           $ids = $course->modules->pluck('id')->toArray();
           if( in_array($value,$ids)) return true;
       }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.module_course');
    }
}

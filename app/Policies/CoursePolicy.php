<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any courses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->hasRole(User::ADMIN);
    }

    /**
     * Determine whether the user can view the course.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function view(User $user, Course $course)
    {

        return $user->hasRole(User::ADMIN);
    }

    /**
     * Determine whether the user can create courses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole(User::ADMIN);
    }

    /**
     * Determine whether the user can update the course.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function update(User $user, Course $course)
    {
        return $user->hasRole(User::ADMIN);
    }

    /**
     * Determine whether the user can delete the course.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function delete(User $user, Course $course)
    {
        //
    }

    /**
     * Determine whether the user can restore the course.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function restore(User $user, Course $course)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the course.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Course  $course
     * @return mixed
     */
    public function forceDelete(User $user, Course $course)
    {
        //
    }

    /**
     * If superadmin return true
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability){
        if ($user->isSuperAdmin()){
            return true;
        }
    }
}

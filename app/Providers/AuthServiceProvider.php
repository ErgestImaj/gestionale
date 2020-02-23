<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Structure;
use App\Policies\CoursePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\User'      => 'App\Policies\AdminPolicy',
         'App\Models\Course'    => 'App\Policies\CoursePolicy',
         'App\Models\Structure' => 'App\Policies\StructurePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

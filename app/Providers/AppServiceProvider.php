<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Structure;
use App\Models\User;
use App\Observers\CourseObserver;
use App\Observers\StructureObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Course::observe(CourseObserver::class);
        Structure::observe(StructureObserver::class);
    }
}

<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasrole', function ($role) {
            return auth()->check() && auth()->user()->hasRole($role);
        });

        Blade::if('exam', function ($type) {
           	if (auth()->user()->isSuperAdmin() || auth()->user()->hasRole(User::ADMIN)) {
           		return true;
						}elseif (auth()->user()->hasRole(User::PARTNER) || auth()->user()->hasRole(User::MASTER)||auth()->user()->hasRole(User::AFFILIATI)){
           		return auth()->user()->structure->checkExamAccess($type);
						}
           	return false;
        });

        Blade::if('hasanyrole', function ($roles) {
            $roles = explode('|', $roles);
            return  auth()->check() && auth()->user()->hasAnyRole($roles);
        });

        Blade::directive('convert_to_percent', function ($value) {
            return "<?php echo $value . '%'; ?>";
        });

    }
}

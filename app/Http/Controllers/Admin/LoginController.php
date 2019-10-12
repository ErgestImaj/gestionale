<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\RedirectUsersToDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use RedirectUsersToDashboard;

    /**
     * Login as specific user user
     * @param User $user
     */
    public function loginAsUser(User $user){
        Session::put( 'superadmin_user', Auth::id() );

        Auth::login( $user );

        return redirect(
            $this->redirect_user_to_specific_dashboard(
                $user->getUserRole()
            )
        );

    }

    public function reLoginAsAdmin(){

        $user_id = \session('superadmin_user');
        Auth::loginUsingId($user_id);
        session()->forget('superadmin_user');
        return redirect()->route('admin.home');
    }
}

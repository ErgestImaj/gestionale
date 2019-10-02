<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
   // protected $redirectTo = '/home';
    public function redirectTo(){

        $role = auth()->user()->getUserRole();

        switch (strtolower($role)) {
            case 'amministrazione':
                return 'amministrazione/dashboard';
                break;
            case 'partner':
                return 'partner/dashboard';
                break;
            case 'master':
                return 'master/dashboard';
                break;
            case 'affiliati':
                return 'affiliati/dashboard';
                break;
            case 'partecipante':
                return 'partecipante/dashboard';
                break;
            case 'esaminatore':
                return 'esaminatore/dashboard';
                break;
            case 'docente':
                return 'docente/dashboard';
                break;
            case 'formatore':
                return 'formatore/dashboard';
                break;
            case 'supervisore':
                return 'supervisore/dashboard';
                break;
            case 'rappresentante legale':
                return 'rappresentante-legale/dashboard';
                break;
            case 'invigilator':
                return 'invigilator/dashboard';
                break;
            case 'manager':
                return 'manager/dashboard';
                break;
            default:
                return '/login';
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = $this->findUsername();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        //update old passwords from md5  to bycrypt

        $user = User::where('email', $request->input('login'))->orWhere('username', $request->input('login'))->first();

        if ($user && !$user->change_password) {
            if (md5($request->input('password')) === $user->password) {
                $user->password = Hash::make($request->input('password'));
                $user->change_password = 1;
                $user->save();
            } else {

                return $this->sendLoginResponse($request);
            }
        }


        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}

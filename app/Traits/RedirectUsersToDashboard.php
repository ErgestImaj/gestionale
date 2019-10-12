<?php
namespace  App\Traits;

use App\Models\User;

trait  RedirectUsersToDashboard{

    /**
     * Redirect users to dashboard specific path
     *
     * @param $role
     * @return string
     */
    public function redirect_user_to_specific_dashboard($role){

        switch (strtolower($role)) {
            case User::SUPERADMIN:
                return 'amministrazione/dashboard';
                break;
            case User::ADMIN:
                return 'amministrazione/dashboard';
                break;
            case User::SEGRETERIA:
                return 'segreteria/dashboard';
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
}

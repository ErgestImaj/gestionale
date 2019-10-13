<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserGroups;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    public function permissionSettings(){

        $usergroups = UserGroups::with('usersCount')->orderBy('name')->cursor();

        return view('superadmin.settings.permission',
                           [
                               'usergroups'=>$usergroups
                           ]
        );
    }

    public function changeGroupStatus(UserGroups $userGroups){
        $userGroups->isActive() ? $userGroups->disableGroup() : $userGroups->activeGroup();
        if ($userGroups->update()){
            toastr()->success(trans('messages.change_status'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();
    }

    public function maintenance(){
        $mode = config('maintenance.maintenace_mode');

        return view('superadmin.settings.maintenance',[
             'mode'=>$mode
        ]);
    }

    public function setMaintenaceMode(Request $request){

        setEnvironmentValue( [
            'MAINTENANCE_MODE' => $request->input('status') == 'on' ? 1 : 0,
        ] );

        toastr()->success(trans('messages.change_status'));
        return back();

    }
}

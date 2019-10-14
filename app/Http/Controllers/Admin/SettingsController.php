<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UtilitiesRequest;
use App\Models\Config;
use App\Models\UserGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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

    public function emailSettings(){
        $config = Config::where('name', 'utilities')->pluck('config_values')->first();

        return view('superadmin.settings.emails',[
            'config'=>$config
        ]);
    }
    public function updateEmailSettings(UtilitiesRequest $request,$key){

        if ($key !='utilities'){
            toastr()->error(trans('messages.error'));
            return back();
        }

        $utilities  = Config::where('name', 'utilities')->firstOrFail();
        $data_array = $utilities->config_values;
        $filtered = Arr::set(  $data_array, 'lrn_email',  $request->input('lrn_email'));
        $filtered = Arr::set(  $filtered, 'lrn_email_cc',  $request->input('lrn_email_cc'));
        $filtered = Arr::set(  $filtered, 'support_email',  $request->input('support_email'));

        $utilities->config_values = $filtered;
        if ( $utilities->push()){
            toastr()->success(trans('messages.success'));
            return back();
        }
        toastr()->error(trans('messages.error'));
        return back();


    }
}

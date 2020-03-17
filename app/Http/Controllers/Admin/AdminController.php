<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\MediaformUsersRequest;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{

    public function updateStatus(User $user){

        if (!auth()->user()->can('update',$user)) {
            return response( [
                'status' => 'unauthorized',
                'msg'    => trans('messages.unauthorized')
            ] );

        }
        $user->isActive() ? $user->disable() : $user->enable();

        return response( [
            'status' => 'success',
            'msg'    => trans('messages.change_status')
        ] );



    }

}

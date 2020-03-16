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

    /**
     * Show the form for editing the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (!auth()->user()->can('edit',$user)) {
            toastr()->error(trans('messages.unauthorized'));
            return back();
        }

        //update is done in Profile controller
          return view('superadmin.employee.admin.edit',compact('user'));
    }


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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
            $user->delete();
            return response( [
                'status' => 'success',
                'msg'    => trans('messages.delete_msg',['record'=>trans('menu.user')])
            ] );

    }

    /**
     * List all segreteria users
     * @return \Illuminate\Http\Response
     */
    public function segreteria(){
        return $this->index(User::SEGRETERIA);
    }
    /**
     * Store segreteria users
     * @return \Illuminate\Http\Response
     */
    public function storeSegreteria(MediaformUsersRequest $request){
        return $this->store($request,User::SEGRETERIA,'admin.segreteria.index');
    }
}

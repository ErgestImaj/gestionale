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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role = User::ADMIN)
    {

        $admins = User::whereHas('roles',function ($query) use ($role){
            $query->where('name',$role);
        })->get();

        $datatable = DataTables::of( $admins )
            ->addIndexColumn()
            ->addColumn( 'username', function ($row )
            {
                return $row->username;
            } )
            ->addColumn( 'first_name', function ( $row )
            {
                return ucwords( $row->firstname );
            } )
            ->addColumn( 'last_name', function ( $row )
            {
                return ucwords( $row->lastname );
            } )
            ->addColumn( 'email', function ( $row )
            {
                return $row->email;
            } )
            ->addColumn( 'status', function ( $row )
            {
                return $row->isActive() ? '<span class="badge badge-success">'.trans('form.active').'</span>'
                    : '<span class="badge badge-secondary">'.trans('form.disabled').'</span>';
            } )
            ->addColumn( 'last_login', function ( $row )
            {
                return format_date($row->last_login);
            } )
            ->addColumn( 'created', function ( $row )
            {
                return format_date($row->created);
            } )
            ->addColumn( 'actions', function ( $row )
            {
                $html =' <a class="action btn block-btn btn-success mb-1" data-tooltip="'.trans('messages.login_as').'" href="'.route('admin.loginasuser',['user'=>$row->hashid()]).' ">
                                <i class="fas fa-random"></i>
                          </a>
                          <a class=" action btn block-btn btn-dark mb-1" data-tooltip="'.trans('headers.edit_user').'" href="'.route('admin.admins.edit',['user'=>$row->hashid()]).'">
                               <i class="fas fa-pencil-alt"></i>
                          </a>';
                $html .= '
                          <div class="btn-group mb-1">
                            <button type="button" class="btn block-btn dropdown-toggle" data-toggle="dropdown"><span class="caret ml-0"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">

                                    <li>
                                      <a class="d-block update-btn btn-link page-link" href="#" data-action="'.route('admin.users.status',['user'=>$row->hashid()]).'">';
                                         if ($row->isActive()):
                                             $html .='  <i class="fas fa-times"></i>'.trans('messages.disable');
                                         else:
                                             $html .='  <i class="fas fa-ticket-alt"></i>'.trans('messages.active');
                                        endif;

                                       $html .=' </a>
                                                </li>

                                                <li>
                                                    <a class="d-block post-action btn-link page-link" data-content="'.trans('messages.send_reset_link_confirm').'"  data-action="'.route('admin.invitation',['user'=>$row->hashid()]).'" href="#">
                                                       <i class="fas fa-paper-plane"></i>'.trans('messages.send_reset_link').'
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="d-block sender-email btn-link page-link"  data-action="'.route('admin.emailtosingleuser',['user'=>$row->hashid()]).'" href="#">
                                                       <i class="fas fa-envelope"></i>'.trans('messages.send_email').'
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="d-block delete-btn btn-link page-link" data-content="'.trans('messages.delete_confirm',['record'=>trans('menu.user')]).'" data-action="'.route('superadmin.admins.destroy',['user'=>$row->hashid()]).'" href="#">
                                                       <i class="fas fa-trash-alt"></i>'.trans('form.delete').'
                                                    </a>
                                                </li>
                                        </ul>
                                    </div>';


                return $html;
            } )
            ->rawColumns( ['actions','status'] )
            ->make( true );

        return  $datatable;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MediaformUsersRequest $request, $role = User::ADMIN, $redirect = 'superadmin.admins.index')
    {
        $avatar='';
        if ($request->hasFile('image')) {
            if ($request->file('image')->isValid()) {
                $upload = new Upload();
                $avatar = $upload->upload($request->file('image'), 'public/avatars')->resize(100, 100)->getData();
                $avatar = $avatar['basename'];
            }
        }

        $user = User::forceCreate([
            'firstname'   => $request->input('first_name'),
            'lastname'    => $request->input('last_name'),
            'email'       => $request->input('email'),
            'password'    => Hash::make($request->input('password')),
            'avatar'      => $avatar
        ]);

        if($user){
            $user->roles()->sync(UserGroups::where('name', $role)->firstOrFail()->id);
            toastr()->success(trans('messages.success'));
            return redirect()->route($redirect);
        }

        toastr()->error(trans('messages.error'));

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailToSingleUserRequest;
use App\Http\Requests\MassMailRequest;
use App\Mail\SendEmailToSingleUser;
use App\Models\MassMailHistory;
use App\Models\User;
use App\Models\UserGroups;
use App\Notifications\InvitationEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use Yajra\DataTables\DataTables;

class EmailsController extends Controller
{
    //

    /**
     * Send invitation link to user, with reset password
     * User has to reset his password before login
     *
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function sendInvitationLink(User $user){

       if (auth()->user()->hasAnyRole([User::SUPERADMIN,User::ADMIN])){
           $token = Password::broker()->createToken($user);
           $user->sendPasswordResetNotification($token);
           return response( [
               'status' => 'success',
               'msg'    => 'Email inviato con successo'
           ] );
       }

    }

    public function sendEmailToUser(MailToSingleUserRequest $request, User $user){

        Mail::send(new SendEmailToSingleUser(
                       auth()->user(),
                       $user,
                       $request->input('soggetto'),
                       $request->input('descrizione'),
                       $request->input('cc_email'),
                       $request->input('bcc_email')
                   ));

        return response( [
            'status' => 'success',
            'msg'    => 'Email inviato con successo'
        ] );

    }

    /*
     * View of mass emails
     */
    public function massEmail(){

        return view('superadmin.messages.index')->with([
            'logs'=>MassMailHistory::paginate(20),
            'roles'=>UserGroups::all(),
            'emails'=>User::all(['email'])
        ]);
    }

    public function massEmailApi(){
        $logs = MassMailHistory::all();

        $datatable = DataTables::of(  $logs  )
                               ->addIndexColumn()
                               ->addColumn( 'subject', function ($row )
                               {
                                   return $row->subject;
                               } )
                               ->addColumn( 'description', function ( $row )
                               {
                                   return  $row->description;
                               } )
                               ->addColumn( 'target', function ( $row )
                               {
                                   return ucwords( $row->send_to );
                               } )
                               ->addColumn( 'exclude', function ( $row )
                               {
                                   return $row->exclude;
                               } )
                               ->addColumn( 'created', function ( $row )
                               {
                                   return format_date($row->created_at);
                               } )
                                ->addColumn( 'created_by', function ( $row )
                                {
                                    return optional($row->user)->displayName();
                                } )
                               ->addColumn( 'actions', function ( $row )
                               {
                                   $html ='<a class="delete-btn py-2 px-3 btn block-btn btn-danger" data-content="'.trans('messages.delete_confirm',['record'=>'email']).'" data-action="'.route('admin.deletemassemail',['log'=>$row->hashid()]).'" href="#">
                                                       <i class="fas fa-trash-alt"></i> </a>';

                                   return $html;
                               } )
                               ->rawColumns( ['actions','description'] )
                               ->make( true );

        return  $datatable;
    }

    /*
     * Save and Send Mass Emails
     */
    public function sendMassEmail(MassMailRequest $request){
        $logs = new MassMailHistory();
        $logs->fill($request->fillFormData());
        try {
            $logs->save();
            toastr()->success(trans('messages.success'));
            return back();
        }catch (\Exception $exception){
            logger($exception->getMessage());
            toastr()->error(trans('messages.error'));
            return back();
        }
    }

    public function deleteMassEmail(MassMailHistory $log){
        $log->delete();
        return response( [
            'status' => 'success',
            'msg'    => trans('messages.delete_msg',['record'=>'email'])
        ] );
    }
}

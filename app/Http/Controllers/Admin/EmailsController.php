<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailToSingleUserRequest;
use App\Http\Requests\MassMailRequest;
use App\Mail\SendEmailToSingleUser;
use App\Models\Category;
use App\Models\MassMailHistory;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
            'emails'=>User::all(['email'])
        ]);
    }
     public function getRoles(){

        return UserGroups::all(['id', 'name']);

     }

     public function getEmails(Request $request){

        return User::where('email','LIKE','%'.strtolower($request->email).'%')->get('email');

     }
    public function massEmailApi(){

        $logs = MassMailHistory::latest()->get();
		  	$logs_filtred = $logs->filter(function ( $log) {
				$log->description =Str::limit($log->description,20,'...');
					$names = '';
					foreach ($log->types as $type) {
						if ($type == Category::MEDIAFORM){
							$names .= 'MF, ';
						}	elseif ($type == Category::LRN){
							$names .= 'LRN, ';
						}elseif ($type == Category::MIUR){
							$names .= 'MIUR, ';
						}elseif ($type == Category::IIQ){
							$names .= 'IIQ, ';
						}elseif ($type == Category::DILE){
							$names .= 'DILE, ';
						}

					}
					$log->target = implode(', ',$log->send_to);
				$log->types = Str::replaceLast(',', '', $names);
				$log->created =format_date($log->created_at);
				$log->created_by =optional($log->user)->displayName();
				$log->remlink = route('admin.deletemassemail',$log->hashid());
				$log->remMessage = trans('messages.delete_confirm', ['record' => 'email']);
				return $log;
			});

        return $logs_filtred->values()->toJson();
    }

    /*
     * Save and Send Mass Emails
     *  TO DO: MODIFY if user belogs to type
     */
    public function sendMassEmail(MassMailRequest $request){
        $roles =$request->input('target');
        $emails = [];
        if ($request->exists('exclude')){
            $emails =$request->input('exclude');
        }

        //get users by role
       foreach($roles as $role){
           $users = User::whereHas('roles',function($query) use($role){
               $query->where('name',$role);
           })->get();
          if (empty($users)) continue;

           foreach ( $users as $user ) {
               //exclude users
              if (is_array($emails) && !empty($emails)){
                  if (in_array($user->email,$emails)) continue;
              }
               try {
                   Mail::send(new SendEmailToSingleUser(
                       auth()->user(),
                       $user,
                       $request->input('subject'),
                       $request->input('description')
                   ));
               }catch (\Exception $exception){
                  logger($exception->getMessage());
               }

           }
       }
        $logs = new MassMailHistory();
        $logs->fill($request->fillFormData());
      try {
            $logs->save();
              return response( [
                  'status' => 'success',
                  'msg'    => trans('messages.success')
              ] );
        }catch (\Exception $exception){
            logger($exception->getMessage());
          return response( [
              'status' => 'error',
              'msg'    => trans('messages.error')
          ] );
        }
    }

    public function deleteMassEmail(MassMailHistory $log){
        try {
            $log->delete();
            return response( [
                'status' => 'success',
                'msg'    => trans('messages.delete_msg',['record'=>'email'])
            ] );
        }catch (\Exception $exception){
            return response( [
                'status' => 'error',
                'msg'    => trans('messages.error')
            ] );
        }
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailToSingleUserRequest;
use App\Mail\SendEmailToSingleUser;
use App\Models\User;
use App\Notifications\InvitationEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

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
}

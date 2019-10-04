<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\InvitationEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class EmailsController extends Controller
{
    //

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
}

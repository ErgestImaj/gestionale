<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\Upload;
use App\Http\Controllers\Controller;
use App\Http\Requests\MediaformUsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    /**
     * @return user data
     */
    public function index(){

        $user = auth()->user();

        return view('profile.profile',compact('user'));
    }

    /**
     * @param MediaformUsersRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MediaformUsersRequest $request, User $user){


        if (!auth()->user()->can('update',$user)) {
            toastr()->error('Non sei autorizzato per questa azione!');
            return back();
        }



         $user->firstname = $request->first_name;
         $user->lastname  = $request->last_name;
         $user->email     = $request->email;

         if ($request->hasFile('image')) {
             if ($request->file('image')->isValid()) {
                 $user->removeAvatar();
                 $upload = new Upload();
                 $avatar = $upload->upload($request->file('image'), 'public/avatars')->resize(100, 100)->getData();
                 $user->avatar = $avatar['basename'];
            }
         }
         if ($request->password !='')
             $user->password = Hash::make($request->password);

        if($user->update()){
            toastr()->success('I dati sono stati salvati correttamente!');
            return back();
        }

         toastr()->error('Si è verificato un errore, riprova più tardi.');

         return back();


     }
}

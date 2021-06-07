<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);// return model for user data
        return $user->profile;
    }


    public function profile(Request $request, $id){
        $user = User::findOrFail($id);
        $profile = $user->profile()->create([]);

        $profile = new Profile();

        $profile->user()->associate($user);
        $profile->save();
         //  update profiles set user_id = $user->id WHERE id = $profile->id ;

        $profile->user()->disassociate();
        $profile->save();
        //  update profiles set user_id = null WHERE id = $profile->id ;

    }
}

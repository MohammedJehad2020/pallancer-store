<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);// return model for user data
        return $user->profile;
    }
}

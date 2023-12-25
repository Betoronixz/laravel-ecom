<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{ 
    public function login(Request $req)
    {
        $user = User::where("email", $req->email)->first();

        if ($user) {
            // User found, now check the password
            if (Hash::check($req->password, $user->password)) {
                session()->put("user",$user->name);
                return "You are logged in $user->name";
            } else {
                return "Wrong password";
            }
        } else {
            // User not found
            return "User not found";
        }
    }
 
}

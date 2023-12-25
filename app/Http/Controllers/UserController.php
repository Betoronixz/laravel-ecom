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
            if (Hash::check($req->password, $user->password)) {
                session()->put("user", $user);
                return redirect("/");
            } else {
                return "Wrong password";
            }
        } else {
            return "User not found";
        }
    }
}

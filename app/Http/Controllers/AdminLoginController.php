<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validaror,Auth;

class AdminLoginController extends Controller
{
    public function authenticate(Request $request){
        $this->validate($request,[
            "email"=>"required|email",
            "password"=>"required"
        ]);
        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect("admin/dashboard");
        }else{
            session()->flash("error","Wrong Credentials");
            return back()->withInput($request->only("email"));
        }

    }
}

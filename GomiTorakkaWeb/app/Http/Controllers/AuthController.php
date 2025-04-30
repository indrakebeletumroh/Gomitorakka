<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function form_register(){
        return view('/register');
    }

    function submit(Request $request){
        $users = new users();
        $users->username = $request->username;
        $users->phone_number = $request->phone_number;
        $users->email = $request->email;
        $users->password = Hash::make($request->password);
        
        $users->save();

        return redirect()->route('form_login.tampil');
    }

    function form_login() {
        return view('login');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function index(){

        return view('auth.login');
    }

    public function proses_login(Request $request){


        $request->validate([
            "username"=>"required",
            "password"=>"required",
        ]);

        $credentials = $request->only('username', 'password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            return redirect('/');
        }

        $notification['notif_type'] = 'warning';
        $notification['notif_message'] = 'NIK/NIP Dan Password Salah';
        return redirect()->back()->with($notification);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
// use Illuminate\Foundation\Auth\User as Authenticatable;

class Users extends Controller{
    public function register(){
        return view('register');
    }
    public function storeUser(Request $request){
        // dd($request);
        $formFields = $request->validate([
            'name' => 'required|min:5',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed|between:8,255'
        ]);
        $formFields['password'] = bcrypt($formFields['password']);
        $user = User::create($formFields);
        return redirect('login');
    }

    public function login(){
        return view('login');
    }

    public function logincheck(Request $request){
        $formFields = $request->validate([
            'email' => 'email|required',
            'password' => 'required|between:8,255'
        ]);
        
        // dd(Auth());
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('listings');
        }
        return redirect('login')->withErrors([
            'login' => 'Invalid Login Process.'
        ])->onlyInput('email');
    }
    public function logout(){
        return redirect('login')->with(Auth::logout());
    }

}


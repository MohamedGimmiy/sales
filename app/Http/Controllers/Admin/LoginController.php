<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginView()
    {
        return view('admin\auth\login');
    }
    public function login(LoginRequest $request)
    {
        if(auth()->guard('admin')->attempt(['username'=>$request->input('username'),
         'password'=>$request->input('password')])){
            return redirect()->route('admin.dashboard');
         }

    }
    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.showLogin');
    }
/*
    public function makeNewAdmin()
    {
        $admin = new App\Models\Admin();
        $admin->name = 'admin';
        $admin->email = 'test@test.com';
        $admin->username = 'admin';
        $admin->password = Hash::make('admin');
        $admin->com_code = 1;
        $admin->save();
    }
    */
}

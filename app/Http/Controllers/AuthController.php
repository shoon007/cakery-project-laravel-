<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    //CUSTOM LOGOUT
    public function logout()
    {
        //logout user
        auth()->logout();
        // redirect to homepage
        return redirect('/');
    }

    //error page
    public function errorPage()
    {
        return view('errors.404');
    }

    //login page
    public function loginPage()
    {
        return view('layouts.loginPage');
    }

    //register page
    public function registerPage()
    {
        return view('layouts.registerPage');
    }
}

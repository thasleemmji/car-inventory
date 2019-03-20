<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller {
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function index() {
        return view('auth.login');
    }
    
    public function authenticate(Request $request) {
        $login = htmlspecialchars($request->login);
        $password = htmlspecialchars($request->password);

        if($login=='' || $password=='') {
            return redirect()->back()->with('update_error', "Enter both credentials");
        }
        if(filter_var($login, FILTER_VALIDATE_EMAIL)){
            $field = 'email';
        }else {
            $field = 'username';
        }

        //autherize function
        if (Auth::attempt([$field => $login, 'password' => $password])) {//auth success
            if(Auth::user()->status!=1) {//check if the user is blocked or not
                Auth::logout();
                return redirect('/')->with('update_error', "You are blocked by the admin. Kindly contact the support +91 x xxx xxxx");
            }
            return redirect()->intended('dashboard')->with('update_success', 'Welcome, '.ucwords(Auth::user()->name));
        }else {
            return redirect()->back()->with('update_error', "Credentials doesn't match");
        }
    }

    public function logout() {
        Auth::logout();
        return redirect('/')->with('update_success', "Logged out Successfully");
    }
}
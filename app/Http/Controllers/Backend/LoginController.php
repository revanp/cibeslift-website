<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $input = $request->all();

        $remember = !empty($input['remember']) ? true : false;

        $credentials = $request->only('email', 'password');
        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password'],], $remember)) {
            return redirect()->intended('/')->with(['success' => 'You have been successfully logged in']);
        }

        return redirect()->back()->with(['error' => 'Wrong password, please try again']);
    }
}

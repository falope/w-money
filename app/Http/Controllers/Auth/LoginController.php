<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function show()
    {
        return view('dashboard.login');
    }

    public function login(LoginUserRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'])) {
            return redirect()->route('dashboard');
        }
        return redirect()->route('login')->with('error', 'Invalid login credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerate(true);
        return redirect()->route('login')->with('success', 'You have successfully logged out');
    }
}

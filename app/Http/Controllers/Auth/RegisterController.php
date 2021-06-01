<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\User\CreateUserRequest;

class RegisterController extends Controller
{
    public function show()
    {
        return view('dashboard.register');
    }

    public function register(CreateUserRequest $request)
    {
        $userExists = User::where(['email' => $request->email])->first();
        if ($userExists) return redirect()->route('register')->with('error', 'An account already exists with this email address');
        $user = $this->createUser($request);
        Auth::loginUsingId($user->id);
        return redirect()->route('dashboard');
    }

    private function makeReferralCode(): string
    {
        return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
    }

    private function createUser(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'sex' => $request->sex,
            'referred_referral_code' => $request->referral_code ?? '',
            'referral_code' => $this->makeReferralCode(),
        ]);
        event(new UserRegistered($user));
        return $user;
    }
}

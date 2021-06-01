<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{

    public function show()
    {
        return view('dashboard.reset-password');
    }

    public function reset(Request $request)
    {
        $user = User::where('email', $request->email ?? NULL)->first();
        $password = $this->generateRandomPassword();
        if ($user) {
            $user->password = Hash::make($password);
            $user->save();

            Mail::to($user->email)->send(new ForgotPassword($user, $password));
        }
        return redirect()->route('login')->with('success', 'If the email exist on our system, you will receive reset instructions');
    }

    private function generateRandomPassword(): string
    {
        $_alphaSmall = 'abcdefghijklmnopqrstuvwxyz';
        $_alphaCaps  = strtoupper($_alphaSmall);
        $_numerics   = '1234567890';
        $_specialChars = '`~!@#$%^&*()-_=+]}[{;:,<.>/?\'"\|';
        $_container = $_alphaSmall . $_alphaCaps . $_numerics . $_specialChars;
        $password = '';
        for ($i = 0; $i < 10; $i++) {
            $_rand = rand(0, strlen($_container) - 1);
            $password .= substr($_container, $_rand, 1);
        }
        return $password;
    }
}

<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{


    public function change(Request $request)
    {
        $user =Auth::user();
        $oldPassword = $request->oldPassword;
        $password = $request->newPassword;
        $confirmPassword = $request->confirmPassword;

        error_log($user->password);
        error_log($oldPassword);

        if(Hash::check($oldPassword, $user->password)){

            if(strlen($password) >= 8){
                if($password == $confirmPassword){
                    $user->password = Hash::make($password);
                    $user->save();
                    $request->session()->regenerate(true);
                    return redirect()->route('login')->with('success', 'Password updated successfully');

                }else{
                    return redirect()->route('profile')->with('error', 'Confirm password must be the same');
                }
            }else{
                return redirect()->route('profile')->with('error', 'New password cannot be less than 8 characters');
            }
        }else{
            return redirect()->route('profile')->with('error', 'Current Password Incorrect');
        }
    
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

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|min:8',
            'sex' => 'required|string',
            'phone_number' => 'required|string',
            'referred_referral_code' => 'string',
        ];
    }

    public function message()
    {
        return [
            'email.required' => 'Email is required',
            'name.required' => 'Full Name is required',
            'password.required' => 'Password is required',
            'sex' => 'Select your Gender option',
            'phone_number.required' => 'Phone Number is required',
        ];
    }
}

<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8'
        ];
    }

    public function message()
    {
        return [
            'old_password.required' => 'Old password is required',
            'new_password.required' => 'New password is required',
        ];
    }
}

<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
            'name' => 'string',
            'slug' => 'required',
            'meta' => 'string',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3048',
            'duration' => 'integer',
            'duration_type' => 'in:year,month,week,day',
        ];
    }
}

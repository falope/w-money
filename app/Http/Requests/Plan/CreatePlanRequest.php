<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlanRequest extends FormRequest
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
            'name' => 'required|string',
            'meta' => 'required|string',
            'amount' => 'required|numeric',
            'duration' => 'required|integer',
            'duration_type' => 'in:year,month,week,day',
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'Plan name is required',
            'duration_type.required' => 'Duration type is required'
        ];
    }
}

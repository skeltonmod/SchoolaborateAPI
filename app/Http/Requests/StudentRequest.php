<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
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
            'email' => 'required|string|unique:users,email',
            'school_level_id' => 'integer',
            'guardianNumber' => 'required|string',
            'profileimage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function message()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'First name is required',
            'email.required' => 'First name is required',
            'guardianNumber.required' => 'Parent/Guardian Number is required',
        ];
    }
}

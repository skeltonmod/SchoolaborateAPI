<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'role' => 'required|max:4',
            'password' => 'required|string|confirmed',
            'email' => 'required|email|unique:users'
        ];
    }

    public function message()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'role.required' => 'Role is required',
            'password.required' => 'Password is required',
            'email.required' => 'Emai is required'
        ];
    }
}

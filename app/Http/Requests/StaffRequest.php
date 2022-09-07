<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StaffRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'password' => 'required|string|confirmed',
            'email' => 'required|unique:users,email|string',
            'department_id' => 'int',
            'head_staff' => 'int',
            'gender' => 'string',
            'emergency_contact_number' => 'string',
        ];
    }

    public function message()
    {
        return [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'password.required' => 'Password is required',
            'email.required' => 'Email is required',
        ];
    }

}

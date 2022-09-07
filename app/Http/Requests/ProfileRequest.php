<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
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
            'role' => 'required|max:4',
            'email' => 'required|string|email',
            'profileimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function message()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'role.required' => 'Role is required',
            'email.required' => 'Emai is required'
        ];
    }
}

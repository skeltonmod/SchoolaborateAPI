<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SubjectRequest extends FormRequest
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
            'subject_name' => 'required|string|unique',
            'subject_description' => 'string',
            'subject_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function message()
    {
        return [
            'subject_name.required' => 'Subject is required',
        ];
    }
}

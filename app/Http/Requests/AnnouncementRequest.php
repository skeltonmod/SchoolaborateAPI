<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AnnouncementRequest extends FormRequest
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
            'title' => 'required|string|unique:announcements',
            'description' => 'required|string',
            'announcement_attachment' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ];
    }

    public function message()
    {
        return [
            'title.required' => 'Title is required',
            'description.required' => 'description is required',
            'status.required' => 'Status is required',
            'startDate.required' => 'Start Date is required',
            'endDate.required' => 'End Date is required'
        ];
    }
}

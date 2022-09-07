<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Deyji\Manage\Models\Users;
use Illuminate\Http\Request;

class SectionChatController extends Controller
{
    //
    public function getRoomData($id){
        $subject = Subject::where('id', $id)->get()->first();
        if($subject->students()->get()->pluck('user_id')){
            foreach($subject->students()->get()->pluck('user_id') as $pupil){
                $students[] = Users::where('id', $pupil)->get()->first();
            }
        }else{
            $students = [];
        }
        $response = [
            'id' => $subject->id,
            'subject_name' => $subject->subject_name,
            'subject_description' => $subject->subject_description,
            'students'=> $students,
            'section' => $subject->section()->get()->pluck('section_name')->first(),
        ];
        return response()->json($response);
    }
}

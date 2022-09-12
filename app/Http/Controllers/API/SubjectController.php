<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function getSubjectlist()
    {
        $subjects = Subject::all();
        $response = [];

        foreach ($subjects as $subject) {
            $response[] = [
                'id' => $subject->id,
                'subject_name' => $subject->subject_name,
                'subject_description' => $subject->subject_description,
                'status' => $subject->status,
                'section' => $subject->section()->get()->pluck('id')->first(),
            ];
        }

        return response()->json($response);
    }

    public function getSubjectGrid(){
        $subjects = Subject::all();
        $response = [];
        foreach($subjects as $subject){
            if(!$subject->section()->get()->pluck('section_name')->first()){
                continue;
            }
            $response[] = [
                'id' => $subject->id,
                'subject_name' => $subject->subject_name,
                'subject_description' => $subject->subject_description,
                'students'=> count($subject->students()->get()->pluck('id')) ?? 0,
                'section' => $subject->section()->get()->pluck('section_name')->first(),
            ];
        }
        return response()->json($response);
    }

    public function storeSubject(Request $request)
    {
        $subject = Subject::create([
            'subject_name' => $request->subject_name,
            'subject_description' => $request->subject_description,
            'status' => $request->status,
        ]);

        if($request->section){
            $subject->section()->attach($request->section);
        }

        return response()->json([
            'message' => 'Successfully saved!'
        ]);
    }

    public function deleteSubject($id)
    {
        Subject::destroy($id);
        return response()->json([
            'message' => 'Subject has been successfully deleted!'
        ]);
    }

    public function showSubjectDetails($id)
    {
        return Subject::find($id);
    }

    public function searchSubject($subject)
    {
        // $subject = Subject::where('subject_name', 'like', '%' .$subject . '%')->get();
        // speed up query with raw db instead
        $subject = DB::table('subjects')->select("*")->where('subject_name', 'like', '%' . $subject . '%')->get();
        return response()->json([
            'message' => 'Successfully search.',
            'data' => $subject
        ]);
    }

    public function updateSubject(Request $request, $id)
    {
        $subject = Subject::where('id', $id)->get()->first();
        $subject->subject_name = $request->subject_name ?? $subject->subject_name;
        $subject->subject_description = $request->subject_description ?? $subject->subject_description;
        $subject->save();

        if($request->section){
            $subject->section()->attach($request->section);
        }

        return response()->json([
            'message' => 'Successfully updated!'
        ]);
    }

    public function addStudentSubject(Request $request, $id)
    {
        $subject = Subject::where('id', $id)->get()->first();
        $subject->students()->sync($request->ids);

        return response()->json([
            'message' => 'Successfully added!'
        ]);
    }
}

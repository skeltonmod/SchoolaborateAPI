<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StudentRequest;
use App\Models\SchoolLevel;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use Deyji\Manage\Models\Users;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function getStudentList()
    {

        $users = Users::with('student')->get();
        $response = [];

        foreach ($users as $key => $user) {
            if (!$user->hasRole('Student')) {
                continue;
            }

            $response[] = $user;
            // append the student data to the user data
        }

        return response()->json([
            'data' => $response
        ]);
    }

    // Validation is already done in the client, no
    public function storeStudent(Request $request)
    {
        $user = Users::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
        ]);

        Student::create([
            'user_id' => $user->id,
            'guardianNumber' => $request->contactNumber,
            'contactNumber' => $request->contactNumber,
            // Default to 1
            'school_level_id' => $request->grade,
        ]);
        
        $user->assignRole('Student');

        return response()->json([
            'message' => 'Student record Successfully Saved!',
        ]);
    }

    public function showStudentDetails($id)
    {
        $user = Users::where('id', $id)->with('student')->get()->first();
        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'image' => $user->student->image,
            'contactNumber' => $user->student->contactNumber,
            'guardianNumber' => $user->student->guardianNumber,
            'grade' => $user->student->school_level_id,
        ];

        return response()->json([
            'data' => [$response]
        ]);
    }

    public function searchStudent($student)
    {
        // Use RAW DB for performance reasons
        $students = DB::table('users')->where('name', 'like','%'.$student.'%')->get();
        $response = [];
        foreach($students as $student){
            $user = Users::where('id', $student->id)->get()->first();
            if($user->hasRole('Student')){
                $response[] = $user;
            }
        }

        return response()->json([
            'message' => 'Successfully search.',
            'data' => $response
        ]);
    }

    public function updateStudentRecord(Request $request, $id)
    {
        // $image = $request->file('profileimage');
        $user = Users::where('id', $id)->get()->first();
        $student = Student::where('user_id', $id)->get()->first();
        $user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' =>  $request->first_name,
            'last_name' =>  $request->last_name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
        ]);
        $student->update([
            'guardianNumber' => $request->guardianNumber,
            'contactNumber' => $request->contactNumber,
            'school_level_id' => $request->grade,
        ]);
        return response()->json([
            'message' => 'Student record Successfully Updated!',
        ]);
    }

    public function deleteStudentRecord($id)
    {
        $user = Users::where('id', $id)->get()->first();
        $user->deleteStudentRecord();
        return response()->json([
            'message' => 'Student record has been successfully deleted!'
        ]);
    }
}

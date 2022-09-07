<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Staff;
use App\Models\Department;
use App\Http\Requests\StaffRequest;
use Deyji\Manage\Models\Users;

class StaffController extends Controller
{
    public function getStaffList()
    {
        $staffs = Users::get();
        $response = [];
        foreach($staffs as $staff){
            if(!$staff->hasRole('Staff')){
                continue;
            }

            $response[] = $staff;
        }

        return response()->json([
            'data' => $response
        ]);      
    }

    public function storeStaffRecord(Request $request)
    {
        $user = Users::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'gender' => $request->gender,
            'emergency_contact_number' => $request->emergency_contact_number
        ]);

        $user->assignRole('Staff');
        
        Staff::create([
            'user_id' => $user->id,
        ]);

        return response()->json(['message' => 'Staff Created Successfully!']);
    }

    public function showStaffDetails($id)
    {
        $user = Users::where('id', $id)->with('staff')->get()->first();

        // TODO, grab staff details, currently no front end?
        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ];

        return response()->json([
            'data' => [$response]
        ]);
    }

    public function searchStaff($staff)
    {
        $staff = User::where('last_name', 'like', '%' . $staff . '%')
                        ->where('role', 3)
                        ->orwhere('first_name', 'like', '%' . $staff . '%')
                        ->where('role', 3)
                        ->with('staff')->get();

        return response()->json([
            'message' => 'Successfully search.',
            'data' => $staff
        ]);
    }

    public function updateStaffRecord(Request $request, $id)
    {
        $image = $request->file('profileimage');

        if($image){
            $newImageName = rand().'.'.$image->getClientOriginalExtension();
            Storage::disk(env('AWS_BUCKET') ? 's3' : 'public')->putFileAs('/uploads/images', $image, $newImageName );

            $requestData = $request->all();

            $requestData['profileimage']  = $newImageName;
            $requestData['role']  = 3;

            User::where('id', $id)->update([
                'first_name' =>  $requestData['first_name'],
                'last_name' =>  $requestData['last_name'],
                'email' =>  $requestData['email'],
                'profileimage' =>  $requestData['profileimage'],
                'gender' => $requestData['gender'],
                'emergency_contact_number' => $requestData['emergency_contact_number']
            ]);

            Staff::where('user_id', $id)->update([
                'department_id' => $requestData['department_id'],
                'head_staff' => $requestData['head_staff'],
            ]);

            return response()->json([
                'message' => "Successfully update Staff record!"
            ]);
        }
    }

    public function deleteStaffRecord($id)
    {
        User::destroy($id);
        Staff::where('user_id', $id)->delete();
        return response()->json([
            'message' => 'Staff record has been successfully deleted!'
        ]);
    }

    public function getDepartmentList()
    {
        $data = Department::all();

        return response()->json([
            'data' => $data 
        ]);
    }
}

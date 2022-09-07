<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    public function getDepartmentList()
    {
        $data = Department::all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function storeDepartment(Request $request)
    {
        Department::create($request->all());

        return response()->json([
            'message' => 'Successfully saved!'
        ]);
    } 
    
    public function showDepartmentDetails($id)
    {
        $department = Department::where('id', $id)->get()->first();
        $response = [
            'id'=> $department->id,
            'department_name' => $department->department_name,
            'status' => $department->status,
        ];

        return response()->json($response);
    }

    public function searchDepartment($department)
    {
        $data = Department::where('department_name', 'like', '%' .$department . '%')->get();

        return response()->json([
            'message' => 'Successfully search.',
            'data' =>  $data 
        ]);
    }

    public function updateDepartment(Request $request, $id)
    {
        $departmentData =  $request->all();
        Department::where('id', $id)->update($departmentData);

        return response()->json([
            'message' => 'Successfully updated!',
        ]);
    }

    public function deleteDepartment(Request $request)
    {
        Department::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => 'Department record has been successfully deleted'
        ]);

    }


}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SchoolEnvironment;
use App\Http\Requests\SchoolEnvironmentRequest;


class SchoolEnvironmentController extends Controller
{
    public function getSchoolEnvironmentList()
    {
        $data = SchoolEnvironment::all();

        return response()->json([
            'data' => $data
        ]);
    }

    public function storeSchoolEnvironment(SchoolEnvironmentRequest $request)
    {
        SchoolEnvironment::create($request->all());

        return response()->json([
            'message' => 'Successfully saved!'
        ]);
    }

    public function deleteSchoolEnvironment($id)
    {
        SchoolEnvironment::destroy($id);

        return response()->json([
            'message' => 'Successfully Deleted!'
        ]); 
    }

    public function showSchoolEnvironmentDetails($id)
    {
        return SchoolEnvironment::find($id);
    }

    public function searchSchoolEnvironment($schoolEnvironment)
    {
        $data = SchoolEnvironment::where('description', 'like', '%' .$schoolEnvironment . '%')->get();

        return response()->json([
            'message' => 'Successfully search.',
            'data' =>  $data 
        ]);
    }

    public function updateSchoolEnvironment(SchoolEnvironmentRequest $request, $id)
    {
        $requestData = $request->all();
        SchoolEnvironment::where('id', $id)->update($requestData);

        return response()->json([
            'message' => 'Successfully Updated!',
        ]);

    }
}

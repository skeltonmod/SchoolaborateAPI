<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SchoolLevel;
use Carbon\Carbon;

class SchoolLevelController extends Controller
{
    public function getSchoolLevelList()
    {
        $data = SchoolLevel::all();
        $response = [];

        foreach ($data as $schoolLevel) {
            $response[] = [
                'id' => $schoolLevel->id,
                'name' => $schoolLevel->name,
                'created_at' => Carbon::parse($schoolLevel->created_at)->format('F d Y'),
                // 'description' => $schoolLevel->description,
                'status' => $schoolLevel->status,
            ];
        }


        return response()->json([
            'data' => $response
        ]);
    }

    public function storeSchoolLevel(Request $request)
    {

        SchoolLevel::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'message' => 'Successfully saved!'
        ]);
    }

    public function showSchoolLevelDetails($id)
    {
        return SchoolLevel::find($id);
    }

    public function searchSchoolLevel($schoolLevel)
    {
        $data = SchoolLevel::where('description', 'like', '%' . $schoolLevel . '%')->get();
        return response()->json([
            'message' => 'Successfully search.',
            'data' =>  $data
        ]);
    }

    public function updateSchoolLevel(Request $request, $id)
    {
        $school_level = SchoolLevel::where('id', $id)->get()->first();
        $school_level->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Successfully Updated!',
        ]);
    }

    public function deleteSchoolLevel(Request $request)
    {
        SchoolLevel::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => 'Successfully Deleted!'
        ]);
    }
}

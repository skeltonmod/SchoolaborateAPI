<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SchoolLevel;


class SchoolLevelController extends Controller
{
    public function getSchoolLevelList()
    {
        $data = SchoolLevel::all();

        return response()->json([
            'data' => $data
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

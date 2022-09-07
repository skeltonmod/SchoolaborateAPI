<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Http\Requests\SectionRequest;
use Carbon\Carbon;

class SectionController extends Controller
{
    public function getSectionlist()
    {
        $sections = Section::all();
        $response = [];

        foreach ($sections as $section) {
            $response[] = [
                'id' => $section->id,
                'section_name' => $section->section_name,
                'created_at' => Carbon::parse($section->created_at)->format('F d Y'),
                'status' => $section->status,
            ];
        }

        return response()->json([
            'data' => $response
        ]);
    }

    public function storeSection(Request $request)
    {
        Section::create([
            'section_name' => $request->section_name,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Successfully saved!'
        ]);
    }

    public function deleteSection(Request $request)
    {
        Section::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => 'Successfully Deleted!'
        ]);
    }

    public function showSectionDetails($id)
    {
        return Section::find($id);
    }

    public function searchSection($section)
    {
        $sections = Section::where('section_name', 'like', '%' . $section . '%')->get();
        $response = [];
        foreach ($sections as $section) {
            $response[] = [
                'id' => $section->id,
                'section_name' => $section->section_name,
                'created_at' => Carbon::parse($section->created_at)->format('F d Y'),
                'status' => $section->status,
            ];
        }
        return response()->json([
            'message' => 'Successfully search.',
            'data' =>  $response
        ]);
    }

    public function updateSection(Request $request, $id)
    {

        $section = Section::where('id', $id)->get()->first();

        $section->update([
            'section_name' => $request->section_name,
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Successfully Updated!',
        ]);
    }
}

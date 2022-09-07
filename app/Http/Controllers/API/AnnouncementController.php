<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Http\Requests\AnnouncementRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function getAnnouncements()
    {
        $announcements = Announcement::all();
        $response = [];
        foreach ($announcements as $announcement) {
            $response[] = [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'description' => $announcement->description,
                'startDate' => $announcement->start_date,
                'endDate' => $announcement->end_date,
                'status' => $announcement->active,
            ];
        }

        return response()->json([
            'data' => $response
        ]);
    }

    public function storeAnnouncement(Request $request)
    {
        Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => Carbon::parse($request->startDate)->toDate(),
            'end_date' => Carbon::parse($request->endDate)->toDate(),
            'active'=> $request->status,
        ]);

        return response()->json(['message' => 'Announcement Created Successfully!']);
    }

    public function deleteAnnouncement(Request $request)
    {
        Announcement::whereIn('id', $request->ids)->delete();

        return response()->json([
            'message' => 'Successfully Deleted!'
        ]);
    }

    public function updateAnnouncement(Request $request, $id)
    {
        $announcement = Announcement::where('id', $id)->get()->first();
        $announcement->update([
            'title' => $request->title,
            'description' => $request->description,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'active' => $request->status,
        ]);

        return response()->json([
            'message' => 'Successfully Updated!'
        ]);
    }

    public function showAnnouncementDetails($id)
    {
        $announcement = Announcement::where('id', $id)->get()->first();
        $response = [
            'id' => $announcement->id,
            'title' => $announcement->title,
            'description' => $announcement->description,
            'startDate' => $announcement->start_date,
            'endDate' => $announcement->end_date,
            'status' => boolval($announcement->active),
        ];

        return response()->json($response);
    }

    public function searchAnnouncement($title)
    {
        $data = Announcement::where('title', 'like', '%' . $title . '%')->get();

        return response()->json([
            'message' => 'Successfully search.',
            'data' =>  $data
        ]);
    }
}

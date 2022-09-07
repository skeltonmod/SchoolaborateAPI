<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ProfileRequest;
use Deyji\Manage\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function getProfile(Request $request, $id)
    {
        $data = User::find($id);
        
        return response()->json([
            'message' => 'User profile',
            'data' => $data
        ]);
    }

    public function getAuthenticatedUser(){
        $user = Auth::user();
        $response = [
            'fullName' => $user->name,
            'email' => $user->email,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'contactInfo' => $user->emergency_contact_number,
            'role'=> Users::where('id', $user->id)->get()->first()->roles()->first()->name,
        ];
        return response()->json($response);
    }

    public function updateAuthenticatedUser(Request $request){
        $user = Users::where('id', Auth::user()->id)->first();

        $user->update([
            'name' => $request->firstName . ' ' . $request->lastName,
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'emergency_contact_number' => $request->contactInfo,
            'email' => $request->email,
            'password'=> $request->has('password') && $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json([
            'message' => 'User profile updated',
        ]);
    }


    public function updateProfile(ProfileRequest $profileRequest, $id)
    {
        $image = $profileRequest->file('profileimage');

        if($profileRequest->hasFile('profileimage')){

            $newImageName = rand().'.'.$image->getClientOriginalExtension();
            Storage::disk(env('AWS_BUCKET') ? 's3' : 'public')->putFileAs('/uploads/images', $image, $newImageName );

            $requestData = $profileRequest->all();
            $requestData['profileimage']  = $newImageName;

            User::where('id', $id)->update($requestData);

             return response()->json([
                'message' => 'Successfully Updated!',
             ]);
        }
    }

}

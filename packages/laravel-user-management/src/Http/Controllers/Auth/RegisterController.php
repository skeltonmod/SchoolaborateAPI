<?php

namespace Deyji\Manage\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agency;
use App\Models\UserProfile;
use Deyji\Manage\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Deyji\Manage\Facades\UserVerification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    public function register(Request $request)
    { 
        Validator::extend('is_img', function ($attribute, $value, $params, $validator) {
            $image = base64_decode($value);
            $f = finfo_open();
            // $result = finfo_buffer($f, $image, FILEINFO_MIME_TYPE);
            $res = mime_content_type($value);
            if ($res == 'image/png' || $res == 'image/jpeg' || $res == 'image/jpg' || $res == 'image/gif') {
                return $res;
            }
        });
        $request["company"] = $request['company_id'];
        $request["agency"] = $request['agency_id'];
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|string|min:6",
            "password_confirmation" => "required|same:password",
            "contact_number" => "required|numeric",
            "landline" => "required_without:contact_number|numeric",
            'agency' => "required_if:role,Agent",
            'company' => "required_if:role,Landlord",
            'image' => 'is_img|max:8215184'
        ],
		[
            'image.max'        => 'Maximum allowed file size is 5MB.',
        ]);

        $user = Users::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $token = $user->createToken("Personal Access Token");

        UserProfile::create([
            'user_id' => $user->id,
            'phone_number' => $request->contact_number,
            'contact_type' => $request->contact_type,
            'position' => $request->position,
        ]);

        // Attach the company
        Users::query()->find($user->id)->companies()->attach($request->company);
        $user->assignRole($request->role);

        // Attach the agency
        if($request->has('agency')){
            Users::query()->find($user->id)->agencies()->attach($request->agency);
        }

        // Run once instead of using a trait
        event(new Registered($user));
        UserVerification::generate($user);
        UserVerification::send($user, "Spek User Account Verification", null, null, $request->role);
        if ($request->image) {
            // Grab the content from the blob link
            list($baseType, $data) = explode(';', $request->image);
            list(, $data) = explode(',', $data);
            $image = base64_decode($data);
            $imageName = Str::random(10) . '.' . 'png';

            // When all is done, upload the image 
            $s3 = App::make('aws')->createClient('s3');

            $base64_str = substr($request->image, strpos($request->image, ",") + 1);
            $image = base64_decode($base64_str);
            $imageName = $user->name.'_'.Str::random(10) . '.' . 'png';

            $s3->putObject([
                'Bucket' => 'spekapp-bucket',
                'Key' => 'private/'.env('BUCKET_DIRECTORY').'/'.$imageName,
                'Body' => $image
            ]);
            $user->image = 'private/'.env('BUCKET_DIRECTORY').'/'.$imageName;
            $user->save();
        }

        return response()->json([
            'message' => 'Successfully created user!',
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $token->token->expires_at
            )->toDateTimeString(),
            'role' => $user->roles
        ]);
    }
}

<?php

namespace Deyji\Manage\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use Deyji\Manage\Models\Users;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */
    // Verify Email once the user clicks the link
    public function verifyEmail(Request $request){
        $user = Users::where('verification_token', $request->token);
        if($user->count()){
            $user = $user->first();
            if($user->verified == 1){
                return response()->json(['message' => 'Account already verified'], 200);
            }
            $user->verified = 1;
            $user->verification_token = null;
            $user->save();
            return response()->json(['message' => 'Email verified successfully, You may now login']);
        }else{
            return response()->json(['message' => 'Invalid Verification token'], 500);
        }
    }

}

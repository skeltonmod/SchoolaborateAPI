<?php

namespace Deyji\Manage\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Deyji\Manage\Models\Users;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Lcobucci\JWT\Token\Parser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use ThrottlesLogins;
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $maxAttempts = 2;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $request->validate([
            "email"=>"required|email",
            "password"=>"required|string"
        ]);

        $credentials = $request->only('email', 'password');
        if(Auth::guard('web')->attempt($credentials)){

            $user = Users::query()->where('email', $request['email'])->first();
            $token = $user->createToken('Personal Access Token');
            // Infer the week
            $token->token->expires_at = Carbon::now()->addMonths(1);
            $user = Auth::user();
            return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => Users::where('id', $user->id)->get()->first()->roles->first()->name,
                'token' => $token->accessToken,
                'expires_at' => $token->token->expires_at->toDateTimeString()
            ], 
            'access_token' => $token->accessToken,
            'expires_at' => Carbon::parse(
                $token->token->expires_at
            )->toDateTimeString()
        ]);

        }else{
            return response()->json([
                'success' => false,
                'message' => 'Invalid login credentials'
            ], 401);
        }


    }

    public function logout(Request $request){
        // Delete the tokens
        return response([
            "message"=>"Logged out!",
            "count"=>Users::query()->find(Auth::id())->tokens()->delete()
        ]);
    }

}

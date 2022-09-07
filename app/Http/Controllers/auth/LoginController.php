<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $login = $request->validated();

        if (!Auth::attempt($login)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login credentials'
            ], 413);
        }

        $token = Auth::user()->createToken('Personal Access Token')->accessToken;
        
        return response()->json(['success' => true, 'user' => Auth::user(), 'access_token' => $token]);
    }
}

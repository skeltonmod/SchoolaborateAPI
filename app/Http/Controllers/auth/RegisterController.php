<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $users = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'role' => $request['role'],
            'password' => Hash::make($request['password']),
            'email' => $request['email']
        ]);

        $token = $users->createToken('myapptoken')->accessToken;

        if($users['role'] === '2' || $users['role'] === '3'){

            Staff::create([
                'user_id' => $users['id'],
            ]);
        }

        if($users['role'] === '4'){
           
            Student::create([
                'user_id' => $users['id'],
            ]);
        }

        $response = [
            'user' => $users,
            'token' => $token
        ];

        return response($response, 201);
    }

}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AwardController extends Controller
{
    public function awards()
    {
        return User::Awards();
    }
}

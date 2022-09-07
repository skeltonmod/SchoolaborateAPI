<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;

class ModuleAccessController extends Controller
{
    // This will get all module access per user
    public function moduleAccess ()
    {
        return User::ModuleAcess();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UserTrait;

class UserController extends Controller
{
    use UserTrait;
    
    public function index()
    {
        return view('users.index');
    }

    public function fetch(Request $request)
    {
        $users = $this->scoutUsers($request);

        return response()->json($users);
    }
}

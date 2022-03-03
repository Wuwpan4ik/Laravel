<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function allUser()
    {
        $notes = DB::table('users')->get();

        return view("users-list", [
            'notes' => $notes,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function allUsers()
    {
        $notes = User::get();

        return view("user.users-list", [
            'notes' => $notes,
        ]);
    }
}

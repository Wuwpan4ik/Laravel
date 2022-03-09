<?php

namespace App\Http\Middleware;

use App\Book;
use App\LibraryConnect;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class checkLibraryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = $request->route('id');
        $temp = LibraryConnect::where('user_to', '=', Auth::user()->id)->where('library_id', '=', $id)->first();
        if (!(is_null($temp)) or $id == Auth::user()->id) {

            return $next($request);
        } else {

            $notes = User::get();
            return response()->view("users-list", [
                'notes' => $notes,
            ]);
        }
    }
}

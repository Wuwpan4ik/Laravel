<?php

namespace App\Http\Middleware;

use App\Book;
use App\Library_connect;
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
        $temp = Library_connect::where('user_to', '=', Auth::user()->id)->where('library_id', '=', $id)->get();
        if (isset($temp[0]) or $id == Auth::user()->id) {
            return $next($request);
        }
        abort(403);
    }
}

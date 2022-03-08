<?php

namespace App\Http\Middleware;

use App\Book;
use Closure;
use Illuminate\Support\Facades\Auth;

class checkBook
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
        $rigth =  $request->get('right');
        $book = Book::find($id);
        if ($book->user_id == Auth::user()->id or $rigth == $book->local_id) {
            return response()->view('book-read', ['id' => $id, 'book' => $book]);
        }
        $books = Book::where('user_id', '=', $id)->get();
        return response()->view('library', ['id' => $id, 'books' => $books]);
    }
}

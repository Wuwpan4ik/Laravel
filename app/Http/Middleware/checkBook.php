<?php

namespace App\Http\Middleware;

use App\Book;
use App\LibraryConnect;
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
        $book = Book::find($id);
        $temp = LibraryConnect::where('user_to', '=', Auth::user()->id)->where('library_id', '=', $book->user_id)->first();

        //Проверка имеется ли доступ по ссылке ИЛИ пользователь - создатель книги ИЛИ дан доступ к библиотеке
        if ($request->get('right') == $book->local_id or $book->user_id == Auth::user()->id or !(is_null($temp))) {
            return $next($request);
        }
        return redirect('library/'.Auth::user()->id);
    }
}

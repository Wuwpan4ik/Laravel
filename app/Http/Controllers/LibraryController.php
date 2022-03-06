<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    public function index ($id) {
        $books = Book::where('user_id', '=', $id)->get();
        return view('library', ['id' => $id, 'books' => $books]);
    }

    public function delete($id) {
        DB::table('books')->delete(\request()->input('book_id'));
        $books = Book::where('user_id', '=', $id)->get();
        return view('library', ['id' => $id, 'books' => $books]);
    }

    public function edit($id) {
        $book = DB::table('books')->where('id', '=', $id)->get();
        return view('library-edit', ['id' => $id, 'book' => $book[0]]);
    }

    public function editBook($id) {
        $book = Book::find($id);
        $book->title = \request()->input('title');
        $book->text = \request()->input('text');
        $book->save();
        $books = Book::where('user_id', '=', $id)->get();
        return view('library', ['id' => $book->user_id, 'books' => $books]);
    }
}

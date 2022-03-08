<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BookRequest;
use App\Library_connect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    public function index ($id) {
        $books = Book::where('user_id', '=', $id)->get();
        return view('library', ['id' => $id, 'books' => $books]);
    }

    public function add($id) {
        return view('library-add', ['id' => $id]);
    }

    public function addBook(BookRequest $request, $id) {
        $book = new Book();
        $book->user_id = $id;
        $book->title = $request->input('title');
        $book->text = $request->input('text');
        $book->access_all = $request->input('access_all');
        $book->save();
        return $this->index($id);
    }

    public function delete($id) {
        DB::table('books')->delete(\request()->input('book_id'));
        $books = Book::where('user_id', '=', $id)->get();
        return $this->index($id);
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
        return $this->index($book->user_id);
    }

    public function read($id) {
        //
    }
    public function giveRight($id) {
        $library_connect = new Library_connect();
        $library_connect->library_id = Auth::user()->id;
        $library_connect->user_to = $id;
        $library_connect->save();
        return $this->index($id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Requests\BookRequest;
use App\LibraryConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    public function index ($id) {
        $books = Book::where('user_id', '=', $id)->get();
        return view('library', ['id' => $id, 'books' => $books]);
    }

    public function add(Request $request) {
        // id книги
        $id = $request->route('id');

        if ($request->isMethod('GET')) {
            // Вывод свойств книги
            return view('library-add', ['id' => $id]);

        } elseif ($request->isMethod('POST')) {

            // Изменение свойств книги
            $book = new Book();
            $book->user_id = $id;
            $book->title = $request->input('title');
            $book->text = $request->input('text');
            $book->access_all = $request->input('access_all');
            $book->save();
            return $this->index($id);
        }
    }

    public function delete($id) {
        DB::table('books')->delete(\request()->input('book_id'));
        $books = Book::where('user_id', '=', $id)->get();
        return $this->index($id);
    }

    public function edit(Request $request) {
        // id книги
        $id = $request->route('id');

        // Проверка на GET или POST запрос
        if ($request->isMethod('GET')) {

            // Вывод свойств книги
            $book = DB::table('books')->where('id', '=', $id)->get();
            return view('library-edit', ['id' => $id, 'book' => $book[0]]);

        } elseif ($request->isMethod('POST')) {

            // Изменение свойств книги
            $book = Book::find($id);
            $book->title = \request()->input('title');
            $book->text = \request()->input('text');
            $book->save();
            $books = Book::where('user_id', '=', $id)->get();
            return $this->index($book->user_id);

        }
    }


    public function read($id) {
        //
    }
    public function giveRight($id) {
        $secure = \request()->input('secure');
        if ($secure == 'False') {
            $library_connect = new LibraryConnect();
            $library_connect->library_id = Auth::user()->id;
            $library_connect->user_to = $id;
            $library_connect->save();
        } elseif ($secure == 'True') {
            LibraryConnect::where('library_id', '=', Auth::user()->id)->where('user_to', '=', $id)->delete();
        }
        return $this->index($id);
    }
}

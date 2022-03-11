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
    protected function checkUser($book) {
        if ($book->user_id == Auth::user()->id) {
            return True;
        }
        return False;
    }

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
        return  $this->index(Auth::user()->id);
    }

    public function delete(Request $request) {
        $book = Book::find($request->input('book_id'));
        if ($this->checkUser($book)) {
            $book->delete();
            return $this->index($request->route('id'));
        }
        return $this->index($book->user_id);
    }

    public function edit(Request $request) {
        // id книги
        $id = $request->input('book_id');
        $book = Book::find($id);
        if ($this->checkUser($book)) {

            // Проверка на GET или POST запрос
            if ($request->isMethod('GET')) {

                // Вывод свойств книги
                $book = DB::table('books')->where('id', '=', $id)->get();
                return view('library-edit', ['id' => $id, 'book' => $book[0]]);

            } elseif ($request->isMethod('POST')) {

                // Изменение свойств книги
                $book = Book::find($id);
                $book->title = $request->input('title');
                $book->text = $request->input('text');
                $book->save();
                $books = Book::where('user_id', '=', Auth::user()->id)->get();
                return $this->index($book->user_id);
            }
        }
        return $this->index($book->user_id);
    }

    public function read(Request $request, $id) {
        $book_id = $request->input('book_id');
        $book = Book::find($book_id);
        return response()->view('book-read', ['id' => $id, 'book' => $book]);
    }

    public function giveRight(Request $request, $id) {
        $secure = $request->input('secure');
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

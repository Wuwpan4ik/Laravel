<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentsController;
use \App\Http\Controllers\LibraryController;

Route::get('/', function () {
    return view('index');
});

Route::get('/', [UserController::class, 'allUser'])->name('users-list');
Route::get('/user-comments/{id}', [CommentsController::class, 'userComments'])->name('user-comments');
Route::post('/form-checker', [CommentsController::class, 'addComment'])->name('comment-add');
Route::post('/form-delete', [CommentsController::class, 'deleteComment'])->name('comment-delete');


Route::middleware(['check-library'])->group(function () {
    Route::get('/library/{id}', [LibraryController::class, 'index'])->name('library');
});

Route::middleware(['auth'])->group(function (){
    Route::get('/user/{id}', [CommentsController::class, 'page'])->name('user');
    Route::get('/book-delete/{id}', [LibraryController::class, 'delete'])->name('book-delete');
    Route::get('/book-edit/{id}', [LibraryController::class, 'edit'])->name('book-edit');
    Route::post('/book-edit/{id}', [LibraryController::class, 'editBook'])->name('book-edit-bs');
    Route::get('/book-add/{id}', [LibraryController::class, 'add'])->name('book-add');
    Route::post('/book-add/{id}', [LibraryController::class, 'addBook'])->name('book-add-bs');
});

Route::get('/give-right/{id}', [LibraryController::class, 'giveRight'])->name('give-right');
Route::get('/book-read/{id}', [LibraryController::class, 'read'])->name('book-read')->middleware('checkBook');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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



Route::get('/', [UserController::class, 'allUser'])->name('users-list');

// Просмотр комментариев
Route::get('/user-comments/{id}', [CommentsController::class, 'userComments'])->name('user-comments');


Route::middleware(['check-library'])->group(function () {
    // Просмотр библиотеки
    Route::get('/library/{id}', [LibraryController::class, 'index'])->name('library');
});

Route::middleware(['auth'])->group(function (){

    // Страница пользователя
    Route::get('/user/{id}', [CommentsController::class, 'page'])->name('user');

    //Удаление - добавление комментария
    Route::post('/form-checker', [CommentsController::class, 'addComment'])->name('comment-add');
    Route::post('/form-delete', [CommentsController::class, 'deleteComment'])->name('comment-delete');

    // Связанные с библоитекой
    Route::prefix('book')->group(function (){
        Route::get('/delete/{id}', [LibraryController::class, 'delete'])->name('book-delete');
        Route::any('/edit/{id}', [LibraryController::class, 'edit'])->name('book-edit');
        Route::any('/add/{id}', [LibraryController::class, 'add'])->name('book-add');
        Route::get('/read/{id}', [LibraryController::class, 'read'])->name('book-read')->middleware('checkBook');

        // Передача прав на библиотеку
        Route::get('/right/{id}', [LibraryController::class, 'giveRight'])->name('give-right');
    });
});

Auth::routes();

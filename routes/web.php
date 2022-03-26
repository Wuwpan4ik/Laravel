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

use App\Http\Controllers\UsersController;
use App\Http\Controllers\CommentsController;
use \App\Http\Controllers\LibraryController;



Route::get('/', [UsersController::class, 'allUsers'])->name('users-list');

// Просмотр комментариев
Route::get('/user-comments/{id}', [CommentsController::class, 'userComments'])->name('user-comments');
// Страница пользователя
Route::get('/user/{id}', [CommentsController::class, 'page'])->name('user');
//Подгрузка комментариев
Route::get('/getComments/{id}', [CommentsController::class, 'getComments'])->name('getComments');

Route::get('getJsonForQuestions/{id}', [CommentsController::class, 'getJsonForQuestions']);


Route::middleware(['auth'])->group(function (){

    //Удаление - добавление комментария
    Route::post('/form/checker', [CommentsController::class, 'create'])->name('comment-add');
    Route::post('/form/delete', [CommentsController::class, 'delete'])->name('comment-delete');


    // Связанные с библоитекой
    Route::prefix('book')->middleware('check-library')->group(function (){
         Route::get('/delete/{id}', [LibraryController::class, 'delete'])->name('book-delete');
         Route::any('/add/{id}', [LibraryController::class, 'add'])->name('book-add');
         Route::any('/edit/{id}', [LibraryController::class, 'edit'])->name('book-edit');
         Route::get('/read/{id}', [LibraryController::class, 'read'])->name('book-read');
         Route::get('/right/{id}', [LibraryController::class, 'giveRight'])->name('library.give-right');
        // Передача прав на библиотеку
    });
    Route::get('/library/{id}', [LibraryController::class, 'index'])->name('library.library')->middleware('check-library');
});

Auth::routes();

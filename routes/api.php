<?php

use App\Http\Controllers\{AuthController, BookController, CommentController, FakerController, UserController}; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
//logout route
Route::post('/logout', [AuthController::class, 'logout']);
//PROTECTED ROUTE
Route::post('/faker/action', [FakerController::class, 'action'])->name('book-action');
Route::get('/book/list', [BookController::class, 'search'])->name('book-list');
Route::middleware('auth:sanctum')->group(function (){

    //User route
    Route::get('/user/list', [UserController::class, 'search'])->name('user-list');
    Route::get('/user/get', [UserController::class, 'get'])->name('user-get');
    Route::post('/user/action', [UserController::class, 'action'])->name('user-action');
    Route::delete('/user/delete/{id}', [UserController::class, 'delete'])->name('user-delete');
    Route::get('/user/company/list', [UserController::class, 'searchUsersInCompany'])->name('user-company-list');

    

    // Book
    Route::get('/book/get', [BookController::class, 'get'])->name('book-get');
    Route::post('/book/like', [BookController::class, 'like'])->name('book-like');
    Route::post('/book/favourite', [BookController::class, 'favourite'])->name('book-favourite');
    Route::post('/book/action', [BookController::class, 'action'])->name('book-action');
    Route::delete('/book/delete/{id}', [BookController::class, 'delete'])->name('book-delete');

    // Comment
    Route::get('/comment/list', [CommentController::class, 'search'])->name('comment-list');
    Route::get('/comment/get', [CommentController::class, 'get'])->name('comment-get');
    Route::post('/comment/action', [CommentController::class, 'action'])->name('comment-action');
    Route::delete('/comment/delete/{id}', [CommentController::class, 'delete'])->name('comment-delete');
});

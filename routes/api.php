<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/author/create', 'AuthorController@store');
Route::get('/author/edit/{id}', 'AuthorController@edit');
Route::post('/author/update/{id}', 'AuthorController@update');
Route::delete('/author/delete/{id}', 'AuthorController@delete');
Route::get('/author/{id}', 'AuthorController@show');
Route::get('/authors', 'AuthorController@index');

Route::post('/attach/{author_id}/{book_id}', 'AuthorController@attach');
Route::post('/detach/{author_id}/{book_id}', 'AuthorController@detach');
Route::post('/book/create/attach', 'BookController@createAttach');

Route::post('/book/create', 'BookController@store');
Route::get('/book/edit/{id}', 'BookController@edit');
Route::post('/book/update/{id}', 'BookController@update');
Route::delete('/book/delete/{id}', 'BookController@delete');
Route::get('/books', 'BookController@index');
Route::get('/book/{id}', 'BookController@show');

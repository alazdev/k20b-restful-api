<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('book')->group(function () {
    Route::get('/', 'BookApiController@get_books');
    Route::get('/{id}', 'BookApiController@get_a_book');

    Route::post('/', 'BookApiController@post_a_book');
    Route::put('/{id}', 'BookApiController@update_a_book');
    Route::delete('/{id}', 'BookApiController@delete_a_book');
});
Route::prefix('user')->group(function () {
    Route::get('/', 'UserApiController@get_users');
    Route::get('/{id}', 'UserApiController@get_a_user');

    Route::post('/', 'UserApiController@post_a_user');
    Route::put('/{id}', 'UserApiController@update_a_user');
    Route::delete('/{id}', 'UserApiController@delete_a_user');
});
Route::prefix('peminjaman')->group(function () {
    Route::get('/', 'PeminjamanApiController@get_peminjamans');
    Route::get('/{id}', 'PeminjamanApiController@get_a_peminjaman');

    Route::post('/', 'PeminjamanApiController@post_a_peminjaman');
    Route::delete('/{id}', 'PeminjamanApiController@delete_a_peminjaman');
});
Route::prefix('pengembalian')->group(function () {
    Route::get('/', 'PengembalianApiController@get_pengembalians');
    Route::get('/{id}', 'PengembalianApiController@get_a_pengembalian');

    Route::put('/{id}', 'PengembalianApiController@update_a_pengembalian');
    Route::delete('/{id}', 'PengembalianApiController@delete_a_pengembalian');
});
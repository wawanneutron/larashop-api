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
/*
Route::match(['get', 'post'], 'name', function () {
    return 'akses method lebih dari satu dengan match';
});

Route::any('user', function () {
    return 'akses semua method dengan any';
});

Route::get('book/{name}', function () {
    return 'Data Buku';
})->where('name', '[A-Za-z]+');

Route::match(['get', 'post'], 'book/{harga}', function () {
    return 'Buku ini harganya terjangkau';
})->where('harga', '[0-9]+');


Route::any('buku/{judul}', 'BookController@cetak');

Route::middleware(['cors'])->group(function () {
    Route::get('buku/{judul}', 'BookController@cetak');
});

*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // route public
    Route::get('books', 'BookController@index');
    Route::match(['get', 'post'], 'book/{id}', 'BookController@view')
        ->where('id', '[0-9]+');
    //route login, register,logout
    Route::post('login', 'AuthApiController@login');
    Route::post('register', 'AuthApiController@register');
    Route::post('logout', 'AuthApiController@logout');

    //route private
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'AuthApiController@logout');
    });
});

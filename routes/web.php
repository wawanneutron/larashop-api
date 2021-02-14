<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'admin'], function () {
    Route::get('/data-larashop', 'HomeController@index')->name('home');
    Route::match(['put', 'patch'], '/update-user/{id}', 'HomeController@updateUser')->name('update-user');
    Route::delete('/delete-user/{id}', 'HomeController@deleteUser')->name('user-delete');

    // route book
    Route::put('/edit-book/{id}', 'HomeController@updateBook')->name('update-book');
    Route::delete('/delete-book/{id}', 'HomeController@deleteBook')->name('book-delete');

    // category
    Route::put('/edit-category/{id}', 'HomeController@updateCategory')->name('update-category');
});

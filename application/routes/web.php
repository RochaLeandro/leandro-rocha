<?php

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
    return redirect()->route('user.list');
});

Route::prefix('users')->name('user.')->group(function () {

    Route::get('/', 'UserController@index')->name('list');

    Route::post('/fetch', 'UserController@fetch')->name('fetch');

});
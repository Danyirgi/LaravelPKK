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

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::group(['middleware' => ['jwt.verify']], function () {

	Route::get('login/check', "UserController@LoginCheck");

    //User
    Route::get('user', "UserController@index");
    Route::get('user/{limit}/{offset}', "UserController@getAll");

    //Produk
    Route::get('produk', "ProdukController@index");
    Route::post('produk', "ProdukController@store");
    Route::put('produk/{id}', "ProdukController@update");
    Route::delete('produk/{id}', "ProdukController@destroy");
});
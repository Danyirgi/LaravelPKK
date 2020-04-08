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

<<<<<<< HEAD
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::group(['middleware' => ['jwt.verify']], function () {

	Route::get('login/check', "UserController@LoginCheck");
    
    Route::get('user', "UserController@index");
    Route::get('user/{limit}/{offset}', "UserController@getAll");
});
=======
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
>>>>>>> 88935b6138a5fd4f44ef8594f92bfb33c2967cfb

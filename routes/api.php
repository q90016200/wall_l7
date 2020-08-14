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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('auth')->group(function () {
    Route::post('/login', 'AuthController@login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', 'AuthController@user');
        Route::post('/logout', 'AuthController@logout');
    });

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'lineNotify'
], function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth', 'LineNotifyController@auth');
        Route::post('message', 'LineNotifyController@message');
    });
    Route::post('callback', 'LineNotifyController@callback');
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'posts',
], function () {
    Route::get('/{postId}', 'PostController@show');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', 'PostController@store');
        Route::put('/{postId}', 'PostController@update');
        Route::delete('/{postId}', 'PostController@destroy');
    });
});


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

Route::prefix('v1')->group(function() {

    /** Auth routes */
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', 'api\v1\AuthController@login');
        Route::post('logout', 'api\v1\AuthController@logout');
        Route::post('refresh', 'api\v1\AuthController@refresh');
        Route::post('me', 'api\v1\AuthController@me');

    });

    /** POS terminal routes */
    Route::prefix('pos')->group(function() {
        Route::get('menuitem', 'api\v1\pos\MenuItemController@index');
    });
});

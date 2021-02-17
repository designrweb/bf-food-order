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


/**
 * Auth mobile app routes
 */
Route::group([
    'middleware' => 'api',
    'prefix'     => 'mobile',
    'namespace'  => 'api\mobile\v1',
], function ($router) {
    Route::prefix('v1')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::get('resend/{id}', 'AuthController@resend');

        Route::middleware('auth:api')->group(function () {
            Route::post('logout', 'AuthController@logout');
            Route::post('refresh', 'AuthController@refresh');
            Route::post('me', 'AuthController@me');

            // user routes
            Route::post('user/update', 'UserController@update');

            // consumers routes
            Route::get('consumers/{id}', 'ConsumerController@getOne');
            Route::get('consumers', 'ConsumerController@getAll');
            Route::post('consumers', 'ConsumerController@store');
            Route::put('consumers/{id}', 'ConsumerController@update');
            Route::delete('consumers/{id}', 'ConsumerController@destroy');

        });
    });
});


Route::prefix('v1')->group(function () {
    /**
     * POS terminal Auth routes
     */
    Route::group([
        'middleware' => 'api',
        'prefix'     => 'pos',
        'namespace'  => 'api\v1\pos',
    ], function ($router) {
        Route::post('user/login', 'AuthController@login');
        Route::get('user/data', 'AuthController@me');
        Route::post('logout', 'AuthController@logout');
    });

    /** POS terminal routes */
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'pos',
        'namespace'  => 'api\v1\pos',
    ], function () {
        Route::post('order/create', 'OrderController@create');
        Route::get('order/limit', 'OrderController@limit');
        Route::get('order/statistic', 'OrderController@statistic');

        Route::get('menuitem', 'MenuItemController@index');

        Route::get('history', 'HistoryController@index');

        Route::get('consumer', 'ConsumerController@index');
        Route::get('search/consumer', 'ConsumerController@searchByConsumer');
        Route::get('search/consumer-qr-code', 'ConsumerController@searchByQrCode');
    });
});

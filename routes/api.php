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

Route::prefix('v1')->group(function () {

    /** Auth routes */
    Route::group([
        'middleware' => 'api',
        'prefix'     => 'auth'
    ], function ($router) {
        Route::post('login', 'api\v1\AuthController@login');
        Route::post('logout', 'api\v1\AuthController@logout');
        Route::post('refresh', 'api\v1\AuthController@refresh');
        Route::post('me', 'api\v1\AuthController@me');

    });

    /** POS terminal Auth routes */
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

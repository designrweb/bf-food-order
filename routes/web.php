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
    return view('index');
});
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin');
    });

    /** users routes */
    Route::prefix('users')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'UserController@getAll')->name('users.get-all');
        Route::get('/get-structure', 'UserController@getIndexStructure')->name('users.index-structure');
        Route::get('/get-view-structure', 'UserController@getViewStructure')->name('users.view-structure');
        Route::get('/get-one/{id}', 'UserController@getOne')->name('users.get-one');
        Route::get('/', "UserController@index")->name('users.index')->middleware('checkRole:viewAny,App\User');
        Route::get('/create', 'UserController@create')->name('users.create')->middleware('checkRole:create,App\User');
        Route::post('/', "UserController@store")->name('users.store')->middleware('checkRole:create,App\User');
        Route::get('/{id}/edit', 'UserController@edit')->name('users.edit')->middleware('checkRole:update,App\User,id');
        Route::get('/{id}', 'UserController@show')->name('users.show')->middleware('checkRole:view,App\User,id');
        Route::put('/{id}', 'UserController@update')->name('users.update')->middleware('checkRole:update,App\User,id');
        Route::delete('/{id}', "UserController@destroy")->name('users.destroy')->middleware('checkRole:delete,App\User,id');
    });

    /** subsidization-organizations routes */
    Route::prefix('subsidization-organizations')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'SubsidizationOrganizationController@getAll')->name('subsidization-organizations.get-all');
        Route::get('/get-structure', 'SubsidizationOrganizationController@getIndexStructure')->name('subsidization-organizations.index-structure');
        Route::get('/get-view-structure', 'SubsidizationOrganizationController@getViewStructure')->name('subsidization-organizations.view-structure');
        Route::get('/get-one/{id}', 'SubsidizationOrganizationController@getOne')->name('subsidization-organizations.get-one');
        Route::get('/', "SubsidizationOrganizationController@index")->name('subsidization-organizations.index');
        Route::get('/create', 'SubsidizationOrganizationController@create')->name('subsidization-organizations.create');
        Route::post('/', "SubsidizationOrganizationController@store")->name('subsidization-organizations.store');
        Route::get('/{id}/edit', 'SubsidizationOrganizationController@edit')->name('subsidization-organizations.edit');
        Route::get('/{id}', 'SubsidizationOrganizationController@show')->name('subsidization-organizations.show');
        Route::put('/{id}', 'SubsidizationOrganizationController@update')->name('subsidization-organizations.update');
        Route::delete('/{id}', "SubsidizationOrganizationController@destroy")->name('subsidization-organizations.destroy');
    });

    /** menu-categories routes */
    Route::prefix('menu-categories')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'MenuCategoryController@getAll')->name('menu-categories.get-all');
        Route::get('/get-structure', 'MenuCategoryController@getIndexStructure')->name('menu-categories.index-structure');
        Route::get('/get-view-structure', 'MenuCategoryController@getViewStructure')->name('menu-categories.view-structure');
        Route::get('/get-one/{id}', 'MenuCategoryController@getOne')->name('menu-categories.get-one');
        Route::get('/', "MenuCategoryController@index")->name('menu-categories.index');
        Route::get('/create', 'MenuCategoryController@create')->name('menu-categories.create');
        Route::post('/', "MenuCategoryController@store")->name('menu-categories.store');
        Route::get('/{id}/edit', 'MenuCategoryController@edit')->name('menu-categories.edit');
        Route::get('/{id}', 'MenuCategoryController@show')->name('menu-categories.show');
        Route::put('/{id}', 'MenuCategoryController@update')->name('menu-categories.update');
        Route::delete('/{id}', "MenuCategoryController@destroy")->name('menu-categories.destroy');
    });

    /** vacations routes */
    Route::prefix('vacations')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'VacationController@getAll')->name('vacations.get-all');
        Route::get('/get-structure', 'VacationController@getIndexStructure')->name('vacations.index-structure');
        Route::get('/get-view-structure', 'VacationController@getViewStructure')->name('vacations.view-structure');
        Route::get('/get-one/{id}', 'VacationController@getOne')->name('vacations.get-one');
        Route::get('/', "VacationController@index")->name('vacations.index');
        Route::get('/create', 'VacationController@create')->name('vacations.create');
        Route::post('/', "VacationController@store")->name('vacations.store');
        Route::get('/{id}/edit', 'VacationController@edit')->name('vacations.edit');
        Route::get('/{id}', 'VacationController@show')->name('vacations.show');
        Route::put('/{id}', 'VacationController@update')->name('vacations.update');
        Route::delete('/{id}', "VacationController@destroy")->name('vacations.destroy');
    });

    /** locations routes */
    Route::prefix('locations')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'LocationController@getAll')->name('locations.get-all');
        Route::get('/get-structure', 'LocationController@getIndexStructure')->name('locations.index-structure');
        Route::get('/get-view-structure', 'LocationController@getViewStructure')->name('locations.view-structure');
        Route::get('/get-one/{id}', 'LocationController@getOne')->name('locations.get-one');
        Route::get('/', "LocationController@index")->name('locations.index');
        Route::get('/create', 'LocationController@create')->name('locations.create');
        Route::post('/', "LocationController@store")->name('locations.store');
        Route::get('/{id}/edit', 'LocationController@edit')->name('locations.edit');
        Route::get('/{id}', 'LocationController@show')->name('locations.show');
        Route::put('/{id}', 'LocationController@update')->name('locations.update');
        Route::delete('/{id}', "LocationController@destroy")->name('locations.destroy');
        Route::post('/{id}/update-image', "LocationController@updateImage")->name('locations.update-image');
        Route::post('/{id}/remove-image', "LocationController@removeImage")->name('locations.remove-image');
    });

    /** voucher-limits routes */
    Route::prefix('voucher-limits')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'VoucherLimitController@getAll')->name('voucher-limits.get-all');
        Route::get('/get-structure', 'VoucherLimitController@getIndexStructure')->name('voucher-limits.index-structure');
        Route::get('/get-view-structure', 'VoucherLimitController@getViewStructure')->name('voucher-limits.view-structure');
        Route::get('/get-one/{id}', 'VoucherLimitController@getOne')->name('voucher-limits.get-one');
        Route::get('/', "VoucherLimitController@index")->name('voucher-limits.index');
        Route::get('/create', 'VoucherLimitController@create')->name('voucher-limits.create');
        Route::post('/', "VoucherLimitController@store")->name('voucher-limits.store');
        Route::get('/{id}/edit', 'VoucherLimitController@edit')->name('voucher-limits.edit');
        Route::get('/{id}', 'VoucherLimitController@show')->name('voucher-limits.show');
        Route::put('/{id}', 'VoucherLimitController@update')->name('voucher-limits.update');
        Route::delete('/{id}', "VoucherLimitController@destroy")->name('voucher-limits.destroy');
    });

    /** menu-items routes */
    Route::prefix('menu-items')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'MenuItemController@getAll')->name('menu-items.get-all');
        Route::get('/get-structure', 'MenuItemController@getIndexStructure')->name('menu-items.index-structure');
        Route::get('/get-view-structure', 'MenuItemController@getViewStructure')->name('menu-items.view-structure');
        Route::get('/get-one/{id}', 'MenuItemController@getOne')->name('menu-items.get-one');
        Route::get('/', "MenuItemController@index")->name('menu-items.index');
        Route::get('/create', 'MenuItemController@create')->name('menu-items.create');
        Route::post('/', "MenuItemController@store")->name('menu-items.store');
        Route::get('/{id}/edit', 'MenuItemController@edit')->name('menu-items.edit');
        Route::get('/{id}', 'MenuItemController@show')->name('menu-items.show');
        Route::put('/{id}', 'MenuItemController@update')->name('menu-items.update');
        Route::delete('/{id}', "MenuItemController@destroy")->name('menu-items.destroy');
    });

    /** location-groups routes */
    Route::prefix('location-groups')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'LocationGroupController@getAll')->name('location-groups.get-all');
        Route::get('/get-structure', 'LocationGroupController@getIndexStructure')->name('location-groups.index-structure');
        Route::get('/get-view-structure', 'LocationGroupController@getViewStructure')->name('location-groups.view-structure');
        Route::get('/get-one/{id}', 'LocationGroupController@getOne')->name('location-groups.get-one');
        Route::get('/', "LocationGroupController@index")->name('location-groups.index');
        Route::get('/create', 'LocationGroupController@create')->name('location-groups.create');
        Route::post('/', "LocationGroupController@store")->name('location-groups.store');
        Route::get('/{id}/edit', 'LocationGroupController@edit')->name('location-groups.edit');
        Route::get('/{id}', 'LocationGroupController@show')->name('location-groups.show');
        Route::put('/{id}', 'LocationGroupController@update')->name('location-groups.update');
        Route::delete('/{id}', "LocationGroupController@destroy")->name('location-groups.destroy');
    });

    /** vacation-location-group routes */
    Route::prefix('vacation-location-group')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'VacationLocationGroupController@getAll')->name('vacation-location-group.get-all');
        Route::get('/get-structure', 'VacationLocationGroupController@getIndexStructure')->name('vacation-location-group.index-structure');
        Route::get('/get-view-structure', 'VacationLocationGroupController@getViewStructure')->name('vacation-location-group.view-structure');
        Route::get('/get-one/{id}', 'VacationLocationGroupController@getOne')->name('vacation-location-group.get-one');
        Route::get('/', "VacationLocationGroupController@index")->name('vacation-location-group.index');
        Route::get('/create', 'VacationLocationGroupController@create')->name('vacation-location-group.create');
        Route::post('/', "VacationLocationGroupController@store")->name('vacation-location-group.store');
        Route::get('/{id}/edit', 'VacationLocationGroupController@edit')->name('vacation-location-group.edit');
        Route::get('/{id}', 'VacationLocationGroupController@show')->name('vacation-location-group.show');
        Route::put('/{id}', 'VacationLocationGroupController@update')->name('vacation-location-group.update');
        Route::delete('/{id}', "VacationLocationGroupController@destroy")->name('vacation-location-group.destroy');
    });

    /** subsidized-menu-categories routes */
    Route::prefix('subsidized-menu-categories')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'SubsidizedMenuCategoriesController@getAll')->name('subsidized-menu-categories.get-all');
        Route::get('/get-structure', 'SubsidizedMenuCategoriesController@getIndexStructure')->name('subsidized-menu-categories.index-structure');
        Route::get('/get-view-structure', 'SubsidizedMenuCategoriesController@getViewStructure')->name('subsidized-menu-categories.view-structure');
        Route::get('/get-one/{id}', 'SubsidizedMenuCategoriesController@getOne')->name('subsidized-menu-categories.get-one');
        Route::get('/', "SubsidizedMenuCategoriesController@index")->name('subsidized-menu-categories.index');
        Route::get('/create', 'SubsidizedMenuCategoriesController@create')->name('subsidized-menu-categories.create');
        Route::post('/', "SubsidizedMenuCategoriesController@store")->name('subsidized-menu-categories.store');
        Route::get('/{id}/edit', 'SubsidizedMenuCategoriesController@edit')->name('subsidized-menu-categories.edit');
        Route::get('/{id}', 'SubsidizedMenuCategoriesController@show')->name('subsidized-menu-categories.show');
        Route::put('/{id}', 'SubsidizedMenuCategoriesController@update')->name('subsidized-menu-categories.update');
        Route::delete('/{id}', "SubsidizedMenuCategoriesController@destroy")->name('subsidized-menu-categories.destroy');
    });

    /** consumers routes */
    Route::prefix('consumers')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'ConsumerController@getAll')->name('consumers.get-all');
        Route::get('/get-structure', 'ConsumerController@getIndexStructure')->name('consumers.index-structure');
        Route::get('/get-view-structure', 'ConsumerController@getViewStructure')->name('consumers.view-structure');
        Route::get('/get-one/{id}', 'ConsumerController@getOne')->name('consumers.get-one');
        Route::get('/', "ConsumerController@index")->name('consumers.index');
        Route::get('/create', 'ConsumerController@create')->name('consumers.create');
        Route::post('/', "ConsumerController@store")->name('consumers.store');
        Route::get('/{id}/edit', 'ConsumerController@edit')->name('consumers.edit');
        Route::get('/{id}', 'ConsumerController@show')->name('consumers.show');
        Route::put('/{id}', 'ConsumerController@update')->name('consumers.update');
        Route::delete('/{id}', "ConsumerController@destroy")->name('consumers.destroy');
        Route::post('/{id}/update-image', "ConsumerController@updateImage")->name('consumers.update-image');
        Route::post('/{id}/remove-image', "ConsumerController@removeImage")->name('consumers.remove-image');
    });

    /** consumer-subsidizations routes */
    Route::prefix('consumer-subsidizations')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'ConsumerSubsidizationController@getAll')->name('consumer-subsidizations.get-all');
        Route::get('/get-structure', 'ConsumerSubsidizationController@getIndexStructure')->name('consumer-subsidizations.index-structure');
        Route::get('/get-view-structure', 'ConsumerSubsidizationController@getViewStructure')->name('consumer-subsidizations.view-structure');
        Route::get('/get-one/{id}', 'ConsumerSubsidizationController@getOne')->name('consumer-subsidizations.get-one');
        Route::get('/', "ConsumerSubsidizationController@index")->name('consumer-subsidizations.index');
        Route::get('/create', 'ConsumerSubsidizationController@create')->name('consumer-subsidizations.create');
        Route::post('/', "ConsumerSubsidizationController@store")->name('consumer-subsidizations.store');
        Route::get('/{id}/edit', 'ConsumerSubsidizationController@edit')->name('consumer-subsidizations.edit');
        Route::get('/{id}', 'ConsumerSubsidizationController@show')->name('consumer-subsidizations.show');
        Route::put('/{id}', 'ConsumerSubsidizationController@update')->name('consumer-subsidizations.update');
        Route::delete('/{id}', "ConsumerSubsidizationController@destroy")->name('consumer-subsidizations.destroy');
    });

    /** orders routes */
    Route::prefix('orders')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'OrderController@getAll')->name('orders.get-all');
        Route::get('/get-structure', 'OrderController@getIndexStructure')->name('orders.index-structure');
        Route::get('/get-view-structure', 'OrderController@getViewStructure')->name('orders.view-structure');
        Route::get('/get-one/{id}', 'OrderController@getOne')->name('orders.get-one');
        Route::get('/', "OrderController@index")->name('orders.index');
        Route::get('/create', 'OrderController@create')->name('orders.create');
        Route::post('/', "OrderController@store")->name('orders.store');
        Route::get('/{id}/edit', 'OrderController@edit')->name('orders.edit');
        Route::get('/{id}', 'OrderController@show')->name('orders.show');
        Route::put('/{id}', 'OrderController@update')->name('orders.update');
        Route::delete('/{id}', "OrderController@destroy")->name('orders.destroy');
    });

    /** consumer-auto-orders routes */
    Route::prefix('consumer-auto-orders')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'ConsumerAutoOrderController@getAll')->name('consumer-auto-orders.get-all');
        Route::get('/get-structure', 'ConsumerAutoOrderController@getIndexStructure')->name('consumer-auto-orders.index-structure');
        Route::get('/get-view-structure', 'ConsumerAutoOrderController@getViewStructure')->name('consumer-auto-orders.view-structure');
        Route::get('/get-one/{id}', 'ConsumerAutoOrderController@getOne')->name('consumer-auto-orders.get-one');
        Route::get('/', "ConsumerAutoOrderController@index")->name('consumer-auto-orders.index');
        Route::get('/create', 'ConsumerAutoOrderController@create')->name('consumer-auto-orders.create');
        Route::post('/', "ConsumerAutoOrderController@store")->name('consumer-auto-orders.store');
        Route::get('/{id}/edit', 'ConsumerAutoOrderController@edit')->name('consumer-auto-orders.edit');
        Route::get('/{id}', 'ConsumerAutoOrderController@show')->name('consumer-auto-orders.show');
        Route::put('/{id}', 'ConsumerAutoOrderController@update')->name('consumer-auto-orders.update');
        Route::delete('/{id}', "ConsumerAutoOrderController@destroy")->name('consumer-auto-orders.destroy');
    });

    /** payments routes */
    Route::prefix('payments')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'PaymentController@getAll')->name('payments.get-all');
        Route::get('/get-structure', 'PaymentController@getIndexStructure')->name('payments.index-structure');
        Route::get('/get-view-structure', 'PaymentController@getViewStructure')->name('payments.view-structure');
        Route::get('/get-one/{id}', 'PaymentController@getOne')->name('payments.get-one');
        Route::get('/', "PaymentController@index")->name('payments.index');
        Route::get('/create', 'PaymentController@create')->name('payments.create');
        Route::post('/', "PaymentController@store")->name('payments.store');
        Route::get('/{id}/edit', 'PaymentController@edit')->name('payments.edit');
        Route::get('/{id}', 'PaymentController@show')->name('payments.show');
        Route::put('/{id}', 'PaymentController@update')->name('payments.update');
        Route::delete('/{id}', "PaymentController@destroy")->name('payments.destroy');
    });

    /** consumer-qr-codes routes */
    Route::prefix('consumer-qr-codes')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'ConsumerQrCodeController@getAll')->name('consumer-qr-codes.get-all');
        Route::get('/get-structure', 'ConsumerQrCodeController@getIndexStructure')->name('consumer-qr-codes.index-structure');
        Route::get('/get-view-structure', 'ConsumerQrCodeController@getViewStructure')->name('consumer-qr-codes.view-structure');
        Route::get('/get-one/{id}', 'ConsumerQrCodeController@getOne')->name('consumer-qr-codes.get-one');
        Route::get('/', "ConsumerQrCodeController@index")->name('consumer-qr-codes.index');
        Route::get('/create', 'ConsumerQrCodeController@create')->name('consumer-qr-codes.create');
        Route::post('/', "ConsumerQrCodeController@store")->name('consumer-qr-codes.store');
        Route::get('/{id}/edit', 'ConsumerQrCodeController@edit')->name('consumer-qr-codes.edit');
        Route::get('/{id}', 'ConsumerQrCodeController@show')->name('consumer-qr-codes.show');
        Route::put('/{id}', 'ConsumerQrCodeController@update')->name('consumer-qr-codes.update');
        Route::delete('/{id}', "ConsumerQrCodeController@destroy")->name('consumer-qr-codes.destroy');
    });

    /** settings routes */
    Route::prefix('settings')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'SettingController@getAll')->name('settings.get-all');
        Route::get('/get-structure', 'SettingController@getIndexStructure')->name('settings.index-structure');
        Route::get('/get-view-structure', 'SettingController@getViewStructure')->name('settings.view-structure');
        Route::get('/get-one/{id}', 'SettingController@getOne')->name('settings.get-one');
        Route::get('/', "SettingController@index")->name('settings.index');
        Route::get('/create', 'SettingController@create')->name('settings.create');
        Route::post('/', "SettingController@store")->name('settings.store');
        Route::get('/{id}/edit', 'SettingController@edit')->name('settings.edit');
        Route::get('/{id}', 'SettingController@show')->name('settings.show');
        Route::put('/{id}', 'SettingController@update')->name('settings.update');
        Route::delete('/{id}', "SettingController@destroy")->name('settings.destroy');
    });

    /** subsidization-rules routes */
    Route::prefix('subsidization-rules')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'SubsidizationRuleController@getAll')->name('subsidization-rules.get-all');
        Route::get('/get-structure', 'SubsidizationRuleController@getIndexStructure')->name('subsidization-rules.index-structure');
        Route::get('/get-view-structure', 'SubsidizationRuleController@getViewStructure')->name('subsidization-rules.view-structure');
        Route::get('/get-one/{id}', 'SubsidizationRuleController@getOne')->name('subsidization-rules.get-one');
        Route::get('/', "SubsidizationRuleController@index")->name('subsidization-rules.index');
        Route::get('/create', 'SubsidizationRuleController@create')->name('subsidization-rules.create');
        Route::post('/', "SubsidizationRuleController@store")->name('subsidization-rules.store');
        Route::get('/{id}/edit', 'SubsidizationRuleController@edit')->name('subsidization-rules.edit');
        Route::get('/{id}', 'SubsidizationRuleController@show')->name('subsidization-rules.show');
        Route::put('/{id}', 'SubsidizationRuleController@update')->name('subsidization-rules.update');
        Route::delete('/{id}', "SubsidizationRuleController@destroy")->name('subsidization-rules.destroy');
    });

    /** companies routes */
    Route::prefix('companies')->middleware(['auth'])->group(function () {
        Route::get('/get-all', 'CompanyController@getAll')->name('companies.get-all');
        Route::get('/get-structure', 'CompanyController@getIndexStructure')->name('companies.index-structure');
        Route::get('/get-view-structure', 'CompanyController@getViewStructure')->name('companies.view-structure');
        Route::get('/get-one/{id}', 'CompanyController@getOne')->name('companies.get-one');
        Route::get('/', "CompanyController@index")->name('companies.index');
        Route::get('/create', 'CompanyController@create')->name('companies.create');
        Route::post('/', "CompanyController@store")->name('companies.store');
        Route::get('/{id}/edit', 'CompanyController@edit')->name('companies.edit');
        Route::get('/{id}', 'CompanyController@show')->name('companies.show');
        Route::put('/{id}', 'CompanyController@update')->name('companies.update');
        Route::delete('/{id}', "CompanyController@destroy")->name('companies.destroy');
    });

});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', 'HomeController@index')->name('profile.index');
    Route::post('/profile/update', 'HomeController@update')->name('profile.update');
});


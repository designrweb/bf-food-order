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
    return view('index');
});
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('admin');
    });

    /** users routes */
    Route::get('users/get-all', 'UserController@getAll')->name('users.get-all');
    Route::get('users/get-structure', 'UserController@getIndexStructure')->name('users.index-structure');
    Route::get('users/get-view-structure', 'UserController@getViewStructure')->name('users.view-structure');
    Route::get('users/get-one/{id}', 'UserController@getOne')->name('users.get-one');
    Route::get('users', "UserController@index")->name('users.index');
    Route::get('users/create', 'UserController@create')->name('users.create');
    Route::post('users', "UserController@store")->name('users.store');
    Route::get('users/{id}/edit', 'UserController@edit')->name('users.edit');
    Route::get('users/{id}', 'UserController@show')->name('users.show');
    Route::put('users/{id}', 'UserController@update')->name('users.update');
    Route::delete('users/{id}', "UserController@destroy")->name('users.destroy');

    /** subsidization-organizations routes */
    Route::get('subsidization-organizations/get-all', 'SubsidizationOrganizationController@getAll')->name('subsidization-organizations.get-all');
    Route::get('subsidization-organizations/get-structure', 'SubsidizationOrganizationController@getIndexStructure')->name('subsidization-organizations.index-structure');
    Route::get('subsidization-organizations/get-view-structure', 'SubsidizationOrganizationController@getViewStructure')->name('subsidization-organizations.view-structure');
    Route::get('subsidization-organizations/get-one/{id}', 'SubsidizationOrganizationController@getOne')->name('subsidization-organizations.get-one');
    Route::get('subsidization-organizations', "SubsidizationOrganizationController@index")->name('subsidization-organizations.index');
    Route::get('subsidization-organizations/create', 'SubsidizationOrganizationController@create')->name('subsidization-organizations.create');
    Route::post('subsidization-organizations', "SubsidizationOrganizationController@store")->name('subsidization-organizations.store');
    Route::get('subsidization-organizations/{id}/edit', 'SubsidizationOrganizationController@edit')->name('subsidization-organizations.edit');
    Route::get('subsidization-organizations/{id}', 'SubsidizationOrganizationController@show')->name('subsidization-organizations.show');
    Route::put('subsidization-organizations/{id}', 'SubsidizationOrganizationController@update')->name('subsidization-organizations.update');
    Route::delete('subsidization-organizations/{id}', "SubsidizationOrganizationController@destroy")->name('subsidization-organizations.destroy');

    /** menu-categories routes */
    Route::get('menu-categories/get-all', 'MenuCategoryController@getAll')->name('menu-categories.get-all');
    Route::get('menu-categories/get-structure', 'MenuCategoryController@getIndexStructure')->name('menu-categories.index-structure');
    Route::get('menu-categories/get-view-structure', 'MenuCategoryController@getViewStructure')->name('menu-categories.view-structure');
    Route::get('menu-categories/get-one/{id}', 'MenuCategoryController@getOne')->name('menu-categories.get-one');
    Route::get('menu-categories', "MenuCategoryController@index")->name('menu-categories.index');
    Route::get('menu-categories/create', 'MenuCategoryController@create')->name('menu-categories.create');
    Route::post('menu-categories', "MenuCategoryController@store")->name('menu-categories.store');
    Route::get('menu-categories/{id}/edit', 'MenuCategoryController@edit')->name('menu-categories.edit');
    Route::get('menu-categories/{id}', 'MenuCategoryController@show')->name('menu-categories.show');
    Route::put('menu-categories/{id}', 'MenuCategoryController@update')->name('menu-categories.update');
    Route::delete('menu-categories/{id}', "MenuCategoryController@destroy")->name('menu-categories.destroy');

    /** vacations routes */
    Route::get('vacations/get-all', 'VacationController@getAll')->name('vacations.get-all');
    Route::get('vacations/get-structure', 'VacationController@getIndexStructure')->name('vacations.index-structure');
    Route::get('vacations/get-view-structure', 'VacationController@getViewStructure')->name('vacations.view-structure');
    Route::get('vacations/get-one/{id}', 'VacationController@getOne')->name('vacations.get-one');
    Route::get('vacations', "VacationController@index")->name('vacations.index');
    Route::get('vacations/create', 'VacationController@create')->name('vacations.create');
    Route::post('vacations', "VacationController@store")->name('vacations.store');
    Route::get('vacations/{id}/edit', 'VacationController@edit')->name('vacations.edit');
    Route::get('vacations/{id}', 'VacationController@show')->name('vacations.show');
    Route::put('vacations/{id}', 'VacationController@update')->name('vacations.update');
    Route::delete('vacations/{id}', "VacationController@destroy")->name('vacations.destroy');

    /** locations routes */
    Route::get('locations/get-all', 'LocationController@getAll')->name('locations.get-all');
    Route::get('locations/get-structure', 'LocationController@getIndexStructure')->name('locations.index-structure');
    Route::get('locations/get-view-structure', 'LocationController@getViewStructure')->name('locations.view-structure');
    Route::get('locations/get-one/{id}', 'LocationController@getOne')->name('locations.get-one');
    Route::get('locations', "LocationController@index")->name('locations.index');
    Route::get('locations/create', 'LocationController@create')->name('locations.create');
    Route::post('locations', "LocationController@store")->name('locations.store');
    Route::get('locations/{id}/edit', 'LocationController@edit')->name('locations.edit');
    Route::get('locations/{id}', 'LocationController@show')->name('locations.show');
    Route::put('locations/{id}', 'LocationController@update')->name('locations.update');
    Route::delete('locations/{id}', "LocationController@destroy")->name('locations.destroy');

    /** voucher-limits routes */
    Route::get('voucher-limits/get-all', 'VoucherLimitController@getAll')->name('voucher-limits.get-all');
    Route::get('voucher-limits/get-structure', 'VoucherLimitController@getIndexStructure')->name('voucher-limits.index-structure');
    Route::get('voucher-limits/get-view-structure', 'VoucherLimitController@getViewStructure')->name('voucher-limits.view-structure');
    Route::get('voucher-limits/get-one/{id}', 'VoucherLimitController@getOne')->name('voucher-limits.get-one');
    Route::get('voucher-limits', "VoucherLimitController@index")->name('voucher-limits.index');
    Route::get('voucher-limits/create', 'VoucherLimitController@create')->name('voucher-limits.create');
    Route::post('voucher-limits', "VoucherLimitController@store")->name('voucher-limits.store');
    Route::get('voucher-limits/{id}/edit', 'VoucherLimitController@edit')->name('voucher-limits.edit');
    Route::get('voucher-limits/{id}', 'VoucherLimitController@show')->name('voucher-limits.show');
    Route::put('voucher-limits/{id}', 'VoucherLimitController@update')->name('voucher-limits.update');
    Route::delete('voucher-limits/{id}', "VoucherLimitController@destroy")->name('voucher-limits.destroy');

    /** menu-items routes */
    Route::get('menu-items/get-all', 'MenuItemController@getAll')->name('menu-items.get-all');
    Route::get('menu-items/get-structure', 'MenuItemController@getIndexStructure')->name('menu-items.index-structure');
    Route::get('menu-items/get-view-structure', 'MenuItemController@getViewStructure')->name('menu-items.view-structure');
    Route::get('menu-items/get-one/{id}', 'MenuItemController@getOne')->name('menu-items.get-one');
    Route::get('menu-items', "MenuItemController@index")->name('menu-items.index');
    Route::get('menu-items/create', 'MenuItemController@create')->name('menu-items.create');
    Route::post('menu-items', "MenuItemController@store")->name('menu-items.store');
    Route::get('menu-items/{id}/edit', 'MenuItemController@edit')->name('menu-items.edit');
    Route::get('menu-items/{id}', 'MenuItemController@show')->name('menu-items.show');
    Route::put('menu-items/{id}', 'MenuItemController@update')->name('menu-items.update');
    Route::delete('menu-items/{id}', "MenuItemController@destroy")->name('menu-items.destroy');

    /** location-groups routes */
    Route::get('location-groups/get-all', 'LocationGroupController@getAll')->name('location-groups.get-all');
    Route::get('location-groups/get-structure', 'LocationGroupController@getIndexStructure')->name('location-groups.index-structure');
    Route::get('location-groups/get-view-structure', 'LocationGroupController@getViewStructure')->name('location-groups.view-structure');
    Route::get('location-groups/get-one/{id}', 'LocationGroupController@getOne')->name('location-groups.get-one');
    Route::get('location-groups', "LocationGroupController@index")->name('location-groups.index');
    Route::get('location-groups/create', 'LocationGroupController@create')->name('location-groups.create');
    Route::post('location-groups', "LocationGroupController@store")->name('location-groups.store');
    Route::get('location-groups/{id}/edit', 'LocationGroupController@edit')->name('location-groups.edit');
    Route::get('location-groups/{id}', 'LocationGroupController@show')->name('location-groups.show');
    Route::put('location-groups/{id}', 'LocationGroupController@update')->name('location-groups.update');
    Route::delete('location-groups/{id}', "LocationGroupController@destroy")->name('location-groups.destroy');

    /** vacation-location-group routes */
    Route::get('vacation-location-group/get-all', 'VacationLocationGroupController@getAll')->name('vacation-location-group.get-all');
    Route::get('vacation-location-group/get-structure', 'VacationLocationGroupController@getIndexStructure')->name('vacation-location-group.index-structure');
    Route::get('vacation-location-group/get-view-structure', 'VacationLocationGroupController@getViewStructure')->name('vacation-location-group.view-structure');
    Route::get('vacation-location-group/get-one/{id}', 'VacationLocationGroupController@getOne')->name('vacation-location-group.get-one');
    Route::get('vacation-location-group', "VacationLocationGroupController@index")->name('vacation-location-group.index');
    Route::get('vacation-location-group/create', 'VacationLocationGroupController@create')->name('vacation-location-group.create');
    Route::post('vacation-location-group', "VacationLocationGroupController@store")->name('vacation-location-group.store');
    Route::get('vacation-location-group/{id}/edit', 'VacationLocationGroupController@edit')->name('vacation-location-group.edit');
    Route::get('vacation-location-group/{id}', 'VacationLocationGroupController@show')->name('vacation-location-group.show');
    Route::put('vacation-location-group/{id}', 'VacationLocationGroupController@update')->name('vacation-location-group.update');
    Route::delete('vacation-location-group/{id}', "VacationLocationGroupController@destroy")->name('vacation-location-group.destroy');

    /** subsidized-menu-categories routes */
    Route::get('subsidized-menu-categories/get-all', 'SubsidizedMenuCategoriesController@getAll')->name('subsidized-menu-categories.get-all');
    Route::get('subsidized-menu-categories/get-structure', 'SubsidizedMenuCategoriesController@getIndexStructure')->name('subsidized-menu-categories.index-structure');
    Route::get('subsidized-menu-categories/get-view-structure', 'SubsidizedMenuCategoriesController@getViewStructure')->name('subsidized-menu-categories.view-structure');
    Route::get('subsidized-menu-categories/get-one/{id}', 'SubsidizedMenuCategoriesController@getOne')->name('subsidized-menu-categories.get-one');
    Route::get('subsidized-menu-categories', "SubsidizedMenuCategoriesController@index")->name('subsidized-menu-categories.index');
    Route::get('subsidized-menu-categories/create', 'SubsidizedMenuCategoriesController@create')->name('subsidized-menu-categories.create');
    Route::post('subsidized-menu-categories', "SubsidizedMenuCategoriesController@store")->name('subsidized-menu-categories.store');
    Route::get('subsidized-menu-categories/{id}/edit', 'SubsidizedMenuCategoriesController@edit')->name('subsidized-menu-categories.edit');
    Route::get('subsidized-menu-categories/{id}', 'SubsidizedMenuCategoriesController@show')->name('subsidized-menu-categories.show');
    Route::put('subsidized-menu-categories/{id}', 'SubsidizedMenuCategoriesController@update')->name('subsidized-menu-categories.update');
    Route::delete('subsidized-menu-categories/{id}', "SubsidizedMenuCategoriesController@destroy")->name('subsidized-menu-categories.destroy');

    /** consumers routes */
    Route::get('consumers/get-all', 'ConsumerController@getAll')->name('consumers.get-all');
    Route::get('consumers/get-structure', 'ConsumerController@getIndexStructure')->name('consumers.index-structure');
    Route::get('consumers/get-view-structure', 'ConsumerController@getViewStructure')->name('consumers.view-structure');
    Route::get('consumers/get-one/{id}', 'ConsumerController@getOne')->name('consumers.get-one');
    Route::get('consumers', "ConsumerController@index")->name('consumers.index');
    Route::get('consumers/create', 'ConsumerController@create')->name('consumers.create');
    Route::post('consumers', "ConsumerController@store")->name('consumers.store');
    Route::get('consumers/{id}/edit', 'ConsumerController@edit')->name('consumers.edit');
    Route::get('consumers/{id}', 'ConsumerController@show')->name('consumers.show');
    Route::put('consumers/{id}', 'ConsumerController@update')->name('consumers.update');
    Route::delete('consumers/{id}', "ConsumerController@destroy")->name('consumers.destroy');
    Route::post('consumers/{id}/update-image', "ConsumerController@updateImage")->name('consumers.update-image');
    Route::post('consumers/{id}/remove-image', "ConsumerController@removeImage")->name('consumers.remove-image');

    /** consumer-subsidizations routes */
    Route::get('consumer-subsidizations/get-all', 'ConsumerSubsidizationController@getAll')->name('consumer-subsidizations.get-all');
    Route::get('consumer-subsidizations/get-structure', 'ConsumerSubsidizationController@getIndexStructure')->name('consumer-subsidizations.index-structure');
    Route::get('consumer-subsidizations/get-view-structure', 'ConsumerSubsidizationController@getViewStructure')->name('consumer-subsidizations.view-structure');
    Route::get('consumer-subsidizations/get-one/{id}', 'ConsumerSubsidizationController@getOne')->name('consumer-subsidizations.get-one');
    Route::get('consumer-subsidizations', "ConsumerSubsidizationController@index")->name('consumer-subsidizations.index');
    Route::get('consumer-subsidizations/create', 'ConsumerSubsidizationController@create')->name('consumer-subsidizations.create');
    Route::post('consumer-subsidizations', "ConsumerSubsidizationController@store")->name('consumer-subsidizations.store');
    Route::get('consumer-subsidizations/{id}/edit', 'ConsumerSubsidizationController@edit')->name('consumer-subsidizations.edit');
    Route::get('consumer-subsidizations/{id}', 'ConsumerSubsidizationController@show')->name('consumer-subsidizations.show');
    Route::put('consumer-subsidizations/{id}', 'ConsumerSubsidizationController@update')->name('consumer-subsidizations.update');
    Route::delete('consumer-subsidizations/{id}', "ConsumerSubsidizationController@destroy")->name('consumer-subsidizations.destroy');


    /** orders routes */
    Route::get('orders/get-all', 'OrderController@getAll')->name('orders.get-all');
    Route::get('orders/get-structure', 'OrderController@getIndexStructure')->name('orders.index-structure');
    Route::get('orders/get-view-structure', 'OrderController@getViewStructure')->name('orders.view-structure');
    Route::get('orders/get-one/{id}', 'OrderController@getOne')->name('orders.get-one');
    Route::get('orders', "OrderController@index")->name('orders.index');
    Route::get('orders/create', 'OrderController@create')->name('orders.create');
    Route::post('orders', "OrderController@store")->name('orders.store');
    Route::get('orders/{id}/edit', 'OrderController@edit')->name('orders.edit');
    Route::get('orders/{id}', 'OrderController@show')->name('orders.show');
    Route::put('orders/{id}', 'OrderController@update')->name('orders.update');
    Route::delete('orders/{id}', "OrderController@destroy")->name('orders.destroy');

    /** consumer-auto-orders routes */
    Route::get('consumer-auto-orders/get-all', 'ConsumerAutoOrderController@getAll')->name('consumer-auto-orders.get-all');
    Route::get('consumer-auto-orders/get-structure', 'ConsumerAutoOrderController@getIndexStructure')->name('consumer-auto-orders.index-structure');
    Route::get('consumer-auto-orders/get-view-structure', 'ConsumerAutoOrderController@getViewStructure')->name('consumer-auto-orders.view-structure');
    Route::get('consumer-auto-orders/get-one/{id}', 'ConsumerAutoOrderController@getOne')->name('consumer-auto-orders.get-one');
    Route::get('consumer-auto-orders', "ConsumerAutoOrderController@index")->name('consumer-auto-orders.index');
    Route::get('consumer-auto-orders/create', 'ConsumerAutoOrderController@create')->name('consumer-auto-orders.create');
    Route::post('consumer-auto-orders', "ConsumerAutoOrderController@store")->name('consumer-auto-orders.store');
    Route::get('consumer-auto-orders/{id}/edit', 'ConsumerAutoOrderController@edit')->name('consumer-auto-orders.edit');
    Route::get('consumer-auto-orders/{id}', 'ConsumerAutoOrderController@show')->name('consumer-auto-orders.show');
    Route::put('consumer-auto-orders/{id}', 'ConsumerAutoOrderController@update')->name('consumer-auto-orders.update');
    Route::delete('consumer-auto-orders/{id}', "ConsumerAutoOrderController@destroy")->name('consumer-auto-orders.destroy');

    /** payments routes */
    Route::get('payments/get-all', 'PaymentController@getAll')->name('payments.get-all');
    Route::get('payments/get-structure', 'PaymentController@getIndexStructure')->name('payments.index-structure');
    Route::get('payments/get-view-structure', 'PaymentController@getViewStructure')->name('payments.view-structure');
    Route::get('payments/get-one/{id}', 'PaymentController@getOne')->name('payments.get-one');
    Route::get('payments', "PaymentController@index")->name('payments.index');
    Route::get('payments/create', 'PaymentController@create')->name('payments.create');
    Route::post('payments', "PaymentController@store")->name('payments.store');
    Route::get('payments/{id}/edit', 'PaymentController@edit')->name('payments.edit');
    Route::get('payments/{id}', 'PaymentController@show')->name('payments.show');
    Route::put('payments/{id}', 'PaymentController@update')->name('payments.update');
    Route::delete('payments/{id}', "PaymentController@destroy")->name('payments.destroy');

    /** consumer-qr-codes routes */
    Route::get('consumer-qr-codes/get-all', 'ConsumerQrCodeController@getAll')->name('consumer-qr-codes.get-all');
    Route::get('consumer-qr-codes/get-structure', 'ConsumerQrCodeController@getIndexStructure')->name('consumer-qr-codes.index-structure');
    Route::get('consumer-qr-codes/get-view-structure', 'ConsumerQrCodeController@getViewStructure')->name('consumer-qr-codes.view-structure');
    Route::get('consumer-qr-codes/get-one/{id}', 'ConsumerQrCodeController@getOne')->name('consumer-qr-codes.get-one');
    Route::get('consumer-qr-codes', "ConsumerQrCodeController@index")->name('consumer-qr-codes.index');
    Route::get('consumer-qr-codes/create', 'ConsumerQrCodeController@create')->name('consumer-qr-codes.create');
    Route::post('consumer-qr-codes', "ConsumerQrCodeController@store")->name('consumer-qr-codes.store');
    Route::get('consumer-qr-codes/{id}/edit', 'ConsumerQrCodeController@edit')->name('consumer-qr-codes.edit');
    Route::get('consumer-qr-codes/{id}', 'ConsumerQrCodeController@show')->name('consumer-qr-codes.show');
    Route::put('consumer-qr-codes/{id}', 'ConsumerQrCodeController@update')->name('consumer-qr-codes.update');
    Route::delete('consumer-qr-codes/{id}', "ConsumerQrCodeController@destroy")->name('consumer-qr-codes.destroy');

    /** settings routes */
    Route::get('settings/get-all', 'SettingController@getAll')->name('settings.get-all');
    Route::get('settings/get-structure', 'SettingController@getIndexStructure')->name('settings.index-structure');
    Route::get('settings/get-view-structure', 'SettingController@getViewStructure')->name('settings.view-structure');
    Route::get('settings/get-one/{id}', 'SettingController@getOne')->name('settings.get-one');
    Route::get('settings', "SettingController@index")->name('settings.index');
    Route::get('settings/create', 'SettingController@create')->name('settings.create');
    Route::post('settings', "SettingController@store")->name('settings.store');
    Route::get('settings/{id}/edit', 'SettingController@edit')->name('settings.edit');
    Route::get('settings/{id}', 'SettingController@show')->name('settings.show');
    Route::put('settings/{id}', 'SettingController@update')->name('settings.update');
    Route::delete('settings/{id}', "SettingController@destroy")->name('settings.destroy');

    /** subsidization-rules routes */
    Route::get('subsidization-rules/get-all', 'SubsidizationRuleController@getAll')->name('subsidization-rules.get-all');
    Route::get('subsidization-rules/get-structure', 'SubsidizationRuleController@getIndexStructure')->name('subsidization-rules.index-structure');
    Route::get('subsidization-rules/get-view-structure', 'SubsidizationRuleController@getViewStructure')->name('subsidization-rules.view-structure');
    Route::get('subsidization-rules/get-one/{id}', 'SubsidizationRuleController@getOne')->name('subsidization-rules.get-one');
    Route::get('subsidization-rules', "SubsidizationRuleController@index")->name('subsidization-rules.index');
    Route::get('subsidization-rules/create', 'SubsidizationRuleController@create')->name('subsidization-rules.create');
    Route::post('subsidization-rules', "SubsidizationRuleController@store")->name('subsidization-rules.store');
    Route::get('subsidization-rules/{id}/edit', 'SubsidizationRuleController@edit')->name('subsidization-rules.edit');
    Route::get('subsidization-rules/{id}', 'SubsidizationRuleController@show')->name('subsidization-rules.show');
    Route::put('subsidization-rules/{id}', 'SubsidizationRuleController@update')->name('subsidization-rules.update');
    Route::delete('subsidization-rules/{id}', "SubsidizationRuleController@destroy")->name('subsidization-rules.destroy');

    /** companies routes */
    Route::get('companies/get-all', 'CompanyController@getAll')->name('companies.get-all');
    Route::get('companies/get-structure', 'CompanyController@getIndexStructure')->name('companies.index-structure');
    Route::get('companies/get-view-structure', 'CompanyController@getViewStructure')->name('companies.view-structure');
    Route::get('companies/get-one/{id}', 'CompanyController@getOne')->name('companies.get-one');
    Route::get('companies', "CompanyController@index")->name('companies.index');
    Route::get('companies/create', 'CompanyController@create')->name('companies.create');
    Route::post('companies', "CompanyController@store")->name('companies.store');
    Route::get('companies/{id}/edit', 'CompanyController@edit')->name('companies.edit');
    Route::get('companies/{id}', 'CompanyController@show')->name('companies.show');
    Route::put('companies/{id}', 'CompanyController@update')->name('companies.update');
    Route::delete('companies/{id}', "CompanyController@destroy")->name('companies.destroy');

});

Auth::routes();
// TODO: remove home controller parts
Route::get('/home', 'HomeController@index')->name('home');

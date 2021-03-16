<?php

namespace App\Providers;

use App\Http\ViewComposers\CompanySettingCompose;
use App\Http\ViewComposers\ConsumerCompose;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 *
 * @package App\Providers
 */
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.*', CompanySettingCompose::class
        );
        View::composer('layouts.*', ConsumerCompose::class);
    }
}

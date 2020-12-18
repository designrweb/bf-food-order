<?php

namespace App\Http\ViewComposers;

use App\Services\ImageService;
use Illuminate\View\View;

/**
 * Class CompanySettingCompose
 *
 * @package App\Http\ViewComposers
 */
class CompanySettingCompose
{

    /**
     * CompanySettingCompose constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $settings = auth()->user()->userCompany->company->settings->keyBy('setting_name')
            ->transform(function ($setting) {
                return $setting->value;
            })->toArray();

        $themeColor        = !empty($settings['theme_color']) ? $settings['theme_color'] : '#96c11f';
        $sidebarThemeColor = !empty($settings['sidebar_theme_color']) ? $settings['sidebar_theme_color'] : '#96c11f';
        $companyLogo       = !empty($settings['logo']) ? ImageService::decrypt($settings['logo']) : asset(config('adminlte.logo_img_xl'));

        $view->with('themeColor', $themeColor);
        $view->with('sidebarThemeColor', $sidebarThemeColor);
        $view->with('companyLogo', $companyLogo);
    }
}
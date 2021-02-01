<?php

namespace App\Http\ViewComposers;

use App\Company;
use App\Setting;
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
        $settings = !empty(auth()->user()) && auth()->user()->company_id ? Setting::where('company_id', auth()->user()->company_id)->get()->keyBy('setting_name')
            ->transform(function ($setting) {
                return $setting->value;
            })->toArray() : [];

        $themeColor            = !empty($settings['theme_color']) ? $settings['theme_color'] : Setting::DEFAULT_THEME_COLOR;
        $sidebarThemeColor     = !empty($settings['sidebar_theme_color']) ? $settings['sidebar_theme_color'] : Setting::DEFAULT_SIDEBAR_THEME_COLOR;
        $companyLogo           = !empty($settings['logo']) ? asset(Setting::IMAGE_FOLDER . DIRECTORY_SEPARATOR . $settings['logo']) : asset(config('adminlte.logo_img_xl'));
        $themeColorRgba        = $this->hex2rgba($themeColor);
        $sidebarThemeColorRgba = $this->hex2rgba($sidebarThemeColor);
        $companiesList         = Company::all();
        $selectedCompany       = !empty(auth()->user()->company_id) ? Company::find(auth()->user()->company_id) : [];

        $view->with('themeColor', $themeColor);
        $view->with('themeColorRgba', $themeColorRgba);
        $view->with('sidebarThemeColor', $sidebarThemeColor);
        $view->with('sidebarThemeColorRgba', $sidebarThemeColorRgba);
        $view->with('companyLogo', $companyLogo);
        $view->with('companiesList', $companiesList);
        $view->with('selectedCompany', $selectedCompany);
    }

    /**
     * @param       $color
     * @return string
     */
    public function hex2rgba($color): string
    {
        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if (empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
        } elseif (strlen($color) == 3) {
            $hex = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        //Return rgb(a) color string
        return implode(",", $rgb);
    }

}

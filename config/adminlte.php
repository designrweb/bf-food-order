<?php

use Illuminate\Support\Facades\Gate;

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
    |
    */

    'title'         => 'FoodOrder',
    'title_prefix'  => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
    |
    */

    'use_ico_only'     => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
    |
    */

    'logo'              => '',
    'logo_img'          => '/image/logo_small.png',
    'logo_img_class'    => 'brand-image img-circle elevation-3',
    'logo_img_xl'       => '/image/logo_small.png',
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt'      => 'FoodOrder',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
    |
    */

    'usermenu_enabled'      => true,
    'usermenu_header'       => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image'        => false,
    'usermenu_desc'         => false,
    'usermenu_profile_url'  => false,
    'switch_company'        => true,
    'switch_consumer'       => true,
    'session_consumer_key'  => 'consumerId',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#71-layout
    |
    */

    'layout_topnav'        => null,
    'layout_boxed'         => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar'  => null,
    'layout_fixed_footer'  => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#721-authentication-views-classes
    |
    */

    'classes_auth_card'   => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body'   => '',
    'classes_auth_footer' => '',
    'classes_auth_icon'   => '',
    'classes_auth_btn'    => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#722-admin-panel-classes
    |
    */

    'classes_body'             => '',
    'classes_brand'            => '',
    'classes_brand_text'       => '',
    'classes_content_wrapper'  => '',
    'classes_content_header'   => '',
    'classes_content'          => '',
    'classes_sidebar'          => 'sidebar-light-success elevation-1',
    'classes_sidebar_nav'      => 'nav-child-indent',
    'classes_topnav'           => 'navbar-white navbar-light',
    'classes_topnav_nav'       => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#73-sidebar
    |
    */

    'sidebar_mini'                            => true,
    'sidebar_collapse'                        => false,
    'sidebar_collapse_auto_size'              => true,
    'sidebar_collapse_remember'               => true,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme'                 => 'os-theme-light',
    'sidebar_scrollbar_auto_hide'             => 'l',
    'sidebar_nav_accordion'                   => true,
    'sidebar_nav_animation_speed'             => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#74-control-sidebar-right-sidebar
    |
    */

    'right_sidebar'                     => false,
    'right_sidebar_icon'                => 'fas fa-cogs',
    'right_sidebar_theme'               => 'dark',
    'right_sidebar_slide'               => true,
    'right_sidebar_push'                => true,
    'right_sidebar_scrollbar_theme'     => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-urls
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => 'register',

    'password_reset_url' => 'password/reset',

    'password_email_url' => 'password/email',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#92-laravel-mix
    |
    */

    'enabled_laravel_mix'  => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path'  => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#8-menu-configuration
    |
    */

    'menu' => [
        [
            'text'    => 'Companies',
            'route'   => 'companies.index',
            'icon'    => 'nav-icon fa fa-building',
            'can'     => ['menu-Company'],
            'active'  => ['*admin/companies*'],
            'classes' => 'admin-companies-menu'
        ],
        [
            'text'    => 'Locations',
            'route'   => 'locations.index',
            'icon'    => 'nav-icon fa fa-map-marked',
            'can'     => ['menu-Location'],
            'active'  => ['*admin/locations*'],
            'classes' => 'admin-locations-menu'
        ],
        [
            'text'    => 'Groups',
            'route'   => 'location-groups.index',
            'icon'    => 'nav-icon fa fa-object-ungroup',
            'can'     => ['menu-LocationGroup'],
            'active'  => ['*admin/location-groups*'],
            'classes' => 'admin-location-groups-menu'
        ],
        [
            'text'    => 'Administrators',
            'route'   => 'administrators.index',
            'icon'    => 'nav-icon fa fa-user-shield',
            'can'     => ['menu-User'],
            'classes' => 'admin-administrators-menu'
        ],
        [
            'text'    => 'Users',
            'route'   => 'users.index',
            'icon'    => 'nav-icon fa fa-user-friends',
            'can'     => ['menu-User'],
            'active'  => ['*admin/users*'],
            'classes' => 'admin-administrators-menu'
        ],
        [
            'text'    => 'Children',
            'route'   => 'consumers.index',
            'icon'    => 'nav-icon fa fa-users',
            'can'     => ['menu-Consumer'],
            'active'  => ['*admin/consumers*'],
            'classes' => 'admin-consumers-menu'
        ],
        [
            'text'    => 'Payments',
            'icon'    => 'fas fa-fw fa-euro-sign',
            'can'     => ['menu-Payment'],
            'classes' => 'admin-payments-menu',
            'submenu' => [
                [
                    'text'    => 'Bank Transactions',
                    'route'   => 'payments.bank-transactions',
                    'icon'    => 'fa fa-exchange-alt',
                    'active'  => ['*payments/bank-transactions'],
                    'classes' => 'admin-bank-transactions-menu',
                ],
                [
                    'text'    => 'Meal Orders',
                    'route'   => 'payments.meal-orders',
                    'icon'    => 'fa fa-hamburger',
                    'active'  => ['*payments/meal-orders'],
                    'classes' => 'admin-meal-orders-menu',
                ],
                [
                    'text'    => 'Add Payment',
                    'route'   => 'payments.create',
                    'icon'    => 'fa fa-handshake',
                    'active'  => ['*payments/create'],
                    'classes' => 'admin-add-payment-menu',
                ],
                [
                    'text'    => 'Payment Dumps',
                    'route'   => 'payment-dumps.index',
                    'icon'    => 'fa fa-piggy-bank',
                    'active'  => ['*payment-dumps'],
                    'classes' => 'admin-payment-dumps-menu',
                ],
            ],
        ],
        [
            'text'    => 'Subsidization',
            'icon'    => 'nav-icon fa fa-hand-holding-heart',
            'can'     => ['menu-SubsidizationOrganization', 'menu-SubsidizationRule'],
            'active'  => ['*admin/subsidization-organizations*', '*admin/subsidization-rules*'],
            'classes' => 'admin-subsidization-menu',
            'submenu' => [
                [
                    'text'    => 'Organizations',
                    'route'   => 'subsidization-organizations.index',
                    'icon'    => 'nav-icon fa fa-landmark',
                    'active'  => ['*subsidization-organizations*'],
                    'can'     => ['menu-SubsidizationOrganization'],
                    'classes' => 'admin-subsidization-organizations-menu',
                ],
                [
                    'text'    => 'Rules',
                    'route'   => 'subsidization-rules.index',
                    'icon'    => 'nav-icon fa fa-percent',
                    'active'  => ['*subsidization-rules*'],
                    'can'     => ['menu-SubsidizationRule'],
                    'classes' => 'admin-subsidization-rules-menu',
                ],
            ],
        ],
        [
            'text'    => 'Menu Categories',
            'route'   => 'menu-categories.index',
            'icon'    => 'nav-icon fas fa-book-open',
            'can'     => ['menu-MenuCategory'],
            'active'  => ['*admin/menu-categories*'],
            'classes' => 'admin-menu-categories-menu',
        ],
        [
            'text'    => 'Menu Items',
            'route'   => 'menu-items.index',
            'icon'    => 'nav-icon fa fa-utensils',
            'can'     => ['menu-MenuItem'],
            'active'  => ['*admin/menu-items*'],
            'classes' => 'admin-menu-items-menu',
        ],
        [
            'text'    => 'Catering',
            'icon'    => 'nav-icon fa fa-shopping-basket',
            'can'     => ['menu-CateringCategory', 'menu-CateringItem'],
            'classes' => 'admin-catering-menu',
            'submenu' => [
                [
                    'text'    => 'Catering Categories',
                    'route'   => 'catering-categories.index',
                    'icon'    => 'nav-icon fas fa-cookie-bite',
                    'can'     => ['menu-CateringCategory'],
                    'active'  => ['*catering-categories*'],
                    'classes' => 'admin-menu-categories-menu',
                ],
                [
                    'text'    => 'Catering Items',
                    'route'   => 'catering-items.index',
                    'icon'    => 'nav-icon fa fa-coffee',
                    'can'     => ['menu-CateringItem'],
                    'active'  => ['*catering-items*'],
                    'classes' => 'admin-menu-items-menu',
                ],
            ],
        ],
        [
            'text'    => 'Food Orders',
            'route'   => 'orders.index',
            'icon'    => 'nav-icon fa fa-list-ol',
            'can'     => ['menu-Order'],
            'active'  => ['*admin/orders*'],
            'classes' => 'admin-orders-menu',
        ],
        [
            'text'    => 'Voucher Limits',
            'route'   => 'voucher-limits.index',
            'icon'    => 'nav-icon fas fa-calendar-week',
            'can'     => ['menu-VoucherLimit'],
            'active'  => ['*admin/voucher-limits*'],
            'classes' => 'admin-voucher-limits-menu',
        ],
        [
            'text'    => 'Delivery Planning',
            'route'   => 'delivery-planning.index',
            'icon'    => 'nav-icon fa fa-calendar-alt',
            'can'     => ['menu-Order'],
            'active'  => ['*admin/delivery-planning*'],
            'classes' => 'admin-delivery-planning-menu',
        ],
        [
            'text'    => 'Vacations',
            'route'   => 'vacations.index',
            'icon'    => 'nav-icon fa fa-calendar',
            'can'     => ['menu-Vacation'],
            'active'  => ['*vacations*'],
            'classes' => 'admin-vacations-menu',
        ],
        [
            'text'    => 'Settings',
            'route'   => 'settings.combined_index',
            'icon'    => 'nav-icon fa fa-cogs',
            'can'     => ['menu-Setting'],
            'active'  => ['*admin/settings*'],
            'classes' => 'admin-settings-menu',
        ],
        [
            'text'    => 'Financial Exports',
            'route'   => 'financial-report.index',
            'icon'    => 'nav-icon fa fa-file',
            'can'     => ['menu-Payment'],
            'active'  => ['*admin/financial-report*'],
            'classes' => 'admin-financial-report-menu',
        ],
        //user side menus
        //@todo - create middleware for checking user role
        [
            'text'  => 'Order Now',
            'route' => 'user.food-order.index',
            'icon'  => 'nav-icon fa fa-calendar-check',
            'can'   => ['menu-User-Order']
        ],
        [
            'text'  => 'Orders',
            'route' => 'user.food-order.food-orders',
            'icon'  => 'nav-icon fa fa-list-ol',
            'can'   => ['menu-User-Order']
        ],
        [
            'text'    => 'QR Code',
            'route'   => 'user.consumers.qr-code.index',
            'icon'    => 'nav-icon fa fa-qrcode',
            'can'     => ['menu-User-ConsumerQrCode'],
            'classes' => 'user-qr-code-menu',
        ],
        [
            'text'    => 'Payments',
            'icon'    => 'fas fa-fw fa-euro-sign',
            'can'     => ['menu-User-Payment'],
            'classes' => 'admin-payments-menu',
            'submenu' => [
                [
                    'text'    => 'Bank Transactions',
                    'route'   => 'user.payments.bank-transactions',
                    'icon'    => 'fa fa-exchange-alt',
                    'active'  => ['*payments/bank-transactions'],
                    'classes' => 'admin-bank-transactions-menu',
                ],
                [
                    'text'    => 'Meal Orders',
                    'route'   => 'user.payments.meal-orders',
                    'icon'    => 'fa fa-hamburger',
                    'active'  => ['*payments/meal-orders'],
                    'classes' => 'admin-meal-orders-menu',
                ],
            ],
        ],
        [
            'header' => '',
            'line'   => true
        ],
        [
            'text'    => 'Profile',
            'route'   => 'profile.index',
            'icon'    => 'nav-icon fa fa-user',
            'can'     => ['menu-User-Profile'],
            'classes' => 'user-profile-menu',
        ],
        [
            'text'    => 'Children',
            'route'   => 'user.consumers.index',
            'icon'    => 'nav-icon fa fa-users',
            'can'     => ['menu-User-Consumer'],
            'classes' => 'user-consumers-menu'
        ],

        //        [
        //            'text' => 'Vacation Location Group',
        //            'url'  => 'admin/vacation-location-group',
        //            'icon' => 'far fa-fw fa-file',
        //        ],
        //        [
        //            'text' => 'Subsidized Menu Categories',
        //            'url'  => 'admin/subsidized-menu-categories',
        //            'icon' => 'far fa-fw fa-file',
        //        ],
        //
        //        [
        //            'text' => 'Consumer Subsidizations',
        //            'url'  => 'admin/consumer-subsidizations',
        //            'icon' => 'far fa-fw fa-file',
        //        ],

        //        [
        //            'text'  => 'Auto Orders',
        //            'route' => 'consumer-auto-orders.index',
        //            'icon'  => 'far fa-fw fa-file',
        //        ],
        //        [
        //            'text'  => 'Consumer QR Codes',
        //            'route' => 'consumer-qr-codes.index',
        //            'icon'  => 'far fa-fw fa-file',
        //            'can'   => 'menu-ConsumerQrCode',
        //        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#83-custom-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#91-plugins
    |
    */

    'plugins' => [
        'Datatables'  => [
            'active' => false,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2'     => [
            'active' => false,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs'     => [
            'active' => false,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files'  => [
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace'        => [
            'active' => false,
            'files'  => [
                [
                    'type'     => 'css',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type'     => 'js',
                    'asset'    => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#93-livewire
    */

    'livewire' => false,
];

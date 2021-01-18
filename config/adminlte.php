<?php

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
    'logo_img'          => '/image/Coolinary_Logo_rgb.png',
    'logo_img_class'    => 'brand-image img-circle elevation-3',
    'logo_img_xl'       => '/image/Coolinary_Logo_rgb.png',
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
            'text'  => 'Locations',
            'route' => 'locations.index',
            'icon'  => 'nav-icon fa fa-map-marked',
        ],
        [
            'text'  => 'Groups',
            'route' => 'location-groups.index',
            'icon'  => 'nav-icon fa fa-object-ungroup',
        ],
        [
            'text'  => 'Administrators',
            'route' => 'users.index',
            'icon'  => 'nav-icon fa fa-user-friends',
        ],
        [
            'text'  => 'Consumers',
            'route' => 'consumers.index',
            'icon'  => 'nav-icon fa fa-users',
        ],
        [
            'text'    => 'Payments',
            'icon'    => 'fas fa-fw fa-euro-sign',
            'submenu' => [
                [
                    'text'   => 'Bank Transactions',
                    'route'  => 'payments.index',
                    'icon'   => 'fa fa-exchange-alt',
                    'can'    => 'menu-Payment',
                    'active' => ['*payments']
                ],
                [
                    'text'   => 'Meal Orders',
                    'route'  => 'payments.meal-orders',
                    'icon'   => 'fa fa-hamburger',
                    'can'    => 'menu-Payment',
                    'active' => ['*payments/meal-orders']
                ],
                [
                    'text'   => 'Add Payment',
                    'route'  => 'payments.create',
                    'icon'   => 'fa fa-handshake',
                    'can'    => 'menu-Payment',
                    'active' => ['*payments/create']
                ],
                [
                    'text'   => 'Payment Dumps',
                    'route'  => 'payment-dumps.index',
                    'icon'   => 'fa fa-piggy-bank',
                    'can'    => 'menu-Payment',
                    'active' => ['*payment-dumps']
                ],
            ],
        ],
        [
            'text'    => 'Subsidization',
            'icon'    => 'nav-icon fa fa-hand-holding-heart',
            'submenu' => [
                [
                    'text'   => 'Organizations',
                    'route'  => 'subsidization-organizations.index',
                    'icon'   => 'nav-icon fa fa-landmark',
                    'active' => ['*subsidization-organizations*']
                ],
                [
                    'text'   => 'Rules',
                    'route'  => 'subsidization-rules.index',
                    'icon'   => 'nav-icon fa fa-percent',
                    'active' => ['*subsidization-rules*']
                ],
            ],
        ],
        [
            'text'  => 'Menu Categories',
            'route' => 'menu-categories.index',
            'icon'  => 'nav-icon fas fa-book-open',
        ],
        [
            'text'  => 'Menu Items',
            'route' => 'menu-items.index',
            'icon'  => 'nav-icon fa fa-utensils',
        ],
        [
            'text'  => 'Food Orders',
            'route' => 'orders.index',
            'icon'  => 'nav-icon fa fa-list-ol',
        ],
        [
            'text'  => 'Voucher Limits',
            'route' => 'voucher-limits.index',
            'icon'  => 'nav-icon fas fa-calendar-week',
        ],
        [
            'text'  => 'Delivery Planning',
            'route' => 'delivery-planning.index',
            'icon'  => 'nav-icon fa fa-calendar-alt',
        ],
        [
            'text'  => 'Vacations',
            'route' => 'vacations.index',
            'icon'  => 'nav-icon fa fa-calendar',
        ],
        [
            'text'  => 'Settings',
            'route' => 'settings.combined_index',
            'icon'  => 'nav-icon fa fa-cogs',
        ],
        [
            'text'  => 'Financial Exports',
            'route' => 'financial-report.index',
            'icon'  => 'nav-icon fa fa-file',
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

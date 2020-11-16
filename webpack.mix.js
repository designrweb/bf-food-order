const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/crud/users.js', 'public/js/crud')
    .js('resources/js/crud/vacation.js', 'public/js/crud')
    .js('resources/js/crud/locations.js', 'public/js/crud')
    .js('resources/js/crud/menu_categories.js', 'public/js/crud')
    .js('resources/js/crud/location_group.js', 'public/js/crud')
    .js('resources/js/crud/menu_items.js', 'public/js/crud')
    .js('resources/js/crud/voucher_limits.js', 'public/js/crud')
    .js('resources/js/crud/subsidization_organizations.js', 'public/js/crud')
    .js('resources/js/crud/consumers.js', 'public/js/crud')
    .js('resources/js/crud/subsidized_menu_categories.js', 'public/js/crud')
    .js('resources/js/crud/vacation_location_group.js', 'public/js/crud')
    .js('resources/js/crud/consumer_qr_codes.js', 'public/js/crud')
    .js('resources/js/crud/payments.js', 'public/js/crud')
    .js('resources/js/crud/settings.js', 'public/js/crud')
    .js('resources/js/crud/orders.js', 'public/js/crud')
    .js('resources/js/crud/consumer_auto_orders.js', 'public/js/crud')
    .js('resources/js/crud/consumer_subsidizations.js', 'public/js/crud')
    .sass('resources/sass/app.scss', 'public/css');

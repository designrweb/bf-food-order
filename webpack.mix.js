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
//admin part
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
    .js('resources/js/crud/payment-dumps.js', 'public/js/crud')
    .js('resources/js/crud/settings.js', 'public/js/crud')
    .js('resources/js/crud/orders.js', 'public/js/crud')
    .js('resources/js/crud/consumer_auto_orders.js', 'public/js/crud')
    .js('resources/js/crud/consumer_subsidizations.js', 'public/js/crud')
    .js('resources/js/crud/subsidization_rules.js', 'public/js/crud')
    .js('resources/js/crud/companies.js', 'public/js/crud')
    .js('resources/js/crud/companies_switcher.js', 'public/js/crud')
    .js('resources/js/crud/delivery_planning.js', 'public/js/crud')
    .js('resources/js/crud/reports.js', 'public/js/crud')
    .js('resources/js/crud/profile.js', 'public/js/crud')
    .js('resources/js/crud/user_consumers.js', 'public/js/crud')
    .js('resources/js/crud/consumer_switcher.js', 'public/js/crud')
    .js('resources/js/crud/user_food_order.js', 'public/js/crud')
    .js('resources/js/crud/user_food_order_overview.js', 'public/js/crud')
    .js('resources/js/crud/user_payments.js', 'public/js/crud')
    .js('resources/js/crud/catering_categories.js', 'public/js/crud')
    .js('resources/js/crud/catering_items.js', 'public/js/crud')
    .js('resources/js/crud/administrators.js', 'public/js/crud')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/sass/kv-mpdf-bootstrap.min.css', 'public/css');

//user part
mix.js('resources/js/app.js', 'public/js_frontend')
    .sass('resources/sass/app_frontend.scss', 'public/css_frontend');

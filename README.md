# Food Order Tool (Laravel)
The main purpose of the application is to organize food ordering and it consuming. 

## Set up
1) Clone the repo
2) Checki if you have access to the repo and then run:    
 `git clone https://github.com/andriyburda/crud-generator packages/bigfood/grid`   
3) Run `composer install`
4) Run `php artisan key:generate`
5) Run `php artisan storage:link`
6) Run `php artisan jwt:secret` - to generate jwt token
7) Run `npm install`
8) Then build assets `npm run dev`

### Environment variables
`KEY_FILE_ENCRYPT` (long key for encrypt and decrypt images)

### Seed the user
`php artisan db:seed` (default password is admin)

## CRUD generator 
Check [docs](https://github.com/andriyburda/crud-generator/blob/master/readme.md#usage) for more details

## AdminLTE
Check [docs](https://github.com/jeroennoten/Laravel-AdminLTE/blob/master/README.md) for more details

## JWT-Auth
Check [docs](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/) for more details

## Testing
1) Create new test DB for testing purposes.
2) Write the credentials for connecting to the test database in the `.env` file. Example is in `.env.example` file.
3) To run tests write in console: `php artisan test`

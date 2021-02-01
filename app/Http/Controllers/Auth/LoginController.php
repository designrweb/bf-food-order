<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\CompanyService;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * @var CompanyService
     */
    protected $companyService;

    /**
     * Create a new controller instance.
     *
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService)
    {
        $this->middleware('guest')->except('logout');
        $this->companyService = $companyService;
    }

    /**
     * @return mixed|string
     */
    public function redirectPath()
    {
        if (in_array(auth()->user()->role, [User::ROLE_SUPER_ADMIN])) {
            $this->companyService->switchCompany();
        }

        return $this->redirectTo();
    }

    /**
     * @return mixed|string
     */
    public function redirectTo()
    {
        $routes = [
            User::ROLE_ADMIN       => route('locations.index'),
            User::ROLE_SUPER_ADMIN => route('companies.index'),
            User::ROLE_USER        => route('profile.index'),
            User::ROLE_POS_MANAGER => route('profile.index'),
        ];

        return $routes[auth()->user()->role] ? $routes[auth()->user()->role] : $this->redirectTo;
    }
}

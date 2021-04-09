<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\CompanyService;
use App\Services\UserService;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param UserService              $userService
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response|void
     *
     * @throws ValidationException
     */
    public function login(Request $request, UserService $userService)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $user = $userService->getByEmail($request->get('email'));

            if ($user->hasVerifiedEmail()) return $this->sendLoginResponse($request);

            //logout user to not display user name in header
            auth()->logout();

            return $this->sendEmailNotConfirmedResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendEmailNotConfirmedResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.not_verified')],
        ]);
    }
}

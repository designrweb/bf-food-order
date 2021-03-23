<?php

namespace App\Http\Controllers\api\mobile\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\mobile\AuthChangeEmailFormRequest;
use App\Http\Requests\api\mobile\AuthChangePasswordFormRequest;
use App\Http\Requests\api\mobile\AuthRegisterFormRequest;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(
                [
                    'errors' =>
                        [
                            'user' =>
                                [
                                    'UNAUTHORIZED'
                                ]
                        ]
                ], 401);
        }

        //if you reached here then user has been authenticated
        if (empty(auth('api')->user()->hasVerifiedEmail())) {
            return response()->json(
                [
                    'errors' =>
                        [
                            'email' =>
                                [
                                    'ERROR_EMAIL_NOT_VERIFIED'
                                ]
                        ]
                ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * @param AuthChangeEmailFormRequest $request
     * @return JsonResponse
     */
    public function changeEmail(AuthChangeEmailFormRequest $request)
    {
        try {
            auth('api')->user()->update($request->validated());
        } catch (\Throwable $t) {
            return response()->json([
                'message' => $t->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->refresh();
    }

    /**
     * @param AuthChangePasswordFormRequest $request
     * @return JsonResponse
     */
    public function changePassword(AuthChangePasswordFormRequest $request)
    {
        try {
            $validated = $request->validated();

            auth('api')->user()->update([
                'password' => bcrypt($validated['password']),
            ]);
        } catch (\Throwable $t) {
            return response()->json([
                'message' => $t->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->refresh();
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'user'         => auth('api')->user()->load('userInfo')->toArray(),
            'expires_in'   => auth('api')->factory()->getTTL() * 60 * 24
        ]);
    }

    /**
     * Register a User.
     *
     * @param AuthRegisterFormRequest $request
     * @return JsonResponse
     */
    public function register(AuthRegisterFormRequest $request)
    {
        try {
            $user = User::create(array_merge(
                $request->validated(),
                [
                    'password' => bcrypt($request->password),
                    'role'     => User::ROLE_USER
                ]
            ));

            $user->userInfo()->create([
                'first_name' => $request->get('first_name'),
                'last_name'  => $request->get('last_name'),
            ]);

            $user->sendEmailVerificationNotification();;
        } catch (\Throwable $t) {
            return response()->json([
                'message' => $t->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'User successfully registered',
            'user'    => $user
        ], 201);
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return JsonResponse|RedirectResponse
     * @throws AuthorizationException
     */
    public function resend(Request $request)
    {
        if (!$request->route('id')) {
            throw new AuthorizationException;
        }

        $user = User::findOrFail($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return new JsonResponse([], 204);
        }

        $user->sendEmailVerificationNotification();

        return new JsonResponse([], 202);
    }
}

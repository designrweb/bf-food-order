<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Http\Controllers\Controller;
use App\Http\Resources\PosTerminal\ManagerPosTerminalResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @return ManagerPosTerminalResource|\Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials['email']    = request()->get('login');
        $credentials['password'] = request()->get('password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(["errors" => ["password" => "Invalid login or password"]], 422);
        }

        return new ManagerPosTerminalResource(auth('api')->user(), $token);
    }

    /**
     * @return ManagerPosTerminalResource
     */
    public function me()
    {
        $token = JWTAuth::fromUser(auth('api')->user());

        return new ManagerPosTerminalResource(auth('api')->user(), $token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}

<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Http\Controllers\api\v1\AuthController as BaseAuth;
use App\Http\Resources\PosTerminal\ManagerPosTerminalResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseAuth
{
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
}

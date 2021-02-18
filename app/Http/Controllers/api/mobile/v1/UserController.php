<?php


namespace App\Http\Controllers\api\mobile\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\mobile\UserFormRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\User;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\api\mobile\v1
 */
class UserController extends Controller
{

    /** @var UserService $service */
    protected $service;

    /**
     * UserController constructor.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param UserFormRequest $request
     * @return array
     */
    public function update(UserFormRequest $request)
    {
        /** @var User $user */
        $user = auth('api')->user();

        return (new UserResource($this->service->update($request->all(), $user->id)))->toArray($request);
    }
}

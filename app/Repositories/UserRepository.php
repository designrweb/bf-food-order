<?php

namespace App\Repositories;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;
use App\QueryBuilders\UserSearch;
use App\UserInfo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserRepository implements RepositoryInterface
{
    use AuthorizesRequests;

    /** @var User */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @return UserCollection
     */
    public function all()
    {
        return new UserCollection(app(Pipeline::class)
            ->send(
                $this->model->newQuery()
                    ->select('users.*')
                    ->leftJoin('user_info', 'users.id', '=', 'user_info.user_id')
            )
            ->through([
                UserSearch::class,
            ])
            ->thenReturn()
            ->with('userInfo')
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return UserResource
     */
    public function add(array $data)
    {
        return new UserResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return UserResource
     */
    public function update(array $data, $id)
    {
        /** @var User $model */
        $model = $this->model->findOrFail($id);

        $model->update($data);

        if (empty($model->userInfo)) {
            $model->userInfo()->create($data['user_info']);
        } else {
            $model->userInfo->update($data['user_info']);
        }


        return new UserResource($model);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @return UserResource
     */
    public function get($id)
    {
        $model = $this->model->with('userInfo')->findOrFail($id);

        return new UserResource($model);
    }
}

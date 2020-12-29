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
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                UserSearch::class,
            ])
            ->thenReturn()
            ->with('userInfo')
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param       $id
     * @return User
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

        return $model;
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
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get($id)
    {
        return $this->model->with('userInfo')->findOrFail($id);
    }
}

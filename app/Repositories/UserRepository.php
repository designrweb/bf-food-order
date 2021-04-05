<?php

namespace App\Repositories;

use App\QueryBuilders\AdministratorSearch;
use App\User;
use App\QueryBuilders\UserSearch;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;
use Illuminate\Support\Facades\Hash;

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
            ->with(['userInfo', 'location', 'company'])
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @return mixed
     */
    public function allAdministrators()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                AdministratorSearch::class,
            ])
            ->thenReturn()
            ->with(['userInfo', 'location', 'company'])
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $model = $this->model->create($data);

        if (empty($model->userInfo)) {
            $model->userInfo()->create($data['user_info']);
        } else {
            $model->userInfo->update($data['user_info']);
        }

        return $model->load('userInfo');
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

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

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
        return $this->model->with(['userInfo', 'location', 'company'])->findOrFail($id);
    }

    /**
     * @return array
     */
    public function getSalutationsList(): array
    {
        $salutationsArray = [];
        $salutations      = $this->model::SALUTATIONS;

        foreach ($salutations as $key => $value) {
            $salutationsArray[] = [
                'id'   => $key,
                'name' => $value,
            ];
        }

        return $salutationsArray;
    }

    /**
     * @return array
     */
    public function getRolesList(): array
    {
        $rolesArray = [];
        $roles      = $this->model::ROLES;

        foreach ($roles as $key => $value) {
            if ($key === User::ROLE_USER)
                continue;

            $rolesArray[] = [
                'id'   => $key,
                'name' => $value,
            ];
        }

        return $rolesArray;
    }

    /**
     * @param null $id
     * @return bool
     */
    public function switchCompany($id): bool
    {
        $user = auth()->user();
        $user->company_id = $id;
        $user->save();

        return true;
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
}

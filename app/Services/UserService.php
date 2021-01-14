<?php

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;


class UserService extends BaseModelService
{

    public $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * @param $data
     * @param $id
     * @return User
     */
    public function update($data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @return array
     */
    public function getSalutationsList(): array
    {
        return $this->repository->getSalutationsList();
    }

    /**
     * @return array
     */
    public function getRolesList(): array
    {
        return $this->repository->getRolesList();
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new User()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new User()));
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'email',
                'label' => 'Email'
            ],
            [
                'key'   => 'user_info.first_name',
                'label' => 'First Name'
            ],
            [
                'key'   => 'user_info.last_name',
                'label' => 'Last Name'
            ],
            [
                'key'   => 'salutation_name',
                'label' => 'Salutation'
            ],
            [
                'key'   => 'role_name',
                'label' => 'Access level'
            ],
            [
                'key'   => 'user_info.zip',
                'label' => 'Zip'
            ],
            [
                'key'   => 'user_info.city',
                'label' => 'City'
            ],
            [
                'key'   => 'user_info.street',
                'label' => 'Street'
            ]
        ];
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    public function getIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'id',
                'label' => '#'
            ],
            [
                'key'   => 'accounts',
                'label' => 'Accounts'
            ],
            [
                'key'   => 'email',
                'label' => 'Email'
            ],
            [
                'key'   => 'location',
                'label' => 'Location'
            ],
            [
                'key'   => 'role',
                'label' => 'Access level'
            ]
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'accounts' => '',
            'email'    => '',
            'location' => '',
            'role'     => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'accounts' => '',
            'email'    => '',
            'location' => '',
            'role'     => '',
        ];
    }
}

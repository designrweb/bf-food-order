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

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all users transformed to resource
     *
     * @return UserCollection
     */
    public function all(): UserCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return UserResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): UserResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the users model
     *
     * @param $data
     * @return UserResource
     */
    public function create($data): UserResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the users model
     *
     * @param $data
     * @param $id
     * @return UserResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): UserResource
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

    protected function getViewFieldsLabels(Model $model): array
    {
        $fields = [
            [
                'key'   => 'id',
                'label' => 'Id'
            ],
            [
                'key'   => 'name',
                'label' => 'Name'
            ],
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
            ], [
                'key'   => 'user_info.salutation',
                'label' => 'Salutation'
            ], [
                'key'   => 'user_info.zip',
                'label' => 'Zip'
            ], [
                'key'   => 'user_info.city',
                'label' => 'City'
            ], [
                'key'   => 'user_info.street',
                'label' => 'Street'
            ],
            [
                'key'   => 'created_at',
                'label' => 'Created At'
            ],
            [
                'key'   => 'updated_at',
                'label' => 'Updated At'
            ],
        ];

        return $fields;
    }

    public function getIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'id',
                'label' => 'Id'
            ],
            [
                'key'   => 'name',
                'label' => 'Name'
            ],
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
                'key'   => 'created_at',
                'label' => 'Created At'
            ],
            [
                'key'   => 'updated_at',
                'label' => 'Updated At'
            ],
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        $filters = [
            'id'                   => '',
            'name'                 => '',
            'email'                => '',
            'created_at'           => '',
            'updated_at'           => '',
            'user_info.first_name' => '',
            'user_info.last_name'  => '',
        ];

        return $filters;
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        $sortFields = [
            'id'                   => '',
            'name'                 => '',
            'email'                => '',
            'created_at'           => '',
            'updated_at'           => '',
            'user_info.first_name' => '',
            'user_info.last_name'  => '',
        ];

        return $sortFields;
    }
}

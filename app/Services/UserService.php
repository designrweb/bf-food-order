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
     * @return mixed
     */
    public function allAdministrators()
    {
        return $this->repository->allAdministrators();
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
     * @return bool
     */
    public function isCompletedProfile(): bool
    {
        return $this->repository->isCompletedProfile();
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
     * @return array
     */
    public function getAdministratorIndexStructure(): array
    {
        return $this->getAdministratorFullStructure((new User()));
    }

    /**
     * @return array
     */
    public function getAdministratorViewStructure(): array
    {
        return $this->getAdministratorSimpleStructure((new User()));
    }

    /**
     * Returns main model full structure
     *
     * @param Model $model
     * @return array
     */
    public function getAdministratorFullStructure(Model $model): array
    {
        return [
            'filters'      => $this->getAdministratorFilters($model),
            'sort'         => $this->getAdministratorSortFields($model),
            'fields'       => $this->getAdministratorIndexFieldsLabels($model),
            'allowActions' => $this->getAdministratorAllowActions(),
        ];
    }

    /**
     * Returns main model partly structure (main target is view page)
     *
     * @param Model $model
     * @return array
     */
    public function getAdministratorSimpleStructure(Model $model): array
    {
        return [
            'fields'       => $this->getViewFieldsLabels($model),
            'allowActions' => $this->getAdministratorAllowActions(),
        ];
    }

    /**
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAdministratorAllowActions()
    {
        return [
            'all'    => true,
            'create' => true,
            'view'   => true,
            'edit'   => true,
            'delete' => false,
        ];
    }

    /**
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAllowActions()
    {
        return [
            'all'    => true,
            'create' => false,
            'view'   => true,
            'edit'   => true,
            'delete' => false,
        ];
    }

    /**
     * Switch current consumer
     *
     * @param $id
     * @return bool
     */
    public function switchCompany($id): bool
    {
        return $this->repository->switchCompany($id);
    }

    /**
     * @return bool
     */
    public function isAdminOrSuperAdmin(): bool
    {
        return in_array(auth()->user()->role, [User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN]);
    }

    /**
     * Get if user has consumers
     *
     * @param User $user
     * @return bool
     */
    public function isConsumersExists(User $user): bool
    {
        return $user->consumers()->exists();
    }

    /**
     * Get if user has consumers
     *
     * @param string $email
     *
     * @return mixed
     */
    public function getByEmail(string $email)
    {
        return $this->repository->getByEmail($email);
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
                'label' => __('app.Email')
            ],
            [
                'key'   => 'user_info.first_name',
                'label' => __('user.First Name')
            ],
            [
                'key'   => 'user_info.last_name',
                'label' => __('user.Last Name')
            ],
            [
                'key'   => 'salutation_name',
                'label' => __('user.Parent Salutation')
            ],
            [
                'key'   => 'role_name',
                'label' => __('user.Access level')
            ],
            [
                'key'   => 'user_info.zip',
                'label' => __('app.Zip')
            ],
            [
                'key'   => 'user_info.city',
                'label' => __('app.City')
            ],
            [
                'key'   => 'user_info.street',
                'label' => __('app.Street')
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
                'key'   => 'user_info.full_name',
                'label' => __('app.Name')
            ],
            [
                'key'   => 'email',
                'label' => __('app.Email')
            ],
            [
                'key'   => 'role',
                'label' => __('user.Access level')
            ]
        ];
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    public function getAdministratorIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'user_info.full_name',
                'label' => __('app.Name')
            ],
            [
                'key'   => 'email',
                'label' => __('app.Email')
            ],
            [
                'key'   => 'location.name',
                'label' => __('location.Location')
            ],
            [
                'key'   => 'role',
                'label' => __('user.Access level')
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
            'user_info.full_name' => '',
            'email'               => '',
            'role'                => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'user_info.full_name' => '',
            'email'               => '',
            'role'                => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getAdministratorFilters(Model $model): array
    {
        return [
            'user_info.full_name' => '',
            'email'               => '',
            'location.name'       => '',
            'role'                => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getAdministratorSortFields(Model $model): array
    {
        return [
            'user_info.full_name' => '',
            'email'               => '',
            'location.name'       => '',
            'role'                => '',
        ];
    }
}

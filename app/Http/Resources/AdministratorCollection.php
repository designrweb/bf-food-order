<?php

namespace App\Http\Resources;

use App\User;
use bigfood\grid\PaginatableCollection;

/**
 * Class AdministratorCollection
 *
 * @package App\Http\Resources
 */
class AdministratorCollection extends PaginatableCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'       => $this->collection->transform(function (User $item) {
                $data = $item->toArray();

                $data['role']     = User::ROLES[$item->role];

                return $data;
            }),
            'pagination' => $this->pagination
        ];
    }
}

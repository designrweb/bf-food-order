<?php

namespace App\Http\Resources;

use App\User;
use bigfood\grid\PaginatableCollection;

/**
 * Class UserCollection
 *
 * @package App\Http\Resources
 */
class UserCollection extends PaginatableCollection
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
                return [
                    'id'           => $item->id,
                    'email'        => $item->email,
                    'accounts'     => $item->consumers->implode('account_id', ', '),
                    'location'     => !empty($item->location->name) ? $item->location->name : null,
                    'access_level' => User::ROLES[$item->role],
                ];
            }),
            'pagination' => $this->pagination
        ];
    }
}

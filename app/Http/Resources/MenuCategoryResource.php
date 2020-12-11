<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'category_order' => $this->category_order,
            'price'          => $this->price,
            'presaleprice'   => $this->presaleprice,
            'created_at'     => date('M d, Y, H:i:s A', strtotime($this->created_at)),
            'updated_at'     => date('M d, Y, H:i:s A', strtotime($this->updated_at)),
        ];
    }
}

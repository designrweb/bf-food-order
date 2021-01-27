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
        $data = parent::toArray($request);

        $data['price_locale']        = $this->price_locale;
        $data['presaleprice_locale'] = $this->presaleprice_locale;
        $data['created_at']          = date('M d, Y, H:i:s A', strtotime($this->created_at));
        $data['updated_at']          = date('M d, Y, H:i:s A', strtotime($this->updated_at));

        return $data;
    }
}

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

        return $data;
    }
}

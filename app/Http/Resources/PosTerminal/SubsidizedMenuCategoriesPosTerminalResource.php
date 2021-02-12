<?php

namespace App\Http\Resources\PosTerminal;

use Illuminate\Http\Resources\Json\JsonResource;

class SubsidizedMenuCategoriesPosTerminalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'menu_category_id'      => $this->menu_category_id,
            'subsidization_rule_id' => $this->subsidization_rule_id,
            'percent'               => $this->percent
        ];
    }
}

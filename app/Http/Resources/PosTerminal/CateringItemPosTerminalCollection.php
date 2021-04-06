<?php

namespace App\Http\Resources\PosTerminal;

use Illuminate\Http\Resources\Json\JsonResource;

class CateringItemPosTerminalCollection extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $data = parent::toArray($request);

        $data['quantity'] = 0;

        return $data;
    }
}
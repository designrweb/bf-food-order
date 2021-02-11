<?php

namespace App\Http\Resources\PosTerminal;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagerPosTerminalResource extends JsonResource
{
    private $token;

    /**
     * ManagerPosTerminalResource constructor.
     *
     * @param $resource
     * @param $token
     */
    public function __construct($resource, $token)
    {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            "username" => $this->email,
            "auth_key" => $this->token
        ];
    }
}

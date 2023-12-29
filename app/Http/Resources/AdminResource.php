<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->adm_name,
            'email' => $this->adm_email,
            'phone' => $this->adm_phone,
            'role' => $this->adm_role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}

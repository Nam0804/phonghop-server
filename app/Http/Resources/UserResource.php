<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'title' => $this->title,
            'phone' => $this->phone,
            'is_first_login' => $this->is_first_login,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'company' => [
                'data' => [
                    'company_id' => $this->company->id,
                    'company_name' => $this->company->company_name,
                ],
            ],

        ];
    }
}

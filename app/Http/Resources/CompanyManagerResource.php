<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyManagerResource extends JsonResource
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
            'name' => $this->company_name,
            'address' => $this->company_address,
            'domain' => $this->company_domain,
            'tax_code' => $this->company_tax_code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'manager' => [
                'id' => $this->manager->id,
                'manager_name' => $this->manager->name,
                'manager_email' => $this->manager->email,
                'manager_phone' => $this->manager->phone,
                'manager_title' => $this->manager->title,
            ],

        ];
    }
}

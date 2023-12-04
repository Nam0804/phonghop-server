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
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'attributes' => [
                'name' => $this->company_name,
                'address' => $this->company_address,
                'domain' => $this->company_domain,
                'tax_code' => $this->company_tax_code,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
             'relationships' => [
                 'manager' => [
                     'data' => [
                         'id' => $this->manager->id,
                         'manager_name' => $this->manager->name,
                     ],
                 ],
             ],
        ];
    }
}

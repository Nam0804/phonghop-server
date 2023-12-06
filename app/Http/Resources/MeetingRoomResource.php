<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingRoomResource extends JsonResource
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
            'attributes' => [
                'name' => $this->name,
                'location' => $this->location,
                'floor' => $this->floor,
                'capacity' => $this->capacity,
                'equipment' => $this->equipment,
                'image' => $this->image,
                'availability' => $this->availability,
                'company_id' => $this->company_id,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],

        ];
    }
}

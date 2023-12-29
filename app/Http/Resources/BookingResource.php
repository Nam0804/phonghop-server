<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
                'meeting_room_id' => $this->meeting_room_id,
                'from_time' => $this->from_time,
                'to_time' => $this->to_time,
                'repeat_type'=> $this->repeat_type,
                'topic' => $this->topic,
                'type_of_booking' => $this->type_of_booking,
                'agenda' => $this->agenda,
                'guests' => $this->guests,
                'objective' > $this->objective,
                'material' => $this->materials,
                'sharing_confirmation' => $this->sharing_confirmation,
                'booking_name' => $this->booking_name,
                'booking_email' => $this->booking_email,
                'booking_title' => $this->booking_title,
                'booking_company' => $this->booking_company,
            ],
            'relationships' => [
                'meeting_room' => [
                    'data' => [
                        'name' => $this->meeting_room->name,
                        'location' => $this->meeting_room->location,
                        'floor' => $this->meeting_room->floor,
                        'capacity' => $this->meeting_room->capacity,
                        'equipment' => $this->meeting_room->equipment,
                        'image' => $this->meeting_room->image,
                        'availability' => $this->meeting_room->availability,
                        'company_id' => $this->meeting_room->company_id,
                    ],
                ],
            ],
        ];
    }
}

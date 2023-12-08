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
                'meeting_room_id'=> $this->meeting_room_id,
                'from_time'=> $this->from_time,
                'to_time'=> $this->to_time,
                'topic'=> $this->topic,
                'type_of_booking'=> $this->type_of_booking,
                'guests'=> $this->guests,
                'agenda'=> $this->agenda,
                'objective'> $this->objective,
                'material'=> $this->material,
                'sharing_confirmation'=> $this->sharing_confirmation,
                'booking_name'=> $this->booking_name,
                'booking_email'=> $this->booking_email,
                'booking_title'=> $this->booking_title,
                'booking_company'=> $this->booking_company,
            ],

        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // rule for all fillable fields in Booking model
            'meeting_room_id' => ['required', 'integer'],
            'from_time' => ['required', 'date'],
            'to_time' => ['required', 'date'],
            'topic' => ['required', 'string'],
            'type_of_booking' => ['required', 'string'],
            'guests' => ['array'],
            'agenda' => ['string'],
            'objective' => ['string'],
            'material' => ['string'],
            'sharing_confirmation' => ['integer'],
            'booking_name' => ['required', 'string'],
            'booking_email' => ['required', 'string', 'email'],
            'booking_title' => ['required', 'string'],
        ];
    }
}

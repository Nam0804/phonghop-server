<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;

class BookingLoggedRequest extends FormRequest
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
            'from_time' => ['required', 'date', 'before:to_time'],
            'to_time' => ['required', 'date', 'after:from_time'],
            'topic' => ['required', 'string'],
            'type_of_booking' => ['required', 'string'],
            'agenda' => ['string'],
            'objective' => ['string'],
        ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRoomRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'floor' => ['string', 'max:100'],
            'capacity' => ['required', 'numeric', 'max:100'],
            'equipment' => ['string', 'max:255'],
            'image' => ['image', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'availability' => ['required'],
            'company_id' => ['required', 'integer'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class StoreAdminRequest extends FormRequest
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
            'adm_name'=>['required', 'string', 'max:255'],
            'adm_email'=>['required', 'string', 'email', 'max:255', 'unique:admins'],
            'adm_password'=>['required', 'string', 'min:8', 'confirmed',Rules\Password::defaults()],
            'adm_role'=>['required','integer'],
        ];
    }
}

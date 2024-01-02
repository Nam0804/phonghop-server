<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;


class CreateCompanyManager extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:255',
            'company_domain' => 'required|string|max:255',
            'company_tax_code' => 'string|max:255',
            'name'=>['required', 'string', 'max:255'],
            'email'=>['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'=>['required', 'string', 'min:8', 'confirmed',Rules\Password::defaults()],
            'title'=>['required', 'string', 'max:255'],
            'phone'=>['required', 'numeric'],
        ];
    }
}

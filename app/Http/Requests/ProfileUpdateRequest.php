<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone'             => ['nullable', 'string', 'max:30'],
            'bio'               => ['nullable', 'string', 'max:1000'],
            'experience_years'  => ['nullable', 'integer', 'min:0', 'max:60'],
            'salon_name'        => ['nullable', 'string', 'max:255'],
            'salon_address'     => ['nullable', 'string', 'max:255'],
            'salon_city'        => ['nullable', 'string', 'max:100'],
            'salon_phone'       => ['nullable', 'string', 'max:30'],
            'salon_description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

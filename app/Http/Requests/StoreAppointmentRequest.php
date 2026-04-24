<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   public function authorize(): bool {
    return true; // Разрешаем всем авторизованным
}

public function rules(): array {
    return [
        'service_id' => 'required|exists:services,id',
        'specialist_id' => 'required|exists:specialists,id',
        'appointment_time' => 'required|date|after:now',
        'notes' => 'nullable|string|max:500',
    ];
}

}

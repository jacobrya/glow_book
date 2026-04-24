<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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

<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 10;

    public function __construct(public readonly Appointment $appointment) {}

    public function handle(WhatsAppService $whatsApp): void
    {
        $appointment = $this->appointment->load(['client', 'specialist.user', 'service', 'salon']);

        $phone = $appointment->client->phone;

        if (!$phone) {
            Log::info('WhatsApp skipped — client has no phone', ['appointment_id' => $appointment->id]);
            return;
        }

        $date      = $appointment->appointment_date->format('d M Y');
        $time      = \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i');
        $service   = $appointment->service->name;
        $specialist = $appointment->specialist->user->name;
        $salon     = $appointment->salon->name;
        $city      = $appointment->salon->city ? ", {$appointment->salon->city}" : '';
        $address   = $appointment->salon->address . $city;

        $message = "✅ *Booking Confirmed — GlowBook*\n\n"
            . "Hello, {$appointment->client->name}!\n\n"
            . "Your appointment has been confirmed:\n\n"
            . "💅 *Service:* {$service}\n"
            . "👤 *Specialist:* {$specialist}\n"
            . "🏠 *Salon:* {$salon}\n"
            . "📍 *Address:* {$address}\n"
            . "📅 *Date:* {$date}\n"
            . "🕐 *Time:* {$time}\n\n"
            . "We look forward to seeing you!\n"
            . "_GlowBook — glowbook.kz_";

        $whatsApp->send($phone, $message);
    }

    public function failed(\Throwable $e): void
    {
        Log::error('SendWhatsAppNotification job failed', [
            'appointment_id' => $this->appointment->id,
            'error'          => $e->getMessage(),
        ]);
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $instanceId;
    private string $apiToken;
    private string $baseUrl;

    public function __construct()
    {
        $this->instanceId = config('services.greenapi.instance_id');
        $this->apiToken   = config('services.greenapi.api_token');
        $this->baseUrl    = 'https://api.green-api.com';
    }

    public function send(string $phone, string $message): bool
    {
        $chatId = $this->formatChatId($phone);

        $response = Http::timeout(10)->post(
            "{$this->baseUrl}/waInstance{$this->instanceId}/sendMessage/{$this->apiToken}",
            [
                'chatId'  => $chatId,
                'message' => $message,
            ]
        );

        if (!$response->successful()) {
            Log::error('Green API error', [
                'status'  => $response->status(),
                'body'    => $response->body(),
                'phone'   => $phone,
            ]);
            return false;
        }

        Log::info('WhatsApp sent', ['chatId' => $chatId, 'idMessage' => $response->json('idMessage')]);
        return true;
    }

    // Green API expects phone in format: 77001234567@c.us
    private function formatChatId(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        // Normalize Kazakh numbers: 8XXXXXXXXXX → 7XXXXXXXXXX
        if (strlen($digits) === 11 && str_starts_with($digits, '8')) {
            $digits = '7' . substr($digits, 1);
        }

        return $digits . '@c.us';
    }
}

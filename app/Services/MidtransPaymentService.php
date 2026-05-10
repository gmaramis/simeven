<?php

namespace App\Services;

use App\Models\Registration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransPaymentService
{
    public function isConfigured(): bool
    {
        return ! empty(config('services.midtrans.server_key'))
            && ! empty(config('services.midtrans.client_key'));
    }

    public function snapBaseUrl(): string
    {
        return config('services.midtrans.production', false)
            ? 'https://app.midtrans.com'
            : 'https://app.sandbox.midtrans.com';
    }

    /**
     * @return array{success: bool, token?: string, error?: string}
     */
    public function createSnapToken(Registration $registration): array
    {
        if (! $this->isConfigured()) {
            return ['success' => false, 'error' => 'Midtrans belum dikonfigurasi'];
        }

        $event = $registration->event;
        if (! $event || ! $event->isPaid()) {
            return ['success' => false, 'error' => 'Event tidak berbayar'];
        }

        $grossAmount = (int) round((float) $event->price);
        if ($grossAmount < 1) {
            return ['success' => false, 'error' => 'Nominal tidak valid'];
        }

        $orderId = 'S'.$registration->id.'-'.Str::lower(Str::random(8));
        $registration->update([
            'midtrans_order_id' => $orderId,
            'payment_gateway' => 'midtrans',
        ]);

        $email = $registration->user?->email ?? ('wa.'.preg_replace('/\D/', '', $registration->phone).'@guest.simeven.local');

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => Str::limit($registration->name, 40, ''),
                'email' => $email,
                'phone' => $registration->phone,
            ],
            'item_details' => [
                [
                    'id' => 'EVENT-'.$event->id,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => Str::limit($event->title, 50, ''),
                ],
            ],
        ];

        $url = $this->snapBaseUrl().'/snap/v1/transactions';
        $serverKey = config('services.midtrans.server_key');

        $response = Http::withBasicAuth($serverKey, '')
            ->acceptJson()
            ->asJson()
            ->post($url, $payload);

        if (! $response->successful()) {
            Log::warning('Midtrans Snap gagal', [
                'registration_id' => $registration->id,
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return ['success' => false, 'error' => 'Gagal membuat sesi pembayaran'];
        }

        $token = $response->json('token');
        if (! $token) {
            return ['success' => false, 'error' => 'Token pembayaran tidak diterima'];
        }

        return ['success' => true, 'token' => $token];
    }

    public function verifyNotificationSignature(array $payload): bool
    {
        $serverKey = config('services.midtrans.server_key');
        if (empty($serverKey) || empty($payload['signature_key'] ?? null)) {
            return false;
        }

        $orderId = (string) ($payload['order_id'] ?? '');
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $expected = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        return hash_equals($expected, (string) $payload['signature_key']);
    }
}

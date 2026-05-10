<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\WhatsAppMessage;
use App\Services\MidtransPaymentService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private MidtransPaymentService $midtrans,
        private WhatsAppService $whatsappService
    ) {}

    public function checkout(Registration $registration): View
    {
        if (! $registration->event || ! $registration->event->isPaid()) {
            abort(404);
        }

        $successUrl = URL::temporarySignedRoute(
            'registration.success',
            now()->addDays(7),
            ['registrationId' => $registration->id]
        );

        if ($registration->payment_status !== Registration::PAYMENT_PENDING) {
            return view('payments.already', compact('registration', 'successUrl'));
        }

        if (! $this->midtrans->isConfigured()) {
            return view('payments.unconfigured', compact('registration', 'successUrl'));
        }

        $result = $this->midtrans->createSnapToken($registration);
        if (! $result['success']) {
            return view('payments.error', [
                'registration' => $registration,
                'successUrl' => $successUrl,
                'message' => $result['error'] ?? 'Tidak dapat memulai pembayaran',
            ]);
        }

        $clientKey = config('services.midtrans.client_key');
        $snapJsUrl = $this->midtrans->snapBaseUrl().'/snap/snap.js';

        return view('payments.checkout', [
            'registration' => $registration,
            'successUrl' => $successUrl,
            'snapToken' => $result['token'],
            'clientKey' => $clientKey,
            'snapJsUrl' => $snapJsUrl,
        ]);
    }

    public function midtransNotification(Request $request)
    {
        $payload = $request->all();

        if (! $this->midtrans->verifyNotificationSignature($payload)) {
            Log::warning('Midtrans notification signature tidak valid', ['order_id' => $payload['order_id'] ?? null]);

            return response('INVALID_SIGNATURE', 400);
        }

        $orderId = $payload['order_id'] ?? null;
        if (! $orderId) {
            return response('NO_ORDER', 400);
        }

        $registration = Registration::with('event')->where('midtrans_order_id', $orderId)->first();
        if (! $registration) {
            return response('OK', 200);
        }

        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus = $payload['fraud_status'] ?? '';

        if (in_array($transactionStatus, ['settlement', 'capture'], true)) {
            if ($transactionStatus === 'capture' && $fraudStatus !== 'accept' && $fraudStatus !== '') {
                return response('OK', 200);
            }

            if ($registration->payment_status === Registration::PAYMENT_PAID) {
                return response('OK', 200);
            }

            $registration->update([
                'payment_status' => Registration::PAYMENT_PAID,
                'paid_at' => now(),
            ]);

            if (config('services.fonnte.enabled', false)) {
                try {
                    $existing = WhatsAppMessage::where('registration_id', $registration->id)
                        ->where('message_type', 'confirmation')
                        ->first();
                    if (! $existing) {
                        $whatsappMessage = WhatsAppMessage::create([
                            'registration_id' => $registration->id,
                            'message_type' => 'confirmation',
                            'phone_number' => $registration->phone,
                            'message_content' => '',
                            'status' => 'pending',
                        ]);
                        $this->whatsappService->sendConfirmationMessage($whatsappMessage);
                    }
                } catch (\Throwable $e) {
                    Log::error('WA setelah pembayaran gagal', ['registration_id' => $registration->id, 'error' => $e->getMessage()]);
                }
            }

            return response('OK', 200);
        }

        if (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'], true)) {
            if ($registration->payment_status === Registration::PAYMENT_PENDING) {
                $registration->update([
                    'payment_status' => $transactionStatus === 'expire' ? Registration::PAYMENT_EXPIRED : Registration::PAYMENT_FAILED,
                    'status' => 'cancelled',
                ]);
                $registration->event?->increment('available_seats');
            }

            return response('OK', 200);
        }

        return response('OK', 200);
    }
}

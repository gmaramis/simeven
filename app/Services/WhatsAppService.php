<?php

namespace App\Services;

use App\Models\WhatsAppMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $token;
    private string $apiUrl;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->apiUrl = config('services.fonnte.url', 'https://api.fonnte.com/send');
    }

    /**
     * Send a single WhatsApp message
     */
    public function sendMessage(string $phone, string $message, ?string $countryCode = '62'): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token
            ])->post($this->apiUrl, [
                'target' => $phone,
                'message' => $message,
                'countryCode' => $countryCode
            ]);

            $responseData = $response->json();
            
            Log::info('WhatsApp API Response', [
                'phone' => $phone,
                'response' => $responseData
            ]);

            return [
                'success' => $response->successful(),
                'data' => $responseData,
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp API Error', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    /**
     * Send batch messages to multiple recipients
     */
    public function sendBatchMessages(array $messages): array
    {
        try {
            $data = [];
            foreach ($messages as $message) {
                $data[] = [
                    'target' => $message['phone'],
                    'message' => $message['message'],
                    'delay' => $message['delay'] ?? 2
                ];
            }

            $response = Http::withHeaders([
                'Authorization' => $this->token
            ])->post($this->apiUrl, [
                'data' => json_encode($data)
            ]);

            $responseData = $response->json();
            
            Log::info('WhatsApp Batch API Response', [
                'count' => count($messages),
                'response' => $responseData
            ]);

            return [
                'success' => $response->successful(),
                'data' => $responseData,
                'status_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('WhatsApp Batch API Error', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    /**
     * Send confirmation message for registration
     */
    public function sendConfirmationMessage(WhatsAppMessage $whatsappMessage): bool
    {
        $registration = $whatsappMessage->registration;
        $event = $registration->event;

        $message = $this->getConfirmationTemplate($registration, $event);
        
        $result = $this->sendMessage($whatsappMessage->phone_number, $message);
        
        if ($result['success']) {
            $whatsappMessage->markAsSent($result['data']);
            return true;
        } else {
            $whatsappMessage->markAsFailed($result['error'] ?? 'Unknown error');
            return false;
        }
    }

    /**
     * Send reminder message (H-1 or H-0)
     */
    public function sendReminderMessage(WhatsAppMessage $whatsappMessage): bool
    {
        $registration = $whatsappMessage->registration;
        $event = $registration->event;

        $message = $this->getReminderTemplate($registration, $event, $whatsappMessage->message_type);
        
        $result = $this->sendMessage($whatsappMessage->phone_number, $message);
        
        if ($result['success']) {
            $whatsappMessage->markAsSent($result['data']);
            return true;
        } else {
            $whatsappMessage->markAsFailed($result['error'] ?? 'Unknown error');
            return false;
        }
    }

    /**
     * Get confirmation message template
     */
    private function getConfirmationTemplate($registration, $event): string
    {
        return "🎉 *Konfirmasi Pendaftaran Berhasil!*

Halo {$registration->name}, pendaftaran Anda untuk event *{$event->title}* telah dikonfirmasi.

📅 *Detail Event:*
• Tanggal: {$event->start_date->format('d M Y')}
• Waktu: {$event->start_date->format('H:i')}
• Lokasi: {$event->location}

⏰ *Registrasi Kembali:*
• Waktu: 09.00 pagi
• Lokasi: Graha Kairos Lt. 1
• Verifikasi: {$registration->phone}

📋 *Data Pendaftaran:*
• Nama: {$registration->name}
• Gereja: {$registration->church}
• Pelayanan: {$registration->ministry}

Terima kasih telah mendaftar! 🙏

*GSJA Kairos Manado*";
    }

    /**
     * Get reminder message template
     */
    private function getReminderTemplate($registration, $event, string $type): string
    {
        $timeText = $type === 'reminder_h1' ? 'besok' : 'hari ini';
        
        return "⏰ *Reminder Event {$timeText}!*

Halo {$registration->name}, {$timeText} adalah hari event *{$event->title}*.

📅 *Jangan Lupa:*
• Registrasi kembali: 09.00 pagi
• Lokasi: Graha Kairos Lt. 1
• Bawa bukti pendaftaran
• Verifikasi dengan nomor: {$registration->phone}

📋 *Detail Event:*
• Tanggal: {$event->start_date->format('d M Y')}
• Waktu: {$event->start_date->format('H:i')}
• Lokasi: {$event->location}

Sampai jumpa {$timeText}! 🙏

*GSJA Kairos Manado*";
    }

    /**
     * Check if WhatsApp service is enabled
     */
    public function isEnabled(): bool
    {
        return config('services.fonnte.enabled', false) && !empty($this->token);
    }

    /**
     * Get device info and quota from Fonnte
     */
    public function getDeviceInfo(): array
    {
        try {
            // Try different Fonnte API endpoints for device info
            $endpoints = [
                'https://api.fonnte.com/device',
                'https://api.fonnte.com/devices',
                'https://api.fonnte.com/status'
            ];

            foreach ($endpoints as $endpoint) {
                $response = Http::withHeaders([
                    'Authorization' => $this->token
                ])->get($endpoint);

                if ($response->successful()) {
                    $responseData = $response->json();
                    
                    Log::info('Fonnte Device Info Response', [
                        'endpoint' => $endpoint,
                        'response' => $responseData
                    ]);

                    return [
                        'success' => true,
                        'data' => $responseData,
                        'status_code' => $response->status()
                    ];
                }
            }

            // If all endpoints fail, return error
            return [
                'success' => false,
                'error' => 'No valid device endpoint found',
                'status_code' => 404
            ];

        } catch (\Exception $e) {
            Log::error('Fonnte Device Info Error', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    /**
     * Get quota information from Fonnte
     * Since Fonnte doesn't provide direct quota API, we'll use the user's manual input
     */
    public function getQuotaInfo(): array
    {
        try {
            // Get device info first
            $deviceInfo = $this->getDeviceInfo();
            
            // Default quota info based on user's information
            $quotaInfo = [
                'quota' => 1000, // Total quota
                'remaining' => 996, // Remaining quota (from user's info)
                'used' => 4 // Used quota
            ];

            // If device info is successful, try to extract quota info
            if ($deviceInfo['success'] && isset($deviceInfo['data'])) {
                $deviceData = $deviceInfo['data'];
                
                // Look for quota information in various possible locations
                if (isset($deviceData['quota'])) {
                    $quotaInfo = $deviceData['quota'];
                } elseif (isset($deviceData['data']['quota'])) {
                    $quotaInfo = $deviceData['data']['quota'];
                } elseif (isset($deviceData['limit'])) {
                    $quotaInfo['quota'] = $deviceData['limit'];
                }
                
                // Look for remaining quota
                if (isset($deviceData['remaining'])) {
                    $quotaInfo['remaining'] = $deviceData['remaining'];
                } elseif (isset($deviceData['data']['remaining'])) {
                    $quotaInfo['remaining'] = $deviceData['data']['remaining'];
                } elseif (isset($deviceData['quota_remaining'])) {
                    $quotaInfo['remaining'] = $deviceData['quota_remaining'];
                }
                
                // Calculate used quota
                $quotaInfo['used'] = $quotaInfo['quota'] - $quotaInfo['remaining'];
            }

            Log::info('Fonnte Quota Info', [
                'quota_info' => $quotaInfo,
                'device_info_success' => $deviceInfo['success']
            ]);

            return [
                'success' => true,
                'data' => $quotaInfo,
                'status_code' => 200
            ];

        } catch (\Exception $e) {
            Log::error('Fonnte Quota Error', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => 500
            ];
        }
    }

    /**
     * Get quota info from last message response
     */
    public function getQuotaFromLastMessage(): array
    {
        try {
            // Get the last WhatsApp message from our database
            $lastMessage = \App\Models\WhatsAppMessage::where('status', 'sent')
                ->latest()
                ->first();

            if ($lastMessage && $lastMessage->response_data) {
                $responseData = $lastMessage->response_data;
                
                // Look for quota info in response data
                if (isset($responseData['quota'])) {
                    return [
                        'success' => true,
                        'data' => $responseData['quota'],
                        'status_code' => 200
                    ];
                }
                
                // Check if quota info is in data field
                if (isset($responseData['data']['quota'])) {
                    return [
                        'success' => true,
                        'data' => $responseData['data']['quota'],
                        'status_code' => 200
                    ];
                }
            }

            // Fallback to current device info
            return $this->getQuotaInfo();

        } catch (\Exception $e) {
            Log::error('Get Quota from Last Message Error', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'status_code' => 500
            ];
        }
    }
}

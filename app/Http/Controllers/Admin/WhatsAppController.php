<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\WhatsAppMessage;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    public function __construct(private WhatsAppService $whatsappService)
    {
        //
    }

    /**
     * Show WhatsApp dashboard
     */
    public function index()
    {
        $stats = [
            'total_messages' => WhatsAppMessage::count(),
            'sent_messages' => WhatsAppMessage::where('status', 'sent')->count(),
            'pending_messages' => WhatsAppMessage::where('status', 'pending')->count(),
            'failed_messages' => WhatsAppMessage::where('status', 'failed')->count(),
        ];

        $recentMessages = WhatsAppMessage::with(['registration.event'])
            ->latest()
            ->take(10)
            ->get();

        $events = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->get()
            ->filter(function ($event) {
                return $event->isPublished();
            });

        return view('admin.whatsapp.index', compact('stats', 'recentMessages', 'events'));
    }

    /**
     * Show messages for a specific event
     */
    public function eventMessages(Event $event)
    {
        $messages = WhatsAppMessage::with(['registration'])
            ->whereHas('registration', function ($query) use ($event) {
                $query->where('event_id', $event->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => $messages->total(),
            'sent' => $messages->where('status', 'sent')->count(),
            'pending' => $messages->where('status', 'pending')->count(),
            'failed' => $messages->where('status', 'failed')->count(),
        ];

        return view('admin.whatsapp.event-messages', compact('event', 'messages', 'stats'));
    }

    /**
     * Send confirmation message for a registration
     */
    public function sendConfirmation(Request $request, Registration $registration)
    {
        try {
            // Check if message already exists
            $existingMessage = WhatsAppMessage::where('registration_id', $registration->id)
                ->where('message_type', 'confirmation')
                ->first();

            if ($existingMessage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan konfirmasi sudah dikirim sebelumnya'
                ]);
            }

            // Create WhatsApp message record
            $whatsappMessage = WhatsAppMessage::create([
                'registration_id' => $registration->id,
                'message_type' => 'confirmation',
                'phone_number' => $registration->phone,
                'message_content' => '', // Will be set by service
                'status' => 'pending'
            ]);

            // Send the message
            $success = $this->whatsappService->sendConfirmationMessage($whatsappMessage);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan konfirmasi berhasil dikirim'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim pesan konfirmasi'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp confirmation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Send reminder messages for an event
     */
    public function sendReminders(Request $request, Event $event)
    {
        $type = $request->input('type', 'reminder_h1'); // reminder_h1 or reminder_h0
        
        try {
            $registrations = Registration::where('event_id', $event->id)
                ->where('is_confirmed', true)
                ->get();

            $sentCount = 0;
            $failedCount = 0;

            foreach ($registrations as $registration) {
                // Check if message already exists
                $existingMessage = WhatsAppMessage::where('registration_id', $registration->id)
                    ->where('message_type', $type)
                    ->first();

                if ($existingMessage) {
                    continue; // Skip if already sent
                }

                // Create WhatsApp message record
                $whatsappMessage = WhatsAppMessage::create([
                    'registration_id' => $registration->id,
                    'message_type' => $type,
                    'phone_number' => $registration->phone,
                    'message_content' => '', // Will be set by service
                    'status' => 'pending'
                ]);

                // Send the message
                $success = $this->whatsappService->sendReminderMessage($whatsappMessage);

                if ($success) {
                    $sentCount++;
                } else {
                    $failedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengirim {$sentCount} pesan reminder, {$failedCount} gagal"
            ]);

        } catch (\Exception $e) {
            Log::error('WhatsApp reminder error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Retry failed message
     */
    public function retryMessage(WhatsAppMessage $message)
    {
        try {
            $message->update(['status' => 'pending', 'error_message' => null]);

            if ($message->message_type === 'confirmation') {
                $success = $this->whatsappService->sendConfirmationMessage($message);
            } else {
                $success = $this->whatsappService->sendReminderMessage($message);
            }

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan berhasil dikirim ulang'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim ulang pesan'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('WhatsApp retry error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get message statistics
     */
    public function stats()
    {
        $stats = [
            'total_messages' => WhatsAppMessage::count(),
            'sent_messages' => WhatsAppMessage::where('status', 'sent')->count(),
            'pending_messages' => WhatsAppMessage::where('status', 'pending')->count(),
            'failed_messages' => WhatsAppMessage::where('status', 'failed')->count(),
            'confirmation_messages' => WhatsAppMessage::where('message_type', 'confirmation')->count(),
            'reminder_messages' => WhatsAppMessage::whereIn('message_type', ['reminder_h1', 'reminder_h0'])->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get Fonnte device and quota information
     */
    public function getFonnteInfo()
    {
        try {
            $deviceInfo = $this->whatsappService->getDeviceInfo();
            $quotaInfo = $this->whatsappService->getQuotaFromLastMessage();

            return response()->json([
                'success' => true,
                'device' => $deviceInfo,
                'quota' => $quotaInfo
            ]);

        } catch (\Exception $e) {
            Log::error('Fonnte info error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}

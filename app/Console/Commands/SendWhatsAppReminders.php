<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Registration;
use App\Models\WhatsAppMessage;
use App\Services\WhatsAppService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendWhatsAppReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:send-reminders {--type=all : Type of reminder (h1, h0, or all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send automatic WhatsApp reminders for upcoming events';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsappService)
    {
        $type = $this->option('type');
        
        $this->info('🤖 Starting automatic WhatsApp reminders...');
        
        if (!$whatsappService->isEnabled()) {
            $this->error('❌ WhatsApp service is not enabled!');
            return 1;
        }

        $sentCount = 0;
        $failedCount = 0;

        // Get events that need reminders
        $events = $this->getEventsForReminders($type);
        
        if ($events->isEmpty()) {
            $this->info('✅ No events need reminders at this time.');
            return 0;
        }

        $this->info("📅 Found {$events->count()} events that need reminders");

        foreach ($events as $event) {
            $this->info("🎯 Processing event: {$event->title}");
            
            // Get confirmed registrations for this event
            $registrations = Registration::where('event_id', $event->id)
                ->where('status', 'confirmed')
                ->get();

            $this->info("👥 Found {$registrations->count()} confirmed participants");

            foreach ($registrations as $registration) {
                $reminderType = $this->getReminderType($event, $type);
                
                if (!$reminderType) {
                    continue;
                }

                // Check if reminder already sent
                $existingMessage = WhatsAppMessage::where('registration_id', $registration->id)
                    ->where('message_type', $reminderType)
                    ->first();

                if ($existingMessage) {
                    $this->line("⏭️  Reminder already sent to {$registration->name}");
                    continue;
                }

                try {
                    // Create WhatsApp message record
                    $whatsappMessage = WhatsAppMessage::create([
                        'registration_id' => $registration->id,
                        'message_type' => $reminderType,
                        'phone_number' => $registration->phone,
                        'message_content' => '', // Will be set by service
                        'status' => 'pending'
                    ]);

                    // Send the reminder
                    $success = $whatsappService->sendReminderMessage($whatsappMessage);

                    if ($success) {
                        $sentCount++;
                        $this->info("✅ Reminder sent to {$registration->name} ({$registration->phone})");
                    } else {
                        $failedCount++;
                        $this->error("❌ Failed to send reminder to {$registration->name}");
                    }

                } catch (\Exception $e) {
                    $failedCount++;
                    $this->error("❌ Error sending reminder to {$registration->name}: {$e->getMessage()}");
                    Log::error('WhatsApp reminder error', [
                        'registration_id' => $registration->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $this->info("🎉 Reminder process completed!");
        $this->info("✅ Successfully sent: {$sentCount}");
        $this->info("❌ Failed: {$failedCount}");

        return 0;
    }

    /**
     * Get events that need reminders
     */
    private function getEventsForReminders(string $type): \Illuminate\Database\Eloquent\Collection
    {
        $now = now();
        
        $query = Event::where('status', 'published')
            ->where('start_date', '>', $now);

        if ($type === 'h1') {
            // Events happening tomorrow (H-1)
            $tomorrow = $now->addDay()->startOfDay();
            $query->whereBetween('start_date', [
                $tomorrow,
                $tomorrow->copy()->endOfDay()
            ]);
        } elseif ($type === 'h0') {
            // Events happening today (H-0)
            $today = $now->startOfDay();
            $query->whereBetween('start_date', [
                $today,
                $today->copy()->endOfDay()
            ]);
        } else {
            // All upcoming events (for testing)
            $query->where('start_date', '<=', $now->addDays(7));
        }

        return $query->get();
    }

    /**
     * Determine reminder type based on event timing
     */
    private function getReminderType(Event $event, string $type): ?string
    {
        $now = now();
        $eventDate = $event->start_date->startOfDay();
        $daysUntilEvent = $now->startOfDay()->diffInDays($eventDate, false);

        if ($type === 'h1' && $daysUntilEvent === 1) {
            return 'reminder_h1';
        } elseif ($type === 'h0' && $daysUntilEvent === 0) {
            return 'reminder_h0';
        } elseif ($type === 'all') {
            if ($daysUntilEvent === 1) {
                return 'reminder_h1';
            } elseif ($daysUntilEvent === 0) {
                return 'reminder_h0';
            }
        }

        return null;
    }
}

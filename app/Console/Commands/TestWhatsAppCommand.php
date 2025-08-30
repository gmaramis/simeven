<?php

namespace App\Console\Commands;

use App\Services\WhatsAppService;
use Illuminate\Console\Command;

class TestWhatsAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:test {phone : Phone number to test (with country code)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test WhatsApp API integration with Fonnte';

    /**
     * Execute the console command.
     */
    public function handle(WhatsAppService $whatsappService)
    {
        $phone = $this->argument('phone');
        
        $this->info('🔧 Testing WhatsApp API Integration...');
        $this->info("📱 Target Phone: {$phone}");
        
        // Check if service is enabled
        if (!$whatsappService->isEnabled()) {
            $this->error('❌ WhatsApp service is not enabled!');
            $this->info('Please check your .env configuration:');
            $this->info('- FONNTE_API_TOKEN');
            $this->info('- WHATSAPP_ENABLED=true');
            return 1;
        }
        
        $this->info('✅ WhatsApp service is enabled');
        
        // Test message
        $testMessage = "🧪 *Test WhatsApp API*

Halo! Ini adalah pesan test dari sistem event GSJA Kairos Manado.

📅 *Detail Test:*
• Waktu: " . now()->format('d M Y H:i:s') . "
• Status: API Integration Test
• Platform: Laravel + Fonnte

Jika Anda menerima pesan ini, berarti integrasi WhatsApp API berhasil! 🎉

*GSJA Kairos Manado*";
        
        $this->info('📤 Sending test message...');
        
        try {
            $result = $whatsappService->sendMessage($phone, $testMessage);
            
            if ($result['success']) {
                $this->info('✅ Message sent successfully!');
                $this->info('📊 Response: ' . json_encode($result['data'], JSON_PRETTY_PRINT));
            } else {
                $this->error('❌ Failed to send message');
                $this->error('Error: ' . ($result['error'] ?? 'Unknown error'));
                $this->error('Status Code: ' . $result['status_code']);
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Exception occurred: ' . $e->getMessage());
            return 1;
        }
        
        $this->info('🎉 WhatsApp API test completed successfully!');
        return 0;
    }
}

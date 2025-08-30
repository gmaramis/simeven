<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->enum('message_type', ['confirmation', 'reminder_h1', 'reminder_h0'])->comment('Type of message sent');
            $table->string('phone_number', 20)->comment('Recipient phone number');
            $table->text('message_content')->comment('Content of the message sent');
            $table->timestamp('sent_at')->nullable()->comment('When the message was sent');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending')->comment('Message delivery status');
            $table->json('response_data')->nullable()->comment('API response data from Fonnte');
            $table->text('error_message')->nullable()->comment('Error message if failed');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['registration_id', 'message_type']);
            $table->index(['status', 'sent_at']);
            $table->index('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};

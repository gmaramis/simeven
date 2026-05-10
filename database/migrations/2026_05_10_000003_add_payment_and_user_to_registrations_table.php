<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('payment_status', 30)->default('not_applicable')->after('status');
            $table->string('payment_gateway', 30)->nullable()->after('payment_status');
            $table->string('midtrans_order_id', 100)->nullable()->unique()->after('payment_gateway');
            $table->timestamp('paid_at')->nullable()->after('midtrans_order_id');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn([
                'payment_status',
                'payment_gateway',
                'midtrans_order_id',
                'paid_at',
            ]);
        });
    }
};
